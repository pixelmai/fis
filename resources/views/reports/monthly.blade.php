@extends('layouts.app')


@section('content')
       
<div id="reports_page" class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between justify-content-center">
        <h1 class="pt-1 pb-0">Monthly Reports</h1>

        <div class="d-flex">
          <div id="filters_container">
            <label for="months" class="col-form-label">Showing </label>
            <div id="months_container" class="filter_container">
              <select id="month" name="month">
                @foreach($months as $key => $month) 
                  <option value="{{ $key }}" @if(date('m') == $key) selected @endif>{{ $month }}</option> 
                @endforeach 
              </select>
            </div>
            <div id="years_container" class="filter_container">
              <select id="year" name="year">
                @for($i = 2016; $i <= date('Y'); $i++ )
                  <option value="{{ $i }}" @if(date('Y') == $i) selected @endif>{{ $i }}</option> 
                @endfor 
              </select>
            </div>
            <div id="button_container" class="filter_container">
              <a href="/reports/monthly/print/{{ date('m') }}/{{ date('Y') }}" id="print_button" class="btn btn-md btn-secondary">Print View</a>
            </div>
          </div>
        </div>
    </div>
  </div>




  <div class="row justify-content-center">
    <div id="invoices_page" class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Status</th>
              <th scope="col">Client Name</th>
              <th scope="col">Company</th>
              <th scope="col">Project</th>
              <th scope="col">Date Created</th>
              <th scope="col">Due Date</th>
              <th scope="col"><div class="price">Total</div></th>
            </tr>
          </thead>
        
        </table>

    </div>
  </div>
</div>

@stop

@push('modals')
  @include('invoices.modalSetStatus')
@endpush


@push('scripts')
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

  <script>
    $(document).ready( function () {

      var month = $('#month').children("option:selected").val();
      var year = $('#year').children("option:selected").val();

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#listpage_datatable').DataTable({
             processing: true,
             serverSide: true,
             paging: false,
             searching: false,
             ajax: {
              url: "/reports/monthly/",
              type: 'GET',
              data: function (d) {
                d.month = month;
                d.year = year;
              }
             },
              createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                if(data.is_deactivated == 1){
                  $( row ).addClass('deactivated');
                }
              },
             columns: [
                      { data: 'id', name: 'id',  searchable: false},
                      { data: 'status', name: 'status', orderable: false, searchable: false },
                      { data: 'client_name', name: 'client_name', orderable: false, searchable: false },
                      { data: 'company_name', name: 'company_name', orderable: false, searchable: false },
                      { data: 'project_name', name: 'project_name', orderable: false, searchable: false },
                      { data: 'created', name: 'created', orderable: false, searchable: false },
                      { data: 'due_date', name: 'due_date', orderable: false, searchable: false },
                      { data: 'total', name: 'total', orderable: false, searchable: false},
                   ],
            order: [[0, 'desc']],
      });


      $( "#month" ).change(function() {
        month = $('#month').children("option:selected").val();
        year = $('#year').children("option:selected").val();
        var print_url = '/reports/monthly/print/' + month + '/' + year;
        $('#print_button').attr("href", print_url ); // Set herf value
        
        var oTable = $('#listpage_datatable').dataTable(); 

        oTable.fnDraw(false);
      });

      $( "#year" ).change(function() {
        month = $('#month').children("option:selected").val();
        year = $('#year').children("option:selected").val();
        var print_url = '/reports/monthly/print/' + month + '/' + year;
        $('#print_button').attr("href", print_url ); // Set herf value

        var oTable = $('#listpage_datatable').dataTable(); 
        oTable.fnDraw(false);
      });
      /* Append Status Select Box */
      





    }); //end document ready




  </script>
@endpush




