@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">View Profile</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-8">
                <h1>{{ $user->fname }} {{ $user->lname }}</h1>

                @if ($user->position)
                  <div class="chip mb-2">
                    {{ $user->position }}
                  </div>
                @endif

                <hr />

                <div class="info-block pt-1">

                  <div class="info-item">
                    <strong>Email Address</strong>
                    {{ $user->email }}
                  </div>

                  @if ($user->number)
                    <div class="info-item">
                      <strong>Contact Number</strong>
                      {{ $user->number }}
                    </div>
                  @endif

                  @if ($user->address)
                    <div class="info-item">
                      <strong>Address</strong>
                      {{ $user->address }}
                    </div>

                  @endif

                  @if ($user->skillset)
                    <div class="info-item">
                      <strong>Skillset</strong>
                      {{ $user->skillset }}
                    </div>
                  @endif
                </div>


                <div class="row py-2">
                  <div class="col-12">
                    <a href="/account/edit" class="btn btn-outline-primary btn-lg">
                      Edit Profile
                    </a>
                  </div>
                </div>

              </div>

              <div class="col-md-4">
                <img src="{{ $user->profileImage() }}" class="w-100 border" alt="" />
              </div>
            </div>

            



          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




