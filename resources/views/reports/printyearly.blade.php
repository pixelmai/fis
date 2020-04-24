@extends('layouts.print')
@section('content')
       
<div id="reports_page" class="px-3">

  <div class="row pb-3">
    <div class="col-lg-12">
      <h1 class="pt-1 pb-0">FABLAB UP CEBU Transactions Update Report</h1>
      <h4>Year {{ $y }}</h4>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Invoice</th>
              <th scope="col">Client Name</th>
              <th scope="col">Company</th>
              <th scope="col">Position</th>
              <th scope="col" class="text-center">Sector</th>
              <th scope="col" class="text-center">Food</th>
              <th scope="col" class="text-center">MSME Classification</th>
              <th scope="col" class="text-center">M</th>
              <th scope="col" class="text-center">F</th>
              <th scope="col" class="text-center">Y</th>
              <th scope="col" class="text-center">SC</th>
              <th scope="col" class="text-center">PWD</th>
              <th scope="col">Project</th>
              <th scope="col">Jobs</th>
              <th scope="col">Date</th>
              <th scope="col"><div class="price text-right">Subtotal</div></th>
              <th scope="col"><div class="price text-right">Discount</div></th>
              <th scope="col"><div class="price text-right">Total</div></th>
            </tr>
          </thead>
        </table>

        <div id ="gt" class="d-flex justify-content-end">
          <div id="gt_label" class="align-self-center">Total</div>
          <div id="grand_total"></div>
        </div>


        <div id="prepared_by" class="row pt-5">
          <div class="col-12">
            <strong>Prepared by:</strong>
            <br /><br /><br /><br /><br />
            <span class="user_name">{{ $user->fname }} {{ $user->lname }}</u></span>
            <em>{{ $user->position }}</em>
          </div>
        </div>
        
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
      var grandtotal = 0;
      var rowtotal = 0;

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
              url: '{{ Request::url() }}',
              type: 'GET',
             },
              createdRow: function( row, data, dataIndex ) {
                rowtotal = $( row ).children('td').find('.total').val();
                rowtotal = parseFloat(rowtotal);
                grandtotal = grandtotal + rowtotal;
                $('#grand_total').text(grandtotal.toFixed(2));
              },
             columns: [
                      { data: 'id', name: 'id',  searchable: false},
                      { data: 'client_name', name: 'client_name', orderable: false, searchable: false },
                      { data: 'company_name', name: 'company_name', orderable: false, searchable: false },
                      { data: 'position', name: 'position', orderable: false, searchable: false },
                      { data: 'sector', name: 'sector', orderable: false, searchable: false },
                      { data: 'food', name: 'food', orderable: false, searchable: false },
                      { data: 'msme', name: 'msme', orderable: false, searchable: false },
                      { data: 'male', name: 'male', orderable: false, searchable: false },
                      { data: 'female', name: 'female', orderable: false, searchable: false },
                      { data: 'youth', name: 'youth', orderable: false, searchable: false },
                      { data: 'sc', name: 'sc', orderable: false, searchable: false },
                      { data: 'pwd', name: 'pwd', orderable: false, searchable: false },


                      { data: 'project_name', name: 'project_name', orderable: false, searchable: false },
                      { data: 'jobs', name: 'jobs', orderable: false, searchable: false },
                      { data: 'created', name: 'created', orderable: false, searchable: false },
                      { data: 'subtotal', name: 'subtotal', orderable: false, searchable: false},
                      { data: 'discount', name: 'discount', orderable: false, searchable: false},
                      { data: 'fancy_total', name: 'fancy_total', orderable: false, searchable: false},
                   ],
            order: [[0, 'desc']],
      });




    }); //end document ready




  </script>
@endpush


@push('inpagecss')
<style type="text/css" media="print">
  /* @page {size:landscape}  */ 
  @media print {

    @page {size: A4 landscape; max-height:100%; max-width:100%}

    body
    {
      width:100%;
      height:100%;
    }
</style>
@endpush




