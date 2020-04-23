@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Create New Project</div>
        </div>

          <div class="card-body">

            <form action="/projects/create" enctype="multipart/form-data" method="POST">
              @csrf

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Project Name <span class="required">*</span></label>
                
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
                  <div>

                    <label for="contact_person" class="col-form-label">Contact Person <span class="required">*</span></label>
                      
                      <div class="d-flex">
                        <div class="w-50">
                          <input id="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}" required autofocus autocomplete="off" placeholder="Search last name">
                        </div>
                        <div class="w-50">
                          <input id="contact_person_fname" class="form-control ml-2" type="text" disabled>
                        </div>
                      </div>

                      <input id="client_id" type="hidden" name="client_id" value="{{ old('client_id') }}" required>

                      @error('contact_person')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror

                  </div>
                </div>
              </div>


              <div class="form-group row">
                <div class="col-md-12">
                  <label for="url" class="col-form-label">URL</label>
                
                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" autofocus autocomplete="off">

                    @error('url')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>


              <div class="form-group row">
                <div class="col-12">
                  <label for="description" class="col-form-label">Description</label>

                    <textarea id="description" 
                      type="text" 
                      class="form-control @error('description') is-invalid @enderror" name="description" autofocus>{{ old('description') }}</textarea>

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>




            <div class="row py-2">
              <div class="col-12">
                <button id="submit-button" type="submit" class="btn btn-primary btn-lg">Add Project</button>
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
  <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>

  <script>
  $(document).ready( function () {

  /* Type Ahead */
    var engine = new Bloodhound({
        remote: {
            url: '{{ route('clientsauto') }}?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $("input#contact_person").typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    }, {
        source: engine.ttAdapter(),
        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        name: 'client',
        // the key from the array we want to display (name,id,email,etc...)
        //display: function(cname){return cname.fname+' '+cname.lname},
        display: 'lname',
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
            ],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
              //$('#client_id').val('');
              $('#contact_person_fname').val();
              return '<div class="list-group-item">' + data.lname + ' ' + data.fname +'</div>';
            }
        }

    }).on('typeahead:select', function(ev, suggestion) {
      if(suggestion.id){
        $('#client_id').val(suggestion.id);
        $('#contact_person_fname').val(suggestion.fname);
        $('#url').focus();
      }
    }).on('typeahead:autocomplete', function(ev, suggestion) {
      if(suggestion.id){
        $('#client_id').val(suggestion.id);
        $('#contact_person_fname').val(suggestion.fname);
        $('#url').focus();
      }
    });

    $('#contact_person').on('input', function(){
      $('#client_id').val('');
      if($('#contact_person_fname').val()){
        $('#contact_person_fname').val('');
      }
    });

    $(document).on('click', '#submit-button', function(){
      if($('#client_id').val() == ''){
        var notifData = {
          status: 'danger',
          message: 'Client not found, cannot create Project',
        };

        generateNotif(notifData);
      }
    });


    /* Type Ahead */



  }); //end document ready


  </script>


@endpush
