@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">Tool Information</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between">
                  <div>
                    <h1>{{ $tools->name }}</h1>

                    @if (isset($s))
                      <div class="chip mb-2">
                        {{ $s }}
                      </div>
                    @endif

                  </div>
                  <div>

                    <a href="javascript:void(0);" id="add-log-row" data-toggle="tooltip" data-placement="top" data-original-title="Add Log" data-id="'.$data->id.'" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-history"></i>
                    </a>

                    <a href="/tools/edit/{{ $tools->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-edit"></i>
                    </a>

                    @if(count($logs) == 0)
                      <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="{{ $tools->id }}" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>
                    @else
                      @if($tools->is_deactivated == 0)
                        <a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="{{ $tools->id }}" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-ban"></i></a>
                      @else
                        <a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="{{ $tools->id }}" class="delete btn btn-outline-success btn-lg"><i class="fas fa-check"></i></a>
                      @endif
                    @endif

                  </div>
                </div>
              


              @if (count($tools->logs) == 0 )
                <hr class="mb-0"> 
              @endif
            </div>
          </div>
        </div>
              

        @if (count($tools->logs) != 0 )
          <ul class="nav nav-tabs card-tabs" id="myTab" role="tablist">

            <li class="nav-item ml-3">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information</a>
            </li>

            
              <li class="nav-item">
                <a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="false">Logs</a>
              </li>
           
          </ul>
        @endif


        <div class="card-body @if(count($tools->logs) == 0 ) pt-0 @endif">

          <div class="row">
            <div class="col-md-12">

                <div class="tab-content" id="myTabContent">
                  <!-- TAB CONTENT -->
                    
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">



                      <div class="info-block pt-1">

                        <h5>Specifications</h5>

                        @if ($s)
                        <div class="info-item">
                          <strong>Status</strong>
                          {{ $s }}
                        </div>
                        @endif

                  
                        @if ($tools->model)
                        <div class="info-item">
                          <strong>Model</strong>
                          {{ $tools->model }}
                        </div>
                        @endif

                        @if ($tools->brand)
                        <div class="info-item">
                          <strong>Brand</strong>
                          {{ $tools->brand }}
                        </div>
                        @endif


                        @if ($tools->notes)
                        <div class="info-item">
                          <strong>Notes</strong>
                          {{ $tools->notes }}
                        </div>
                        @endif

                        @if (count($tools->suppliers)!=0)

                          <h5 class="pt-4">Suppliers List</h5>

                          <ul class="list-items">
                            @foreach($tools->suppliers as $supplier)
                              <li><a href="/suppliers/view/{{ $supplier->id }}">{{ $supplier->name }}</a></li>
                            @endforeach
                          </ul>

                        @endif
                      </div>

                      <div class="updatedby text-right">
                        Last updated by
                        <b>
                          <a href="/team/profile/{{ $updater->id }}">
                            {{ $updater->fname }}
                            {{ $updater->lname }}
                          </a>
                        </b>
                        on
                        {{ dateOnly($tools->updated_at) }}
                      </div>


                    </div>


                  <!-- TAB CONTENT -->

                  <!-- TAB CONTENT -->
                    <div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab">

                      <div class="info-block pt-1">
                        <h5>Status Logs</h5>

                        
                        @foreach($logs as $log)
                          <div class="status_log @if ($loop->iteration % 2 == 0) even @endif">
                            <div class="d-flex justify-content-between">
                              <div id="status-{{ $log['id'] }}" class="schip schip-{{ strtolower($status[$log['status']]) }}">{{ $status[$log['status']] }}</div> 
                              <div>

                                @if(($user->superadmin) || $user->id == $log['updater']['id'])
                                  <a href="javascript:void(0);" id="edit-log-row" data-id="{{ $log['id'] }}">Edit</a>
                                  <a href="javascript:void(0);" id="delete-log-row" data-id="{{ $log['id'] }}">Delete</a>
                                @endif

                              </div>
                            </div>

                            <p id="notes-{{ $log['id'] }}">{{ $log['notes'] }}</p>

                            
                            <div class="updatedby">Updated by 
                              <a href="/team/profile/{{ $log['updater']['id'] }}">{{ $log['updater']['fname'] }} {{ $log['updater']['lname'] }}</a> on {{ dateTimeFormat($log['updated_at']) }}</div>
                          </div>

                        @endforeach
                        

                    </div>
                  <!-- TAB CONTENT -->
                </div>





                </div>


              </div>
            </div>

            



        </div>


      </div>
    </div>
  </div>
</div>



@stop

@push('modals')
  @include('tools.modalAddLogs')
@endpush



@push('scripts')
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
              url: "/tools/destroy/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/tools') }}';

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a tool.',
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
              url: "/tools/deactivate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/tools') }}';


                var notifData = {
                  status: 'warning',
                  message: 'Successfully deactivated a tool.',
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
              url: "/tools/activate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/tools') }}';
                
                var notifData = {
                  status: 'success',
                  message: 'Successfully activated a tool.',
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
        $('#ajaxForm #tool_id').val({{ $tools->id }});
        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');
        $('#btn-edit-status').addClass('d-none');
        $('#btn-multiple-save-status').addClass('d-none');
        $('#btn-single-save-status').removeClass('d-none');
      });   

      $('body').on('click', '#edit-log-row', function () {
        var note_id = $(this).data("id");
        var note_class = '#notes-'+ note_id;
        var status_note = $('#status-'+ note_id).text();


        $('#ajaxForm #log_id').val(note_id);
        $('#ajaxForm #tool_id').val({{ $tools->id }});
        $('#ajaxForm #notes').val($(note_class).text());


        $('#ajaxForm #status option:contains('+status_note+
          ')').prop('selected', true);

        $("#ajaxForm #status").dropkick('refresh');

        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');

        $('#btn-multiple-save-status').addClass('d-none');
        $('#btn-single-save-status').addClass('d-none');
        $('#btn-edit-status').removeClass('d-none');
      });   

      $('body').on('click', '#btn-single-save-status', function () {
        initvalidator($('#tool_id').val(), "/tools/status");
      });   

      $('body').on('click', '#btn-edit-status', function () {
        initvalidator($('#tool_id').val(), "/tools/status/edit");
      });   


      $('body').on('click', '#delete-log-row', function () {
        var note_id = $(this).data("id");

        if (confirm('Are you sure want to delete log?')) {

          $.ajax({
              type: "get",
              url: "/tools/status/destroy/"+ note_id,
              success: function (data) {

                location.reload(true);

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a status log.',
                };
                
                generateNotif(notifData);

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 

      });   




      function initvalidator(ids, ajaxUrl){
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
                url: ajaxUrl,
                data: { "formData" : formData, "id": ids, "logid": $('#ajaxForm #log_id').val() } ,
                dataType: 'json',
                success: function (data) {
                  location.reload(true);
                  var notifData = {
                    status: 'success',
                    message: 'Successfully updated status of the ' + data + ' tool.',
                  };

                  generateNotif(notifData);
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
