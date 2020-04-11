@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Services</h1>
      </div>
      <div>
        <a href="/services/create" class="btn btn-lg btn-success">Add Services</a>
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
              <th scope="col">Type</th>
              <th scope="col">Unit</th>
              <th scope="col">Price</th>
              <th scope="col">UP Price</th>
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
              url: "/services",
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
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'name', name: 'name' },
                      { data: 'category.name', name: 'category.name' },
                      { data: 'unit', name: 'unit' },
                      { data: 'dprice', name: 'dprice', orderable: false },
                      { data: 'uprice', name: 'uprice', orderable: false, searchable:false },
                      {data: 'action', name: 'action', orderable: false,  searchable:false},
                   ],
            order: [[0, 'desc']]
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
                  message: 'Successfully deleted a supplier.',
                };

                generateNotif(notifData);
                  $('#bulk_deac').addClass('d-none');
                  $('#bulk_acti').addClass('d-none');

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   



      $(document).on('click', '#bulk_deac', function(){
          var id = [];

          if(confirm("Are you sure you want to deactivate these rows?"))
          {
              $('.tbl_row_checkbox:checked').each(function(){
                 id.push($(this).val());
              });

              if(id.length > 0)
              {
                $.ajax({
                  type: "get",
                  data:{id:id},
                  url: "/suppliers/massdeac",
                  success: function (data) {
                    var notifData = [];
                    var oTable = $('#listpage_datatable').dataTable(); 
                    oTable.fnDraw(false);
                   
                    $('#listpage_datatable').DataTable().ajax.reload();
                    notifData = {
                      status: 'danger',
                      message: 'Successfully deactivated '+ data +' suppliers.',
                    };
                   

                    generateNotif(notifData);

                    $('#bulk_deac').addClass('d-none');
                    $('#bulk_acti').addClass('d-none');

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
          }
      });


      $(document).on('click', '#bulk_acti', function(){
          var id = [];

          if(confirm("Are you sure you want to activate these rows?"))
          {
              $('.tbl_row_checkbox:checked').each(function(){
                 id.push($(this).val());
              });

              if(id.length > 0)
              {
                $.ajax({
                  type: "get",
                  data:{id:id},
                  url: "/suppliers/massacti",
                  success: function (data) {
                    var notifData = [];
                    var oTable = $('#listpage_datatable').dataTable(); 
                    oTable.fnDraw(false);
                   
                    $('#listpage_datatable').DataTable().ajax.reload();
                    notifData = {
                      status: 'success',
                      message: 'Successfully activated '+ data +' suppliers.',
                    };
                   

                    generateNotif(notifData);

                    $('#bulk_deac').addClass('d-none');
                    $('#bulk_acti').addClass('d-none');

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
          }
      });


      $('body').on('click', '#deactivate-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to deactivate row?')) {

          $.ajax({
              type: "get",
              url: "/suppliers/deactivate/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deactivated a supplier.',
                };

                generateNotif(notifData);
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
              url: "/suppliers/activate/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'success',
                  message: 'Successfully activated a supplier.',
                };

                generateNotif(notifData);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });  


      /* Append Status Select Box */
        var activeStatusHTML = '<div id="active_status_container"><label for="status" class="col-form-label">Showing</label><select id="active_status" name="active_status"><option value="0">Active</option><option value="1">Inactive</option><option value="2">All</option></select><span class="divider d-none d-sm-inline">|</span></div>'; 

        $('#listpage_datatable_filter').prepend(activeStatusHTML); //Add field html

        $( "#active_status" ).change(function() {
          var oTable = $('#listpage_datatable').dataTable(); 
          oTable.fnDraw(false);
        });
      /* Append Status Select Box */
      







    }); //end document ready




  </script>
@endpush



