@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Change Password</div>
        </div>

          <div class="card-body">

            <form action="/account/password" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')


              <div class="form-group row">
                <div class="col-md-6">
                  <label for="current_password" class="col-form-label"> 
                    Current Password 
                    <span class="required">*</span></label>

                    <input id="current_password" 
                      type="password" 
                      class="form-control @error('current_password') is-invalid @enderror" 
                      name="current_password" 
                      autofocus>

                    @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


            <div class="form-group row">
              <div class="col-md-6">
                <label for="new_password" class="col-form-label"> 
                  New Password 
                  <span class="required">*</span></label>

                  <input id="new_password" 
                    type="password" 
                    class="form-control @error('new_password') is-invalid @enderror" 
                    name="new_password" 
                    autofocus>

                  @error('new_password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row">
              <div class="col-md-6">
                <label for="new_confirm_password" class="col-form-label"> 
                  Confirm Password 
                  <span class="required">*</span></label>

                  <input id="new_confirm_password" 
                    type="password" 
                    class="form-control @error('new_confirm_password') is-invalid @enderror" 
                    name="new_confirm_password" 
                    autofocus>

                  @error('new_confirm_password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>



            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Update Password</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




