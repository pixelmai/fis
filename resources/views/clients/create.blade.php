@extends('layouts.app')
@section('content')

<div class="container pt-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Create New Client</div>
        </div>

          <div class="card-body">

            <form action="/clients/create" enctype="multipart/form-data" method="POST">
              @csrf

            <div class="form-group row d-flex">
              <div class="col-md-6">
                <label for="fname" class="col-form-label">First Name <span class="required">*</span></label>
              
                  <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autofocus autocomplete="off">

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
                    value="{{ old('lname') }}" required 
                    autofocus autocomplete="off">

                  @error('lname')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row d-flex">

              <div class="col-md-6">
                <label for="gender" class="col-form-label">Gender <span class="required">*</span></label>

                <div class="d-flex">
                  <div class="mr-3">
                    <input type="radio" id="male" name="gender" value="m" class="@error('gender') is-invalid @enderror" required>
                    <label for="male">Male</label>
                  </div>
                  <div>
                    <input type="radio" id="female" name="gender" value="f" class="@error('gender') is-invalid @enderror">
                    <label for="female">Female</label>
                  </div>
                </div>


                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>


              <div class="col-md-6">
                <label for="dob" class="col-form-label">Date of Birth</span></label>
              

                <div id="date_of_birth" class="input-group date @error('date_of_birth') is-invalid @enderror" data-provide="datepicker">
                    <input name="date_of_birth" type="text" class="form-control" value="{{ old('date_of_birth') }}" autocomplete="off">
                    <div class="input-group-addon">
                      <span><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                  @error('date_of_birth')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>



            <div class="form-group row d-flex">

              <div class="col-md-6">
                <label for="email" class="col-form-label">Email Address </label>

                  <input id="email" 
                    type="text" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') }}"  
                    autofocus autocomplete="off">

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>


              <div class="col-md-6">
                <label for="number" class="col-form-label">Number</label>

              
                  <input id="number" 
                    type="text" 
                    class="form-control @error('number') is-invalid @enderror" 
                    name="number" 
                    value="{{ old('number') }}"  
                    autofocus autocomplete="off">

                  @error('number')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row">
              <div class="col-12 mb-3">
                <label for="address" class="col-form-label">Address</label>

                  <textarea id="address" 
                    type="text" 
                    class="form-control @error('address') is-invalid @enderror" 
                    name="address" autofocus>{{ old('address') }}</textarea>

                  @error('address')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>

            <hr />

            <div class="form-group row d-flex">

              <div class="col-md-6">
                <label for="regtype_id" class="col-form-label">Registration Type <span class="required">*</span></label>

                <select id="regtype_id" name="regtype_id" class="form-control @error('$regtype_id') is-invalid @enderror" autofocus>

                  @foreach($regtype_id as $regtype_id_unit)
                    <option value="{{ $regtype_id_unit->id }}">{{ $regtype_id_unit->name }}</option>
                  @endforeach
                </select>


                @error('$regtype_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>


              <div class="col-md-6">
                <label for="sector_id" class="col-form-label">Sector <span class="required">*</span></label>

                <select id="sector_id" name="sector_id" class="form-control @error('$sector_id') is-invalid @enderror" autofocus>

                  @foreach($sector_id as $sector_id_unit)
                    <option value="{{ $sector_id_unit->id }}">{{ $sector_id_unit->name }}</option>
                  @endforeach
                </select>


                @error('$sector_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

            </div>


            <div class="form-group row">

              <div class="col-12">
                <label for="company_id" class="col-form-label">Company</label>

              
                  <input id="company_id" 
                    type="text" 
                    class="form-control @error('company_id') is-invalid @enderror" 
                    name="company_id" 
                    value="{{ old('company_id') }}"  
                    autocomplete="off" autofocus>

                  @error('company_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

              

            </div>


            <div class="form-group row">


              <div class="col-md-6">
                <label for="position" class="col-form-label">Position</label>

                  <input id="position" 
                    type="text" 
                    class="form-control @error('position') is-invalid @enderror" 
                    name="position" 
                    value="{{ old('position') }}" autofocus>

                  @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>



              <div class="col-md-6">
                <label for="url" class="col-form-label">Portfolio URL</label>

                  <input id="url" 
                    type="text" 
                    class="form-control @error('url') is-invalid @enderror" 
                    name="url" 
                    value="{{ old('url') }}" autofocus autocomplete="off">

                  @error('url')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              

            </div>


            <div class="form-group row">


              <div class="col-md-6">
                <label for="skillset" class="col-form-label">Skillset</label>

                  <input id="skillset" 
                    type="text" 
                    class="form-control @error('skillset') is-invalid @enderror" 
                    name="skillset" 
                    value="{{ old('skillset') }}"  
                    autocomplete="skillset" autofocus>

                  @error('skillset')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>



              <div class="col-md-6">
                <label for="hobbies" class="col-form-label">Hobbies</label>

                  <input id="hobbies" 
                    type="text" 
                    class="form-control @error('hobbies') is-invalid @enderror" 
                    name="hobbies" 
                    value="{{ old('hobbies') }}"  
                    autocomplete="hobbies" autofocus>

                  @error('hobbies')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              

            </div>



            <div class="form-group row">


              <div class="col-md-6">

                <label class="col-form-label">Check everything that applies</label>

                <div>
                  <input type="checkbox" id="is_pwd" name="is_pwd" value="1">
                  <label for="is_pwd" class="pl-2 col-form-label">PWD</label>
                  <br />

                  <input type="checkbox" id="is_freelancer" name="is_freelancer" value="1">
                  <label for="is_freelancer" class="pl-2 col-form-label">Freelancer</label>

                  <br />
                  <input type="checkbox" id="is_food" name="is_food" value="1">
                  <label for="is_food" class="pl-2 col-form-label">Food Industry</label>
                </div>

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

@stop



@push('scripts')
  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script>
  $(document).ready( function () {
    $('#date_of_birth').datepicker();
  </script>

@endpush
