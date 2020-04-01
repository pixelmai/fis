@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit Project</div>
        </div>

          <div class="card-body">

            <form action="/projects/edit/{{ $project->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Project Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $project->name }}" required autofocus autocomplete="off">

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
                          <input id="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') ?? $project->client->lname  }}" required autofocus autocomplete="off" placeholder="Search last name">
                        </div>
                        <div class="w-50">
                          <input id="contact_person_fname" class="form-control ml-2" type="text" disabled value="{{ $project->client->fname  }}">
                        </div>
                      </div>

                      <input id="client_id" type="hidden" name="client_id" value="{{ old('client_id') ?? $project->client_id }}" required>

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
                
                    <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') ?? $project->url  }}" autofocus autocomplete="off">

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
                      class="form-control @error('description') is-invalid @enderror" name="description" autofocus>{{ old('description') ?? $project->description }}</textarea>

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


              <div class="form-group row">
                <div class="col-3">
                  <label for="status" class="col-form-label">Status</label>



                    <select id="status" name="status" class="form-control @error('$status') is-invalid @enderror" autofocus>
                      <option value="1" @if($project->status == 1) selected @endif >Open</option>
                      <option value="2" @if($project->status == 2) selected @endif >Completed</option>
                      <option value="3" @if($project->status == 3) selected @endif >Dropped</option>
                    </select>

                    @error('$status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>




            <div class="row py-2">
              <div class="col-12">
                <button id="big-add-button" class="btn btn-primary btn-lg">Edit Project</button>
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
                '<div class="list-group search-results-dropdown"><div class="list-group-item"><a id="sugg_create_comp" data-toggle="modal" href="#ajax-crud-modal">Nothing found. <br> Create New Client?</a></div></div>'
            ],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
              $('#client_id').val('');
              $('#contact_person_fname').val();
              return '<div class="list-group-item">' + data.lname + ' ' + data.fname +'</div>';
            }
        }

    }).on('typeahead:select', function(ev, suggestion) {
      if(suggestion.id){
        $('#client_id').val(suggestion.id);
        $('#contact_person_fname').val(suggestion.fname);
      }
    });

    $('#contact_person').on('input', function(){
      $('#client_id').val('');
      if($('#contact_person_fname').val()){
        $('#contact_person_fname').val('');
      }
    });


    $(document).on('click', '#big-add-button', function(){
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
