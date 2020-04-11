@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">Supplier Profile</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between">
                  <div>
                    <h1>{{ $supplier->name }}</h1>

                    @if (isset($supplier->specialty) && strlen($supplier->specialty) <30 )
                      <div class="chip mb-2">
                        {{ $supplier->specialty }}
                      </div>
                    @endif


                  </div>
                  <div>
                    <a href="/suppliers/edit/{{ $supplier->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-edit"></i>
                    </a>

                    @if($sum == 0)
                      <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$supplier->id.'" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>
                    @else
                      @if($supplier->is_deactivated == 0)
                        <a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="{{ $supplier->id }}" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-ban"></i></a>
                      @else
                        <a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="{{ $supplier->id }}" class="delete btn btn-outline-success btn-lg"><i class="fas fa-check"></i></a>
                      @endif
                    @endif

                  </div>
                </div>
              

                <hr />

                <div class="info-block pt-1">

                  <h3>Contact Information</h3>

                  @if ($supplier->contact_person)
                  <div class="info-item">
                    <strong>Contact Person</strong>
                    {{ $supplier->contact_person }}
                  </div>
                  @endif

                  @if ($supplier->email)
                  <div class="info-item">
                    <strong>Email Address</strong>
                    {{ $supplier->email }}
                  </div>
                  @endif

                  @if ($supplier->number)
                  <div class="info-item">
                    <strong>Contact Number</strong>
                    {{ $supplier->number }}
                  </div>
                  @endif

                  @if ($supplier->url)
                  <div class="info-item">
                    <strong>URL</strong>
                    <a href="{{ $supplier->url }}">{{ $supplier->url }}</a>
                  </div>
                  @endif


                  @if ($supplier->address)
                  <div class="info-item">
                    <strong>Address</strong>
                    {{ $supplier->address }}
                  </div>

                  @endif


                @if ($supplier->specialty || $supplier->supplies)
                  <hr class="dotted" />
                  <h3>Supplies</h3>

                @endif



                @if ($supplier->specialty)
                  <div class="info-item">
                    <strong>Specialty</strong>
                    {{ $supplier->specialty }}
                  </div>
                @endif


                @if (!empty($supplies))
                  <div class="info-item">
                    <strong>Supplies List</strong>
                    <ul class="list-items">
                      @foreach($supplies as $item)
                        @if($item != '')
                          <li>{{ $item }}</li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
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
                    {{ dateOnly($supplier->updated_at) }}
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
              url: "/suppliers/destroy/"+{{ $supplier->id }},
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
    

      $('body').on('click', '#deactivate-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to deactivate row?')) {

          $.ajax({
              type: "get",
              url: "/suppliers/deactivate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/suppliers') }}';


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
                window.location.href = '{{ url('/suppliers') }}';
                
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






    }); //end document ready




  </script>
@endpush
