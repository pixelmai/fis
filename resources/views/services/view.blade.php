@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">Services Information</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between">
                  <div>
                    <h1>{{ $services->name }}</h1>

                    @if (isset($services->category->name))
                      <div class="chip mb-2">
                        {{ $services->category->name }}
                      </div>
                    @endif

                  </div>
                  <div>

                    <a href="/services/edit/{{ $services->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-edit"></i>
                    </a>

                    @if(count($services->machines) == 0)
                      <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="{{ $services->id }}" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>
                    @else
                      @if($services->is_deactivated == 0)
                        <a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="{{ $services->id }}" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-ban"></i></a>
                      @else
                        <a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="{{ $services->id }}" class="delete btn btn-outline-success btn-lg"><i class="fas fa-check"></i></a>
                      @endif
                    @endif

                  </div>
                </div>
          
                <hr /> 
   

                <div class="info-block pt-1">


        
                  @if ($services->category->name)
                  <div class="info-item">
                    <strong>Type</strong>
                    {{ $services->category->name }}
                  </div>
                  @endif

                  @if ($services->unit)
                  <div class="info-item">
                    <strong>Unit</strong>
                    {{ $services->unit }}
                  </div>
                  @endif


                  @if ($services->current->def_price)
                    <div class="info-item">
                      <strong>Default Price</strong>
                      {{ priceFormatFancy($services->current->def_price) }}
                    </div>
                  @endif

                  @if ($services->current->up_price)
                  <div class="info-item">
                    <strong>UP Price</strong>
                    {{ priceFormatFancy($services->current->up_price) }}
                  </div>
                  @endif

                  @if (count($services->machines)!=0)

                    <h5 class="pt-4">Machines List</h5>

                    <ul class="list-items">
                      @foreach($services->machines as $machine)
                        <li><a href="/machines/view/{{ $machine->id }}">{{ $machine->name }}</a></li>
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
                  {{ dateOnly($services->updated_at) }}
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
              url: "/services/destroy/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/services') }}';

                var notifData = {
                  status: 'warning',
                  message: 'Successfully deleted a service.',
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
              url: "/services/deactivate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/services') }}';


                var notifData = {
                  status: 'warning',
                  message: 'Successfully deactivated a tool.',
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
              url: "/services/activate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/services') }}';
                
                var notifData = {
                  status: 'success',
                  message: 'Successfully activated a tool.',
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
