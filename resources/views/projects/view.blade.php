@extends('layouts.app')
@section('content')

<div id="view_projects" class="container">

  <div class="sh">Project Details</div>
  

  <div id="card_area" class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        
        <div id="markers" class="d-flex justify-content-between">
          <div>
            <div class="status status_{{ strtolower($s) }}">{{ $s }}</div>
          </div>

          <div id="invoice_menu">

            @if($project->status == 1)
              @if($sum != 0)
                <a href="javascript:void(0);" id="add-log-row" data-id="{{ $project->id }}" class="edit btn btn-outline-secondary btn-md">
                  <i class="fas fa-history"></i> 
                Change Status
              </a>
              @endif

                <a href="/projects/edit/{{ $project->id }}" class="edit btn btn-outline-secondary btn-md">
                  <i class="fas fa-edit"></i> 
                  Edit
                </a>
            @endif

            @if($sum == 0 && $project->status == 1)
              <a href="javascript:void(0);" id="delete-row" data-id="{{ $project->id }}" class="delete btn btn-outline-danger btn-md">
                <i class="fas fa-trash"></i> 
                Delete
              </a>
            @endif
          </div>
        </div>


        <div class="card-body">
          <div id="basic_invoice_info">

            <div class="info-block">
              
                <h1>{{ $project->name }}</h1>
              
              <div class="row">
                <div class="col-md-8">
                  <div class="info-item">
                    <strong>Owner</strong>
                    <a href="/clients/view/{{ $project->client->id }}">
                      {{ $project->client->fname }} {{ $project->client->lname }}
                    </a>
                  </div>
              

                  
                    <div class="info-item">
                      <strong>URL</strong>
                      @if ($project->url)
                        <a href="{{ $project->url }}">{{ $project->url }}</a>
                      @else
                        <span class="">N/A</span>
                      @endif

                    </div>
                 
                  @if ($project->description)
                    <div class="info-item">
                      <strong>Description</strong>
                      {{ $project->description }}
                    </div>
                  @endif

                </div>

                <div class="col-md-4 text-right">
                    @if($project->created_at)
                      <div class="info-item">
                        <strong>Created at</strong>
                        {{ dateTimeFormat($project->created_at) }}
                      </div>
                    @endif


                   
                      <div class="info-item">
                        <strong>Last Update</strong>
                        @if($project->updated_at)
                          {{ dateTimeFormat($project->updated_at) }}
                        @else
                          <em class="info_na">N/A</em>
                        @endif

                      </div>
                </div> 
              </div>


            </div>

          </div>


          @if(count($invoices) != 0)


            <div id="invoices_table_head" class="d-flex justify-content-between align-self-center">
              <div>
                <h5>Invoices</h5>
              </div>
              <div>
                <a href="/invoices/create" class="btn btn-sm btn-outline-success">Add New Invoice</a>
              </div>
            </div>

            <table id="listpage_datatable" class="table table-responsive-md" data-page-length="25">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Invoice ID</th>
                  <th scope="col"># of Jobs</th>
                  <th scope="col">Status</th>
                  <th scope="col">Date Created</th>
                  <th scope="col">Due Date</th>
                  <th scope="col"><div class="price">Subtotal</div></th>
                  <th scope="col"><div class="price">Discount</div></th>
                  <th scope="col"><div class="price">Total</div></th>
                  <th scope="col" class="col_actions"/>&nbsp;</tr>
                </tr>
              </thead>
            </table>
          @endif




        </div>






      <div>

      </div>

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

      $('body').on('click', '#delete-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/projects/destroy/"+'{{ $project->id }}',
              success: function (data) {

                if(data == 'deleted_no'){
                  var notifData = {
                    status: 'danger',
                    message: 'Cannot delete a contact person of a company',
                  };
                  generateNotif(notifData);

                }else{
                  window.location.href = '{{ url('/projects') }}';
                }
              
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   


      $('#listpage_datatable').DataTable({
             processing: true,
             serverSide: true,
             ajax: {
              url: "/projects/view/{{ $project->id }}",
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
                      { data: 'id', name: 'id', orderable: false},
                      { data: 'jobs', name: 'jobs', orderable: false, searchable: false },
                      { data: 'status', name: 'status', orderable: false },
                      { data: 'created', name: 'created', orderable: false },
                      { data: 'due_date', name: 'due_date', orderable: false },
                      { data: 'subtotal', name: 'subtotal', orderable: false, searchable: false},
                      { data: 'discount', name: 'discount', orderable: false, searchable: false},
                      { data: 'total', name: 'total', orderable: false, searchable: false},
                      { data: 'action', name: 'action', orderable: false,  searchable:false},
                   ],
            order: [[0, 'desc']],
      });

    

      $('body').on('click', '#add-log-row', function () {
        var row_id = $(this).data("id");
        $('#ajaxForm #project_id').val({{ $project->id }});
        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');
        $('#btn-multiple-save-status').addClass('d-none');
        $('#btn-single-save-status').removeClass('d-none');
      });   

      $('body').on('click', '#btn-single-save-status', function () {
        initvalidator("{{ $project->id }}");
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
                url: "/projects/status",
                data: { "formData" : formData, "id": ids } ,
                dataType: 'json',
                success: function (data) {
                  $('#ajax-crud-modal').trigger("reset");
                  $('#ajax-crud-modal').modal('hide');
                  var oTable = $('#listpage_datatable').dataTable(); 
                  oTable.fnDraw(false);

                  var notifData = {
                    status: 'success',
                    message: 'Successfully updated status of the selected ' + data + ' project.',
                  };

                  generateNotif(notifData);

                  window.location.href = '{{ url( '/projects/view/'.$project->id ) }}';


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
