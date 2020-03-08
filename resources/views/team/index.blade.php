@extends('layouts.app')
@section('content')

<div class="pt-4 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Team Members</h1>
      </div>
      <div>
        @if($user->superadmin)
          <a href="team/create" class="btn btn-lg btn-success">Add Team Member</a>
        @endif
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card card-table">
   
       

          <table class="table table-responsive-md">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Position</th>
                <th scope="col">Email</th>
                <th scope="col">Contact #</th>
                <th scope="col">Last Login</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($team as $team_member)
                <tr @if($team_member->is_active==FALSE) class="deactivated" @endif>
                  <td>
                    <a href="team/profile/{{ $team_member->id }}"><img src="{{ $team_member->profileImage() }}" alt="" style="height: 30px;" class="rounded-circle mr-2" /></a>

                    <a href="team/profile/{{ $team_member->id }}" class="name">
                      {{ $team_member->fname }} {{ $team_member->lname }}
                    </a>

                    @if($team_member->superadmin)
                      <div class="chip chip-admin">admin</div>
                    @endif

                    @if($team_member->is_active==FALSE)
                      <div class="chip">Inactive</div>
                    @endif
          
                  </td>
                  <td>{{ $team_member->position ?? 'Not Set' }}</td>
                  <td>{{ $team_member->email }}</td>
                  <td>{{ $team_member->number ?? 'Not Set' }}</td>
                  <td>
                    @if($team_member->last_login)
                      {{ timeAgo(strtotime($team_member->last_login)) }}
                      ago
                    @else
                      Never logged in
                    @endif

                  </td>
                  <td class="text-right">

                    <a href="team/profile/{{ $team_member->id }}" class="btn btn-sm btn-outline-secondary">View</a>

                  
                  </td>

                </tr>
              @endforeach
            </tbody>
          </table>

      </div>

      <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
          {{ $team->links() }}
        </div>
      </div>

    </div>
  </div>








    



</div>



@endsection




