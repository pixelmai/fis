@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Create New Tools</div>
        </div>

          <div class="card-body">

            <form action="/tools/create" enctype="multipart/form-data" method="POST">
              @csrf

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Tool Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="off">

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>



              <div class="form-group row">
                <div class="col-3">
                  <label for="status" class="col-form-label">Status <span class="required">*</span></label>

                    <select id="status" name="status" class="form-control @error('$status') is-invalid @enderror" autofocus>


                    @foreach($status as $statnum => $statdesc) 
                      <option value="{{ $statnum }}">{{ $statdesc }}</option>
                    @endforeach

                    </select>

                    @error('$status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


              <div class="form-group row d-flex">

                <div class="col-md-6">
                  <label for="model" class="col-form-label">Model </label>

                    <input id="model" 
                      type="text" 
                      class="form-control @error('model') is-invalid @enderror" 
                      name="model" 
                      value="{{ old('model') }}"  
                      autofocus autocomplete="off">

                    @error('model')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="col-md-6">
                  <label for="brand" class="col-form-label">Brand</label>
                    <input id="brand" 
                      type="text" 
                      class="form-control @error('brand') is-invalid @enderror" 
                      name="brand" 
                      value="{{ old('brand') }}"  
                      autofocus autocomplete="off">

                    @error('brand')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>





              <div class="form-group row">
                <div class="col-12 mb-3">
                  <label for="notes" class="col-form-label">Notes</label>

                    <textarea id="notes" 
                      type="text" 
                      class="form-control @error('notes') is-invalid @enderror" 
                      name="notes" autofocus>{{ old('notes') }}</textarea>

                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


            <div class="row py-2">
              <div class="col-12">
                <button id="big-add-button" class="btn btn-primary btn-lg">Create Tool</button>
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
