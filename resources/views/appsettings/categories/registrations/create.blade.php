@extends('layouts.app')
@section('content')

<div class="container pt-5">
  @include('layouts.appsettings_tab')
  <div class="row justify-content-center">

    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div class="bh">Add MSME Type</div>
          </div>
        </div>

        <div class="card-body">

          <form action="/categories/registrations/store" enctype="multipart/form-data" method="POST">
              @csrf

            <div class="form-group row">

              <div class="col-md-6">
                <label for="name" class="col-form-label">Name <span class="required">*</span></label>

                  <input id="name" 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" 
                    value="{{ old('name') }}"  
                    autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>


            <div class="form-group row">
              <div class="col-md-6">
                <label for="msme_types" class="col-form-label">MSME Classification <span class="required">*</span></label>

                <select id="msme_types" name="msme_types" class="form-control @error('$msme_types') is-invalid @enderror" autofocus>

                  @foreach($msme_types as $msme_type)
                    <option value="{{ $msme_type->id }}">{{ $msme_type->name }}</option>
                  @endforeach
                </select>


                @error('$msme_types')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-12">
                <label for="number" class="col-form-label">Description</label>

                  <textarea id="description" 
                    type="text" 
                    class="form-control @error('description') is-invalid @enderror" 
                    name="description" autofocus>{{ old('description') }}</textarea>

                  @error('description')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>



            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Create Type</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@endsection




