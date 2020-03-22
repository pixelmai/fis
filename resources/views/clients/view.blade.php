@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">Client Profile</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between">
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
                    <a href="/clients/edit/{{ $client->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-edit"></i>
                    </a>

                    <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>

                  </div>
                </div>
              

                <hr />

                <div class="info-block pt-1">


                @if ($client->email || $client->number || $client->url || $client->address)
                  <h3>Contact Information</h3>
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

                

                <h3>Professional Profile</h3>

                <div class="row">
                  <div class="col-md-6">
                    @if ($client->company_id)
                      <div class="info-item">
                        <strong>Company</strong>
                        {{ $client->company_id }}
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
                  </div>

                  <div class="col-md-6">
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


                </div>



                <hr class="dotted" />

                <h3>Personal Profile</h3>

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
                window.location.href = '{{ url('/clients') }}';
;
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
