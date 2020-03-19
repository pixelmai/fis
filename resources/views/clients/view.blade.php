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
                <h1>{{ $client->fname }} {{ $client->lname }}</h1>

                <div class="chip mb-2">
                  {{ $client->sector->name }}
                </div>


                <div class="chip mb-2">
                  {{ $client->regtype->name }}
                </div>
           

                <hr />

                <div class="info-block pt-1">

                  <h3>Basic Information</h3>

                  <div class="row">
                    <div class="col-md-8">
                      @if ($client->number)
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

                      @if ($client->address)
                        <div class="info-item">
                          <strong>Address</strong>
                          {{ $client->address }}
                        </div>

                      @endif
                    </div>
         
                    <div class="col-md-4">
    
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
                    </div>
                  </div>

                  <hr />

                  <h3>Professional Profile</h3>

                  <div class="row">
                    <div class="col-12">

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

                      @if ($client->skillset)
                        <div class="info-item">
                          <strong>Skillset</strong>
                          {{ $client->skillset }}
                        </div>
                      @endif

                      @if ($client->hobbies)
                        <div class="info-item">
                          <strong>hobbies</strong>
                          {{ $client->hobbies }}
                        </div>
                      @endif

                      @if ($client->url)
                        <div class="info-item">
                          <strong>Portfolio URL</strong>
                          {{ $client->url }}
                        </div>
                      @endif

                    </div>
         
      
                  </div>


                </div>


                <div class="row py-2">
                  <div class="col-12">
                    <a href="/account/edit" class="btn btn-outline-primary btn-lg">
                      Edit Profile
                    </a>

                    <a href="/account/password" class="btn btn-outline-secondary btn-lg">
                      Change Password
                    </a>

                  </div>
                </div>

              </div>
            </div>

            



          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




