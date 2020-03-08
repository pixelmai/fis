@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit Profile</div>
        </div>

          <div class="card-body">

            <form action="/appsettings/update" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')


            <div class="form-group row">
              <div class="col-lg-6">
                <label for="name" class="col-form-label">Company Name <span class="required">*</span></label>
              
                  <input id="name" 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" 
                    value="{{ old('name') ?? $appsettings->name }}" required 
                    autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

            </div>


            <div class="form-group row">
              <div class="col-lg-6">
                <label for="manager" class="col-form-label">Manager's Name <span class="required">*</span></label>

                  <input id="manager" 
                    type="text" 
                    class="form-control @error('manager') is-invalid @enderror" 
                    name="manager" 
                    value="{{ old('manager') ?? $appsettings->manager }}"  
                    autocomplete="manager" required autofocus>

                  @error('manager')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row d-flex">
              <div class="col-lg-6">
                <label for="email" class="col-form-label">Email <span class="required">*</span></label>

              
                  <input id="email" 
                    type="text" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') ?? $appsettings->email }}"  
                    autocomplete="email" required autofocus>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              <div class="col-lg-6">
                <label for="number" class="col-form-label">Contact Number  <span class="required">*</span></label>
              
                  <input id="number" 
                    type="text" 
                    class="form-control @error('number') is-invalid @enderror" 
                    name="number" 
                    value="{{ old('number') ?? $appsettings->number }}" 
                    autocomplete="number" required autofocus>

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
                    name="address" required autofocus>{{ old('address') ?? $appsettings->address }}</textarea>

                  @error('address')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>






            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Update Information</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




