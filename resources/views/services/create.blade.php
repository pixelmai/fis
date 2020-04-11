@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Create New Service</div>
        </div>

          <div class="card-body">

            <form action="/services/create" enctype="multipart/form-data" method="POST">
              @csrf

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Service Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="off">

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>



              <div class="form-group row d-flex">

                <div class="col-md-6">
                  <label for="servcats_id" class="col-form-label">Registration Type <span class="required">*</span></label>

                  <select id="servcats_id" name="servcats_id" class="form-control @error('$servcats_id') is-invalid @enderror" autofocus>

                    @foreach($servcats_id as $servcat_id_unit)
                      <option value="{{ $servcat_id_unit->id }}">{{ $servcat_id_unit->name }}</option>
                    @endforeach
                  </select>


                  @error('$servcats_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>


                <div class="col-md-6">
                  <label for="unit" class="col-form-label">Unit <span class="required">*</span></label>

                
                    <input id="unit" 
                      type="text" 
                      class="form-control @error('unit') is-invalid @enderror" 
                      name="unit" 
                      value="{{ old('unit') }}"  
                      autofocus required autocomplete="off">

                    @error('unit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>



              <div class="form-group row d-flex">

                <div class="col-md-6">
                  <label for="def_price" class="col-form-label">Default Price <span class="required">*</span></label>

                
                    <input id="def_price" 
                      type="text" 
                      class="form-control @error('def_price') is-invalid @enderror" 
                      name="def_price" 
                      value="{{ old('def_price') }}"  
                      autofocus required autocomplete="off">

                    @error('def_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-6">
                  <label for="up_price" class="col-form-label">UP Price <span class="required">*</span></label>

                
                    <input id="up_price" 
                      type="text" 
                      class="form-control @error('up_price') is-invalid @enderror" 
                      name="up_price" 
                      value="{{ old('up_price') }}"  
                      autofocus required autocomplete="off">

                    @error('up_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>




            <div class="row py-2">
              <div class="col-12">
                <button id="big-add-button" class="btn btn-primary btn-lg">Create Service</button>
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

  <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>

  <script>
  $(document).ready( function () {









  }); //end document ready


  </script>


@endpush
