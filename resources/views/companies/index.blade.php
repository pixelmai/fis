@extends('layouts.app')


@section('content')
       
<div class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Companies</h1>
      </div>
      <div>
        <a href="companies/create" class="btn btn-lg btn-success">Add Company</a>
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
              <th scope="col">Email</th>
              <th scope="col">Contact</th>
              <th scope="col">Partner Type</th>
              <th scope="col">Contact Person</th>
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
              url: "/companies",
              type: 'GET',
             },
             columns: [
                      { data: 'id', name: 'id', 'visible': false},
                      { data: "contactperson.fname", 'visible': false},
                      { data: 'checkbox', orderable:false, searchable:false},
                      { data: 'name', name: 'name' },
                      { data: 'email', name: 'email', orderable: false  },
                      { data: 'number', name: 'number', orderable: false, searchable: false },
                      { data: 'partner.name', orderable: false},
                      { data: "contactperson.lname", render: function ( data, type, row ) {
                          // Combine the first and last names into a single table field
                          if ( type === 'display' || type === 'filter' ) {
                            return '<a href="/clients/view/'+row.contactperson.id+'">'+row.contactperson.fname+' '+row.contactperson.lname+'</a>';
                          } else {
                            return row.contactperson.lname;
                          }
                      }, orderable: false },
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
              url: "/clients/destroy/"+row_id,
              success: function (data) {
                var oTable = $('#listpage_datatable').dataTable(); 
                oTable.fnDraw(false);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a client.',
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
                  url: "/clients/massrem",
                  success: function (data) {
                    $('#listpage_datatable').DataTable().ajax.reload();

                    var notifData = {
                      status: 'danger',
                      message: 'Successfully deleted selected clients.',
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



