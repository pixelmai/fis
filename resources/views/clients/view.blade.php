@extends('layouts.app')
@section('content')

<div id="view_clients" class="container">

  <div class="sh">Client Profile</div>

  <div id="card_area" class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div id="markers" class="d-flex justify-content-between align-items-center">
          <div>
            <h1>{{ $client->fname }} {{ $client->lname }}</h1>
              <div class="chip mb-2">
                {{ $client->sector->name }}
              </div>

              @if ($client->is_freelancer == 1)
                <div class="chip mb-2 chip-freelancer">
                  Freelancer
                </div>
              @endif


              @if ($client->is_pwd == 1)
                <div class="chip mb-2 chip-pwd">
                  PWD
                </div>
              @endif

          </div>

          <div>

          <a href="/clients/edit/{{ $client->id }}" class="edit btn btn-outline-secondary btn-md">
            <i class="fas fa-edit"></i>
            Edit
          </a>

          @if($sum == 0)
            <a href="javascript:void(0);" id="delete-row" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-md"><i class="fas fa-trash"></i> Delete</a>
          @else
            @if($client->is_deactivated == 0)
              <a href="javascript:void(0);" id="deactivate-row" data-id="{{ $client->id }}" class="delete btn btn-outline-danger btn-md"><i class="fas fa-ban"></i> Deactivate</a>
            @else
              <a href="javascript:void(0);" id="activate-row" data-id="{{ $client->id }}" class="delete btn btn-outline-success btn-md"><i class="fas fa-check"></i> Activate</a>
            @endif
          @endif
          </div>
        </div>


        <div class="card-body">
          <div id="basic_invoice_info">
            <div class="info-block">

                @if ($client->email || $client->number || $client->url || $client->address)
                  <h5>Contact Information</h5>
                @endif

                @if ($client->email)
                <div class="info-item">
                  <strong>Email Address</strong>
                  {{ $client->email }}
                </div>
                @endif

                @if ($client->number)
                <div class="info-item">
                  <strong>Contact Number</strong>
                  {{ $client->number }}
                </div>
                @endif

                @if ($client->url)
                <div class="info-item">
                  <strong>Portfolio URL</strong>
                  <a href="{{ $client->url }}">{{ $client->url }}</a>
                </div>
                @endif


                @if ($client->address)
                <div class="info-item">
                  <strong>Address</strong>
                  {{ $client->address }}
                </div>

                @endif


                @if ($client->email || $client->number || $client->url || $client->address)
                  <hr class="dotted" />
                @endif



                <div class="row">
                  <div class="col-lg-6">
                    <h5>Professional Info</h5>

                    @if ($client->company_id && $client->company_id != 1)
                      <div class="info-item">
                        <strong>Company/Institution</strong>
                        <a href="/companies/view/{{ $client->company_id }}">{{ $client->company->name }}</a>
                      </div>
                    @endif

                    @if ($client->position)
                      <div class="info-item">
                        <strong>Position</strong>
                        {{ $client->position }}
                      </div>
                    @endif

                    <div class="info-item">
                      <strong>Sector</strong>
                      {{ $client->sector->name }}
                    </div>

                    <div class="info-item">
                      <strong>Registration Type</strong>
                      {{ $client->regtype->name }}
                    </div>

                    @if ($client->is_food == 1)
                      <div class="info-item">
                        <strong>Food Business</strong>
                        Yes
                      </div>
                    @endif

                    @if ($client->is_freelancer == 1)
                      <div class="info-item">
                        <strong>Freelancer</strong>
                        Yes
                      </div>
                    @endif

                  </div>

                  <div class="col-lg-6">

                   <h5>Personal Info</h5>

                      @if ($client->gender)
                        <div class="info-item">
                          <strong>Sex</strong>

                          {{ $client->gender === "m" ? "Male" : "Female" }}

                        </div>
                      @endif

                      @if ($client->date_of_birth)
                        <div class="info-item">
                          <strong>Date of Birth</strong>
                          {{ dateOnly($client->date_of_birth) }}
                        </div>
                      @endif

                      @if ($client->is_pwd == 1)
                        <div class="info-item">
                          <strong>PWD</strong>
                          Yes
                        </div>
                      @endif


                      @if ($client->skillset)
                        <div class="info-item">
                          <strong>Skillset</strong>
                          {{ $client->skillset }}
                        </div>
                      @endif

                      @if ($client->hobbies)
                        <div class="info-item">
                          <strong>Hobbies</strong>
                          {{ $client->hobbies }}
                        </div>
                      @endif


                  </div>


                </div>



                <hr class="dotted" />

 



                  <div class="updatedby text-right">
                    Last updated by
                    <b>
                      <a href="/team/profile/{{ $updater->id }}">
                        {{ $updater->fname }}
                        {{ $updater->lname }}
                      </a>
                    </b>
                    on
                    {{ dateOnly($client->updated_at) }}
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

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/clients/destroy/"+'{{ $client->id }}',
              success: function (data) {

                if(data == 'deleted_no'){
                  var notifData = {
                    status: 'danger',
                    message: 'Cannot delete a contact person of a company',
                  };
                  generateNotif(notifData);

                }else{
                  window.location.href = '{{ url('/clients') }}';
                }
              
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
              url: "/clients/deactivate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/clients') }}';


                var notifData = {
                  status: 'warning',
                  message: 'Successfully deactivated a client.',
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
              url: "/clients/activate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/clients') }}';
                
                var notifData = {
                  status: 'success',
                  message: 'Successfully activated a client.',
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
