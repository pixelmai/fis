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

                    @if (isset($status))
                      <div class="chip mb-2">
                        {{ $status }}
                      </div>
                    @endif

                  </div>
                  <div>
                    <a href="/tools/edit/{{ $tools->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-edit"></i>
                    </a>

                    <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>

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

                        @if ($status)
                        <div class="info-item">
                          <strong>Status</strong>
                          {{ $status }}
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

                        
                        @foreach($tools->logs as $log)
                          <div class="status_log @if ($loop->iteration % 2 == 0) even @endif">
                            <div class="schip schip-{{ strtolower($status_list[$log['status']]) }}">
                              {{ $status_list[$log['status']] }}
                            </div> 
                            <p>{{ $log['notes'] }}</p>

                            
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



@push('scripts')

  <script>
    $(document).ready( function () {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('body').on('click', '#delete-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to delete supplier?')) {

          $.ajax({
              type: "get",
              url: "/suppliers/destroy/"+{{ $tools->id }},
              success: function (data) {

                window.location.href = '{{ url('/suppliers') }}';

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a supplier.',
                };
                
                generateNotif(notifData);

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   
    

    }); //end document ready




  </script>
@endpush
