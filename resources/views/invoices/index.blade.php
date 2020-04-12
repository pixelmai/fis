@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Invoices</h1>
      </div>
      <div>
        <a href="/invoices/create" class="btn btn-lg btn-success">Add Invoices</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col" class="col_checkbox">&nbsp;</th>
              <th scope="col">ID</th>
              <th scope="col">Client Name</th>
              <th scope="col">Company</th>
              <th scope="col">Project</th>
              <th scope="col">Status</th>
              <th scope="col">Date Created</th>
              <th scope="col">Due Date</th>
              <th scope="col"><div class="price">Total</div></th>
              <th scope="col" class="col_actions"/>
                <button type="button" name="bulk_deac" id="bulk_deac" class="btn btn-danger btn-sm d-none">Deactivate All</i></button>
                <button type="button" name="bulk_acti" id="bulk_acti" class="btn btn-success btn-sm d-none">Activate All</i></button>
              </th>
            </tr>
          </thead>
        
        </table>

    </div>
  </div>
</div>

@stop

@push('modals')
@endpush


@push('scripts')
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

  <script>
    $(document).ready( function () {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#listpage_datatable').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
              url: "/invoices",
              type: 'GET',
              data: function (d) {
                d.active_status = $('#active_status').children("option:selected").val();
              }
             },
              createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                if(data.is_deactivated == 1){
                  $( row ).addClass('deactivated');
                }
              },
             columns: [
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'id', name: 'id'},
                      { data: 'client_name', name: 'client_name' },
                      { data: 'company_name', name: 'company_name' },
                      { data: 'project_name', name: 'project_name' },
                      { data: 'status', name: 'status' },
                      { data: 'created', name: 'created' },
                      { data: 'due_date', name: 'due_date' },
                      { data: 'total', name: 'total', orderable: false, searchable: false},
                      {data: 'action', name: 'action', orderable: false,  searchable:false},
                   ],
            order: [[2, 'asc'], [3, 'asc']],
      });



      $('#listpage_datatable tbody').on('click', '.tbl_row_checkbox', function () {
          $(this).parent().parent().toggleClass('rowselected');
          var as = $('#active_status').children("option:selected").val();

          if ( document.querySelector('.rowselected') !== null ) {
            if(as == 0){
              $('#bulk_deac').removeClass('d-none');
              $('#bulk_acti').addClass('d-none');
            }else if(as == 1){
              $('#bulk_deac').addClass('d-none');
              $('#bulk_acti').removeClass('d-none');
            }
          }else{
            $('#bulk_deac').addClass('d-none');
            $('#bulk_acti').addClass('d-none');
          }

      } );


 

      /* Append Status Select Box */
        var activeStatusHTML = '<div id="active_status_container"><label for="status" class="col-form-label">Showing</label><select id="active_status" name="active_status"><option value="0">All</option>@foreach($status as $statnum => $statdesc) <option value="{{ $statnum }}">{{ $statdesc }}</option> @endforeach </select><span class="divider d-none d-sm-inline">|</span></div>'; 

        $('#listpage_datatable_filter').prepend(activeStatusHTML); //Add field html

        $( "#active_status" ).change(function() {
          var oTable = $('#listpage_datatable').dataTable(); 
          oTable.fnDraw(false);
        });
      /* Append Status Select Box */
      








    }); //end document ready




  </script>
@endpush




