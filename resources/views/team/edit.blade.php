@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit {{ $team_member->fname }}'s Profile</div>
        </div>

          <div class="card-body">

            <form action="/team/update/{{ $team_member->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')



            <div class="form-group row d-flex">
              <div class="col-md-6">
                <label for="fname" class="col-form-label">First Name <span class="required">*</span></label>
              
                  <input id="fname" 
                    type="text" 
                    class="form-control @error('fname') is-invalid @enderror" 
                    name="fname" 
                    value="{{ old('fname') ?? $team_member->fname }}" required 
                    autocomplete="fname" autofocus>

                  @error('fname')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <div class="col-md-6">
                <label for="lname" class="col-form-label">Last Name <span class="required">*</span></label>
              
                  <input id="lname" 
                    type="text" 
                    class="form-control @error('lname') is-invalid @enderror" 
                    name="lname" 
                    value="{{ old('lname') ?? $team_member->lname }}" required 
                    autocomplete="lname" autofocus>

                  @error('lname')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            @if($team_member->id != 1 )
              <div class="form-group row d-flex">
                <div class="col-md-6">
                  <label for="setadmin" class="col-form-label">Set as Admin</label>
                
                    <input type="checkbox" id="setadmin" name="setadmin" value="1" @if($team_member->superadmin == 1 ) checked @endif >
                </div>

                <div class="col-md-6">
                  <label for="deactivate" class="col-form-label">Deactivate Account</label>
                
                    <input type="checkbox" id="deactivate" name="deactivate" value="1" @if(!$team_member->is_active == 1 ) checked @endif >
                </div>
              </div>
            @endif
            


            <div class="form-group row">
              <div class="col-12">
                <label for="email" class="col-form-label">Email Address <span class="required">*</span></label>

                  <input id="email" 
                    type="text" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') ?? $team_member->email }}"  
                    autocomplete="email" autofocus>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row d-flex">
              <div class="col-md-6">
                <label for="number" class="col-form-label">Contact Number</label>
              
                  <input id="number" 
                    type="text" 
                    class="form-control @error('number') is-invalid @enderror" 
                    name="number" 
                    value="{{ old('number') ?? $team_member->number }}" 
                    autocomplete="number" autofocus>

                  @error('number')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <div class="col-md-6">
                <label for="number" class="col-form-label">Position <span class="required">*</span></label>

              
                  <input id="position" 
                    type="text" 
                    class="form-control @error('position') is-invalid @enderror" 
                    name="position" 
                    value="{{ old('position') ?? $team_member->position }}"  
                    autocomplete="position" autofocus>

                  @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row">
              <div class="col-12">
                <label for="number" class="col-form-label">Address</label>

              
                  <textarea id="address" 
                    type="text" 
                    class="form-control @error('address') is-invalid @enderror" 
                    name="address" autofocus>{{ old('address') ?? $team_member->address }}</textarea>

                  @error('address')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>



             <div class="form-group row">


              <div class="col-12">
                <label for="number" class="col-form-label">Skillset</label>

              
                  <input id="skillset" 
                    type="text" 
                    class="form-control @error('skillset') is-invalid @enderror" 
                    name="skillset" 
                    value="{{ old('skillset') ?? $team_member->skillset }}"  
                    autocomplete="skillset" autofocus>

                  @error('skillset')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>



            <div class="form-group row">

              <div class="col-12">
                <label for="image" class="col-form-label">Profile Image</label><br />

                <img src="{{ $team_member->profileImage() }}" style="width: 250px; height: 250px;" alt="" />

                <div class="pt-3">
                  <input type="file" class="form-control-file" id="image" name="image">

                  @error('image')
                    <strong>{{ $message }}</strong>
                  @enderror
                </div>
              </div>
            </div> 


            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Update Profile</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




