@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Clients</h1>
      </div>
      <div>
        <a href="clients/create" class="btn btn-lg btn-success">Add Client</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col" class="col_checkbox">&nbsp;</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Email</th>
              <th scope="col">Contact</th>
              <th scope="col">Company</th>
              <th scope="col">Position</th>
              <th scope="col" class="col_actions"/>
                <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-sm d-none">Delete All</i></button>
              </th>
            </tr>
          </thead>
        
        </table>

    </div>
  </div>
</div>

@stop



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
              url: "/clients",
              type: 'GET',
             },
             columns: [
                      { data: 'id', name: 'id', 'visible': false},
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'fname', name: 'fname' },
                      { data: 'lname', name: 'lname' },
                      { data: 'email', name: 'email', orderable: false  },
                      { data: 'number', name: 'number', orderable: false, searchable: false },
                      { data: 'company_name', name: 'company_name' },
                      { data: 'position', name: 'position' },
                      {data: 'action', name: 'action', orderable: false},
                   ],
            order: [[0, 'desc']]
      });

      $('#listpage_datatable tbody').on('click', '.tbl_row_checkbox', function () {
          $(this).parent().parent().toggleClass('rowselected');

          if ( document.querySelector('.rowselected') !== null ) {
            $('#bulk_delete').removeClass('d-none');
          }else{
            $('#bulk_delete').addClass('d-none');
          }

      } );


      $('body').on('click', '#delete-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/clients/destroy/"+row_id,
              success: function (data) {
                if(data == 'deleted_yes'){
                  var oTable = $('#listpage_datatable').dataTable(); 
                  oTable.fnDraw(false);

                  var notifData = {
                    status: 'warning',
                    message: 'Successfully deleted a client.',
                  };

                  generateNotif(notifData);
                  $('#bulk_delete').addClass('d-none');
                }else{

                  var notifData = {
                    status: 'danger',
                    message: 'Cannot delete a contact person of a company',
                  };

                  generateNotif(notifData);
                  $('#bulk_delete').addClass('d-none');

                }

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   


      $(document).on('click', '#bulk_delete', function(){
          var id = [];

          if(confirm("Are you sure you want to Delete this data?"))
          {
              $('.tbl_row_checkbox:checked').each(function(){
                 id.push($(this).val());
              });

              if(id.length > 0)
              {
                $.ajax({
                  type: "get",
                  data:{id:id},
                  url: "/clients/massrem",
                  success: function (data) {
                    var notifData = [];

                    if(data == 0){
                      notifData = {
                        status: 'danger',
                        message: 'Main Contacts of Companies cannot be deleted.',
                      };
                    }else if(data < id.length){
                      $('#listpage_datatable').DataTable().ajax.reload();
                      notifData = {
                        status: 'danger',
                        message: 'Successfully deleted '+ data +' out of ' + id.length + ' selected clients. Main Contacts of Companies cannot be deleted.',
                      };
                    }else {
                      $('#listpage_datatable').DataTable().ajax.reload();
                      notifData = {
                        status: 'danger',
                        message: 'Successfully deleted all '+ data +' selected clients.',
                      };
                    }

                    generateNotif(notifData);

                    $('#bulk_delete').addClass('d-none');

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


    

    }); //end document ready




  </script>
@endpush



