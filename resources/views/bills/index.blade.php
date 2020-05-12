@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Official Bills</h1>
      </div>
      <div>
        <a href="/bills/select" class="btn btn-lg btn-success">Add Official Bill</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div id="invoices_page" class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="10">
          <thead class="thead-dark">
            <tr>
              <th scope="col" class="col_checkbox">&nbsp;</th>
              <th scope="col">&nbsp;</th>
              <th scope="col">Invoice ID</th>
              <th scope="col">Status</th>
              <th scope="col">Client Name</th>
              <th scope="col">Company</th>
              <th scope="col">Jobs</th>
              <th scope="col">Billing Date</th>
              <th scope="col"><div class="price">Total</div></th>
              <th scope="col" class="col_actions"/>
                <button type="button" name="bulk_status" id="bulk_status" class="btn btn-primary btn-sm d-none">Set Status</i></button>
              </th>
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
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>

  <script>
    $(document).ready( function () {
      var id = [];
      var row_id = 0;
      var row_url = '';

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#listpage_datatable').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
              url: "/bills",
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

                row_url = '/bills/view/' +  parseInt(data.id); 
                $( row ).addClass('clickable-row').attr("data-href", row_url );

                $(document).on('click','.clickable-row',function() {
                    window.location = $(this).data("href");
                });

                $(document).on('click', '.clickable-row td:first-child', function(e) { e.stopPropagation() });

                $(document).on('click', '.clickable-row td:last-child', function(e) { e.stopPropagation() });

              },
             columns: [
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'id', name: 'id', visible: false},
                      { data: 'invoice_id', name: 'invoice_id'},
                      { data: 'status', name: 'status' },
                      { data: 'for_name', name: 'for_name' },
                      { data: 'for_company', name: 'for_company' },
                      { data: 'invoice.jobs', name: 'invoice.jobs' },
                      { data: 'billing_date', name: 'billing_date' },
                      { data: 'total', name: 'total', orderable: false, searchable: false},
                      {data: 'action', name: 'action', orderable: false,  searchable:false},
                   ],
            order: [[1, 'desc']],
      });




      $('#listpage_datatable tbody').on('click', '.tbl_row_checkbox', function () {
          $(this).parent().parent().toggleClass('rowselected');
          id = [];
          id.length = 0;

          if ( document.querySelector('.rowselected') !== null ) {
            $('#bulk_status').removeClass('d-none');
          }else{
            $('#bulk_status').addClass('d-none');
          }
      });

 

      /* Append Status Select Box */
        var activeStatusHTML = '<div id="active_status_container"><label for="status" class="col-form-label">Showing</label><select id="active_status" name="active_status"><option value="0">All</option>@foreach($status as $statnum => $statdesc) <option value="{{ $statnum }}">{{ $statdesc }}</option> @endforeach </select><span class="divider d-none d-sm-inline">|</span></div>'; 

        $('#listpage_datatable_filter').prepend(activeStatusHTML); //Add field html

        $( "#active_status" ).change(function() {
          var oTable = $('#listpage_datatable').dataTable(); 
          oTable.fnDraw(false);
        });
      /* Append Status Select Box */
      

      $('body').on('click', '#delete-row', function () {
        row_id = $(this).data("id");

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/bills/destroy/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted an official bill.',
                };

                generateNotif(notifData);
                //$('#bulk_delete').addClass('d-none');

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   



      $('body').on('click', '#add-log-row', function () {
        id = [];
        row_id = $(this).data("id");

        $('#ajax-crud-modal').trigger("reset");
        $('#ajaxForm #invoice_id').val(row_id);
        $('#ajax-crud-modal').modal('show');
        $('#btn-multiple-save-status').addClass('d-none');
        $('#btn-single-save-status').removeClass('d-none');
      });   


      $('body').on('click', '#btn-single-save-status', function () {
        initvalidator($('#invoice_id').val());
      });   


      $('body').on('click', '#btn-multiple-save-status', function () {
        id = [];

        $('.tbl_row_checkbox:checked').each(function(){
           id.push($(this).val());
        });
        console.log('btn-multiple-save-status: '+id);
        initvalidator(id);
      });   



      $(document).on('click', '#bulk_status', function(){
        id = [];
        id.length = 0;

        $('.tbl_row_checkbox:checked').each(function(){
           id.push($(this).val());
        });
        if(id.length > 0)
        {
          $('#ajax-crud-modal').trigger("reset");
          $('#ajax-crud-modal').modal('show');
          $('#btn-single-save-status').addClass('d-none');
          $('#btn-multiple-save-status').removeClass('d-none');
        }
        else
        {
          alert("Please select atleast one checkbox");
        }
    
      });



      function initvalidator(idx){

        var validator = $("#ajaxForm").validate({
          errorPlacement: function(error, element) {
            // Append error within linked label
            $( element )
              .closest( "form" )
                .find( "label[for='" + element.attr( "id" ) + "']" )
                  .append( error );
          },
          errorElement: "span",
          rules: {
            status: {
              required: true
            }
          },
          messages: {
            status: " (required)",
          },
          submitHandler: function(form) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

        
            var formData = {
              status: $('#status').children("option:selected").val(),
              updatedby_id: $('#updatedby_id').val(),
            };

            var state = jQuery('#btn-save').val();
            var type = "POST";

            $.ajax({
                type: type,
                url: "/invoices/status",
                data: { "formData" : formData, "id": idx } ,
                dataType: 'json',
                success: function (data) {
                  $('#ajax-crud-modal').trigger("reset");
                  $('#ajax-crud-modal').modal('hide');
                  var oTable = $('#listpage_datatable').dataTable(); 
                  oTable.fnDraw(false);

                  var notifData = {
                    status: 'success',
                    message: 'Successfully updated status of the selected ' + data + ' invoices.',
                  };

                  generateNotif(notifData);
                  $('#bulk_status').addClass('d-none');

                  console.table(idx);
                  validator.destroy();

                },
                error: function (data) {
                  console.log('Error:', data);
                }
            });

          },
        });

      }






    }); //end document ready




  </script>
@endpush




