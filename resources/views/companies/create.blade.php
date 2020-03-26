@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Create New Company</div>
        </div>

          <div class="card-body">

            <form action="/companies/create" enctype="multipart/form-data" method="POST">
              @csrf

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Company Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="off">

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>


              <div class="form-group row">
                <div class="col-md-6">
                  <label for="client_id" class="col-form-label">Contact Person <span class="required">*</span></label>
                
                    <input id="client_id" type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" value="{{ old('client_id') }}" required autofocus autocomplete="off">

                    @error('client_id')
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
                <div class="col-md-6">
                  <label for="url" class="col-form-label">URL</label>
                
                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" autofocus autocomplete="off">

                    @error('url')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>


                <div class="col-md-6">


                  <div>
                    <div>
                      <input type="checkbox" id="is_partner" name="is_partner" value="1">
                      <label for="is_partner" class="pl-2 col-form-label">Is partner?</label>
                    </div>

                    <div id="partner_type" class="pl-4 w-50 d-none">
                      <select id="partner_id" name="partner_id" class="form-control @error('$partner_id') is-invalid @enderror" autofocus>

                        @foreach($partner_id as $partner_id_unit)
                          <option value="{{ $partner_id_unit->id }}">{{ $partner_id_unit->name }}</option>
                        @endforeach
                      </select>

                      @error('$sector_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>


                  </div>



                </div>


              </div>





              <div class="form-group row">
                <div class="col-12">
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


              <div class="form-group row">
                <div class="col-12">
                  <label for="description" class="col-form-label">Description</label>

                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autofocus autocomplete="off">

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>





            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Create Company</button>
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

    $('#is_partner').click(function(){
        $('#partner_type').toggleClass('d-none');
    });

  }); //end document ready


  </script>


@endpush
