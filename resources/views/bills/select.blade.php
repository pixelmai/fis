@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <div class="bh">Select Invoice for Official Bill</div>
        </div>

          <div class="card-body">

            <div id="select_invoice_official_bill">
              <table id="listpage_datatable" class="table table-responsive-md" data-page-length="10">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Client Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Issue Date</th>
                    <th scope="col"><div class="price">Total</div></th>
                  </tr>
                </thead>
              
              </table>
            </div>



            <div class="row py-2">
              <div class="col-12">

                <input type="hidden" id="invoice_selid" name="invoice_selid" value="">

                <button id="submit_button" type="submit" class="btn btn-primary btn-lg">Proceed</button>

              </div>
            </div>

          </form>

        </div>


      </div>
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
    var id = '';

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#listpage_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
            url: "/bills/select",
            type: 'GET',
            data: function (d) {
              $('#invoice_selid').val('');
            }
           },
            createdRow: function( row, data, dataIndex ) {
              // Set the data-status attribute, and add a class
              if(data.is_deactivated == 1){
                $( row ).addClass('deactivated');
              }
              $( row ).addClass('clickable-row');
            },
           columns: [
                    { data: 'id', name: 'id', visible: false},
                    { data: 'invoice_id', name: 'invoice_id'},
                    { data: 'status', name: 'status' },
                    { data: 'client_name', name: 'client_name' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'total', name: 'total', orderable: false, searchable: false},
                 ],
          order: [[0, 'desc']],
    });

    $('#listpage_datatable tbody').on('click', '.clickable-row', function () {
        $('.clickable-row').removeClass('rowselected');
        $(this).toggleClass('rowselected');
        $('#invoice_selid').val(parseInt($(this).children().find('.iid').text()));
    });



    $('body').on('click', '#submit_button', function () {
      if ($('#invoice_selid').val() == '') {
        alert('Please select an invoice to proceed');
      }else{
        location.href = '/bills/create/' + $('#invoice_selid').val();
      }
    });  



  }); //end document ready


  </script>


@endpush
