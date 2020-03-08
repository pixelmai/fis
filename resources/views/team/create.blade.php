@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Create New Team Member</div>
        </div>

          <div class="card-body">

            <form action="/team/store" enctype="multipart/form-data" method="POST">
              @csrf



            <div class="form-group row d-flex">
              <div class="col-6">
                <label for="fname" class="col-form-label">First Name <span class="required">*</span></label>
              
                  <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>

                  @error('fname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>

              <div class="col-6">
                <label for="lname" class="col-form-label">Last Name <span class="required">*</span></label>
              
                  <input id="lname" 
                    type="text" 
                    class="form-control @error('lname') is-invalid @enderror" 
                    name="lname" 
                    value="{{ old('lname') }}" required 
                    autocomplete="lname" autofocus>

                  @error('lname')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row d-flex">

              <div class="col-6">
                <label for="email" class="col-form-label">Email Address <span class="required">*</span></label>

                  <input id="email" 
                    type="text" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') }}"  
                    autocomplete="email" autofocus>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>


              <div class="col-6">
                <label for="position" class="col-form-label">Position <span class="required">*</span></label>

              
                  <input id="position" 
                    type="text" 
                    class="form-control @error('position') is-invalid @enderror" 
                    name="position" 
                    value="{{ old('position') }}"  
                    autocomplete="position" autofocus>

                  @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              

            </div>

            <div class="form-group row d-flex">

              <div class="col-6">
                <label for="password" class="col-form-label text-md-right">{{ __('Password') }} <span class="required">*</span></label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>


              <div class="col-6">
                <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }} <span class="required">*</span></label>

               
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                
              </div>
              

            </div>

            <div class="form-group row">


              <div class="col-6">
                <label for="superadmin" class="col-form-label">Set as Admin</label>

                <input type="checkbox" id="superadmin" name="superadmin" value="1">
              </div>



            </div>


            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Create User</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




