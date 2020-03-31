@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Projects</h1>
      </div>
      <div>
        <a href="projects/create" class="btn btn-lg btn-success">Add Project</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
        <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
          <thead class="thead-dark">
            <tr>
              <th scope="col">&nbsp;</th>
              <th scope="cold">&nbsp;</th>
              <th scope="col" class="col_checkbox">&nbsp;</th>
              <th scope="col">Name</th>
              <th scope="col">Client</th>
              <th scope="col">Status</th>
              <th scope="col">URL</th>
              <th scope="col">No. of Jobs</th>
              <th scope="col">Created</th>
              <th scope="col">Last Update</th>
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
              url: "/projects",
              type: 'GET',
             },
             columns: [
                      { data: 'id', name: 'id', 'visible': false},
                      { data: "client.fname", 'visible': false},
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'name', name: 'name' },
                      { data: "client.lname", render: function ( data, type, row ) {
                          if ( type === 'display' || type === 'filter' ) {
                            if (row.client.id != 1){
                              return '<a href="/clients/view/'+row.client.id+'">'+row.client.fname+' '+row.client.lname+'</a>';
                            }else{
                              return '-';
                            }
                          } else {
                            return row.client.lname;
                          }
                      }, orderable: false },
                      { data: 'status', name: 'status', orderable: false },
                      { data: 'url', name: 'url', orderable: false, searchable:false },
                      { data: 'url', name: 'jobs', orderable: false, searchable:false },
                      { data: 'created', name: 'created', orderable: false},
                      { data: 'updated', name: 'created', orderable: false},
                      {data: 'action', name: 'action', orderable: false,  searchable:false},
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
              url: "/companies/destroy/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a company.',
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
                  url: "/companies/massrem",
                  success: function (data) {
                    $('#listpage_datatable').DataTable().ajax.reload();

                    var notifData = {
                      status: 'danger',
                      message: 'Successfully deleted '+ data +' selected companies.',
                    };
                    
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



