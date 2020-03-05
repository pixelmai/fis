@extends('layouts.app')
@section('content')

<div class="container pt-4">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          Edit Profile
        </div>

          <div class="card-body">

            <form action="/account/update" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')

            <div class="form-group row d-flex">
              <div class="col-6">
                <label for="fname" class="col-form-label">First Name <span class="required">*</span></label>
              
                  <input id="fname" 
                    type="text" 
                    class="form-control @error('fname') is-invalid @enderror" 
                    name="fname" 
                    value="{{ old('fname') ?? $user->fname }}" required 
                    autocomplete="fname" autofocus>

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
                    value="{{ old('lname') ?? $user->lname }}" required 
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
                <label for="number" class="col-form-label">Position</label>

              
                  <input id="position" 
                    type="text" 
                    class="form-control @error('position') is-invalid @enderror" 
                    name="position" 
                    value="{{ old('position') ?? $user->position }}"  
                    autocomplete="position" autofocus>

                  @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <div class="col-6">
                <label for="number" class="col-form-label">Contact Number</label>
              
                  <input id="number" 
                    type="text" 
                    class="form-control @error('number') is-invalid @enderror" 
                    name="number" 
                    value="{{ old('number') ?? $user->number }}" 
                    autocomplete="number" autofocus>

                  @error('number')
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
                    name="address" autofocus>{{ old('address') ?? $user->address }}</textarea>

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
                    value="{{ old('skillset') ?? $user->skillset }}"  
                    autocomplete="skillset" autofocus>

                  @error('skillset')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="row py-2">
              <div class="col-4">
                <button class="btn btn-primary">Update Profile</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




