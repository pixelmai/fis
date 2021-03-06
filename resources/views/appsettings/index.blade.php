@extends('layouts.app')
@section('content')

<div class="container pt-3">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="bh">App Settings</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-8">

                <div class="info-block pt-1">

                  <div class="info-item">
                    <strong>Company Name</strong>
                    {{ $appsettings->name }}
                  </div>

                  <div class="info-item">
                    <strong>Manager</strong>
                    {{ $appsettings->manager }}
                  </div>

                  <div class="info-item">
                    <strong>Email Address</strong>
                    {{ $appsettings->email }}
                  </div>

        
                  <div class="info-item">
                    <strong>Contact Number</strong>
                    {{ $appsettings->number }}
                  </div>
          
       
                  <div class="info-item">
                    <strong>Address</strong>
                    {{ $appsettings->address }}
                  </div>

       
                  <div class="info-item">
                    <strong>Discounts</strong>
                    
                    Senior Citizens (SC): {{ $appsettings->dsc }}%<br >
                    Persons with Disabilities (PWD): {{ $appsettings->dpwd }}%<br >
                  </div>



                  @if($user->superadmin)
                    <div class="row py-2">
                      <div class="col-12">
                        <a href="/appsettings/edit" class="btn btn-outline-primary btn-lg">
                          Edit Information
                        </a>
                      </div>
                    </div>
                  @endif

                </div>


              </div>

              <div class="col-md-4">
                <img src="/svg/logo.svg" class="w-100" alt="" />
              </div>
            </div>

            <div class="info-block pt-1">
              <hr class="dotted" />
              <div class="updatedby text-right">
                Last updated by
                <b>
                  <a href="/team/profile/{{ $settings_updater->id }}">
                    {{ $settings_updater->fname }}
                    {{ $settings_updater->lname }}
                  </a>
                </b>
                on
               {{ dateOnly($settings_updater->updated_at) }}
              </div>
            </div>



        </div>


      </div>
    </div>
  </div>
</div>



@endsection




