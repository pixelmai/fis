@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit Supplier</div>
        </div>

          <div class="card-body">

            <form action="/suppliers/edit/{{ $supplier->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Supplier Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $supplier->name }}" required autofocus autocomplete="off">

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>


              <div class="form-group row">

                <div class="col-md-6">
                  <div>

                    <label for="contact_person" class="col-form-label">Contact Person <span class="required">*</span></label>
                      
                    <input id="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') ?? $supplier->contact_person }}" required autofocus autocomplete="off">

                    @error('contact_person')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

              </div>



              <div class="form-group row d-flex">

                <div class="col-md-6">
                  <label for="email" class="col-form-label">Email Address </label>

                    <input id="email" 
                      type="text" 
                      class="form-control @error('email') is-invalid @enderror" 
                      name="email" 
                      value="{{ old('email') ?? $supplier->email }}"  
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
                      value="{{ old('number') ?? $supplier->number }}"  
                      autofocus autocomplete="off">

                    @error('number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


              <div class="form-group row">
                <div class="col-md-12">
                  <label for="url" class="col-form-label">URL</label>
                
                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') ?? $supplier->url }}" autofocus autocomplete="off">

                    @error('url')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>



              <div class="form-group row">
                <div class="col-12">
                  <label for="address" class="col-form-label">Address</label>

                    <textarea id="address" 
                      type="text" 
                      class="form-control @error('address') is-invalid @enderror" 
                      name="address" autofocus>{{ old('address') ?? $supplier->address }}</textarea>

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


              <div class="form-group row">
                <div class="col-12">
                  <label for="specialty" class="col-form-label">Specialty</label>
                    <input id="specialty" type="text" class="form-control @error('specialty') is-invalid @enderror" name="specialty" value="{{ old('specialty') ?? $supplier->specialty }}" autofocus autocomplete="off">
                    @error('specialty')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


              <div class="form-group row">
                <div class="col-12">
                  <label for="supplies" class="col-form-label">Supplies</label>

                    <textarea id="supplies" 
                      type="text" 
                      class="form-control @error('supplies') is-invalid @enderror" 
                      name="supplies" autofocus>{{ old('supplies') ?? $supplier->supplies }}</textarea>

                    <p class="form-note">
                      Use semicolon ( <strong>;</strong> ) to separate items
                    </p>

                    @error('supplies')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>



            <div class="row py-2">
              <div class="col-12">
                <button id="submit-button" type="submit" class="btn btn-primary btn-lg">Edit Supplier</button>
              </div>
            </div>

          </form>

        </div>


      </div>
    </div>
  </div>
</div>



@stop


@push('modals')

@endpush


@push('scripts')

@endpush
