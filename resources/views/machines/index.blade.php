@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Machines</h1>
      </div>
      <div>
        <a href="/machines/create" class="btn btn-lg btn-success">Add Machine</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">





        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col">&nbsp;</th>
              <th scope="col">&nbsp;</th>
              <th scope="col" class="col_checkbox">&nbsp;</th>
              <th scope="col">Name</th>
              <th scope="col">Brand</th>
              <th scope="col">Model</th>
              <th scope="col">Status</th>
              <th scope="col">Suppliers</th>
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
  @include('tools.modalAddLogs')
@endpush


@push('scripts')
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>

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
          url: "/machines",
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
                { data: 'id', name: 'id', 'visible': false},
                { data: 'updated', name: 'updated', 'visible': false},
                { data: 'checkbox', orderable:false, searchable:false},
                { data: 'name', name: 'name' },
                { data: 'brand', name: 'brand' },
                { data: 'model', name: 'model' },
                { data: 'status', name: 'status' },
                { data: 'number', name: 'number', orderable: false, searchable:false },
                {data: 'action', name: 'action', orderable: false,  searchable:false},
             ],
        order: [[1, 'desc']]
              });


      $('#listpage_datatable tbody').on('click', '.tbl_row_checkbox', function () {
          $(this).parent().parent().toggleClass('rowselected');

          if ( document.querySelector('.rowselected') !== null ) {
            $('#bulk_status').removeClass('d-none');
          }else{
            $('#bulk_status').addClass('d-none');
          }

      } );


      $('body').on('click', '#delete-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/machines/destroy/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a machine.',
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


      $('body').on('click', '#deactivate-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to deactivate row?')) {

          $.ajax({
              type: "get",
              url: "/machines/deactivate/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deactivated a machine.',
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

      $('body').on('click', '#activate-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to activate row?')) {

          $.ajax({
              type: "get",
              url: "/machines/activate/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'success',
                  message: 'Successfully activated a machine.',
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
        var row_id = $(this).data("id");
        $('#ajaxForm #tool_id').val(row_id);
        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');
        $('#btn-multiple-save-status').addClass('d-none');
        $('#btn-single-save-status').removeClass('d-none');
      });   


      $('body').on('click', '#btn-single-save-status', function () {
        initvalidator($('#tool_id').val());
      });   


      $('body').on('click', '#btn-multiple-save-status', function () {
        var id = [];
        $('.tbl_row_checkbox:checked').each(function(){
           id.push($(this).val());
        });

        initvalidator(id);
      });   



      $(document).on('click', '#bulk_status', function(){
          var id = [];
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



      function initvalidator(ids){
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
            },
            notes: {
              required: true
            }
          },
          messages: {
            status: " (required)",
            notes: " (required)",
          },
          submitHandler: function(form) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

        
            var formData = {
              status: $('#status').children("option:selected").val(),
              notes: $('#notes').val(),
              updatedby_id: $('#updatedby_id').val(),
            };

            var state = jQuery('#btn-save').val();
            var type = "POST";

            $.ajax({
                type: type,
                url: "/machines/status",
                data: { "formData" : formData, "id": ids } ,
                dataType: 'json',
                success: function (data) {
                  $('#ajax-crud-modal').trigger("reset");
                  $('#ajax-crud-modal').modal('hide');
                  var oTable = $('#listpage_datatable').dataTable(); 
                  oTable.fnDraw(false);

                  var notifData = {
                    status: 'success',
                    message: 'Successfully updated status of the selected ' + data + ' machines.',
                  };

                  generateNotif(notifData);
                  $('#bulk_status').addClass('d-none');
                },
                error: function (data) {
                  console.log('Error:', data);
                }
            });

          },
        });

      }

      var activeStatusHTML = '<div id="active_status_container"><label for="status" class="col-form-label">Showing</label><select id="active_status" name="active_status"><option value="0">Active</option><option value="1">Inactive</option><option value="2">All</option></select><span class="divider d-none d-sm-inline">|</span></div>';  

      $('#listpage_datatable_filter').prepend(activeStatusHTML); //Add field html

        $( "#active_status" ).change(function() {
          var oTable = $('#listpage_datatable').dataTable(); 
          oTable.fnDraw(false);
        });


    }); //end document ready




  </script>
@endpush



