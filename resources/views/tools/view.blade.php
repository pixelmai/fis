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
              

                <hr />

                <div class="info-block pt-1">

                  <h3>Specifications</h3>

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
                    <hr class="dotted" />

                    <h3>Suppliers List</h3>

                    <ul class="list-items">
                      @foreach($tools->suppliers as $supplier)
                        <li><a href="/suppliers/view/{{ $supplier->id }}">{{ $supplier->name }}</a></li>
                      @endforeach
                    </ul>

                  @endif






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
