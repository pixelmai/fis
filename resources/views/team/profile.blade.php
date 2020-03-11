@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">View Team Profile</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-8">
                <h1>{{ $team_member->fname }} {{ $team_member->lname }}</h1>

                @if ($team_member->position)
                  <div class="chip mb-2">
                    {{ $team_member->position }}
                  </div>
                @endif

                @if($team_member->superadmin)
                  <div class="chip chip-admin">admin</div>
                @endif

                @if($team_member->is_active==FALSE)
                  <div class="chip chip-deactivated">Inactive</div>
                @endif


                <hr />

                <div class="info-block pt-1">

                  <div class="info-item">
                    <strong>Email Address</strong>
                    {{ $team_member->email }}
                  </div>

                  @if ($team_member->number)
                    <div class="info-item">
                      <strong>Contact Number</strong>
                      {{ $team_member->number }}
                    </div>
                  @endif

                  @if ($team_member->address)
                    <div class="info-item">
                      <strong>Address</strong>
                      {{ $team_member->address }}
                    </div>

                  @endif

                  @if ($team_member->skillset)
                    <div class="info-item">
                      <strong>Skillset</strong>
                      {{ $team_member->skillset }}
                    </div>
                  @endif
                </div>

                

                  <div class="row py-2">
                    <div class="col-12">

                    @if(($user->superadmin && $team_member->id != 1) || $user->id == $team_member->id)
                      <a href="/team/edit/{{ $team_member->id }}" class="btn btn-outline-secondary btn-lg">
                        Edit Profile
                      </a>
                    @endif

                    @if($user->superadmin && $team_member->id != 1 && $team_member->id != $user->id)

                      @if($team_member->is_active==FALSE)
                        <a href="/team/activate/{{ $team_member->id }}" class="btn btn-outline-success btn-lg">
                          Activate
                        </a>
                      @else
                        <a href="/team/deactivate/{{ $team_member->id }}" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to deactivate this user?');">
                          Deactivate
                        </a>
                      @endif
                    @endif

                    </div>

                  </div>


                 
                


                     

              </div>

              <div class="col-md-4">
                <img src="{{ $team_member->profileImage() }}" class="w-100 border" alt="" />
              </div>
            </div>

            



          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




