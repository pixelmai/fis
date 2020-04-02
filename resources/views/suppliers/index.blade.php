@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Suppliers</h1>
      </div>
      <div>
        <a href="suppliers/create" class="btn btn-lg btn-success">Add Supplier</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col">&nbsp;</th>
              <th scope="col" class="col_checkbox">&nbsp;</th>
              <th scope="col">Name</th>
              <th scope="col">Contact Person</th>
              <th scope="col">Email</th>
              <th scope="col">Number</th>
              <th scope="col">URL</th>
              <th scope="col">Specialty</th>
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
  @include('projects.modalSetStatus')
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
              url: "/suppliers",
              type: 'GET',
             },
             columns: [
                      { data: 'id', name: 'id', 'visible': false},
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'name', name: 'name' },
                      { data: 'contact_person', name: 'contact_person' },
                      { data: 'email', name: 'email', orderable: false },
                      { data: 'number', name: 'number', orderable: false, searchable:false },
                      { data: 'url', name: 'jobs', orderable: false, searchable:false },
                      { data: 'specialty', name: 'specialty', orderable: false},
                      {data: 'action', name: 'action', orderable: false,  searchable:false},
                   ],
            order: [[0, 'desc']]
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
              url: "/suppliers/destroy/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a project.',
                };

                generateNotif(notifData);
                $('#bulk_delete').addClass('d-none');

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
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
          }
          else
          {
              alert("Please select atleast one checkbox");
          }
      
      });



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

          //form.preventDefault();
          var id = [];

          $('.tbl_row_checkbox:checked').each(function(){
             id.push($(this).val());
          });

      
          var formData = {
            status: $('#status').children("option:selected").val(),
            updatedby_id: jQuery('#updatedby_id').val(),
          };

          var state = jQuery('#btn-save').val();
          var type = "POST";

          $.ajax({
              type: type,
              url: "/suppliers/status",
              data: { "formData" : formData, "id": id } ,
              dataType: 'json',
              success: function (data) {
                $('#ajax-crud-modal').modal('hide');
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'success',
                  message: 'Successfully updated status of the selected ' + data + ' companies.',
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


/*

      $(document).on('click', '#btn-save-status', function(){

          var id = [];

          $('.tbl_row_checkbox:checked').each(function(){
             id.push($(this).val());
          });

          if(id.length > 0)
          {
            $.ajax({
              type: "get",
              data:{id:id},
              url: "/companies/status",
              success: function (data) {
                $('#listpage_datatable').DataTable().ajax.reload();

                var notifData = {
                  status: 'danger',
                  message: 'Successfully deleted '+ data +' selected companies.',
                };
                
                generateNotif(notifData);

                $('#bulk_status').addClass('d-none');

              },
              error: function (data) {
                console.log('Error:', data);
              }
            });
            
          }
          else
          {
              alert("Please select atleast one checkbox");
          }
      
      });
*/

    

    }); //end document ready




  </script>
@endpush



