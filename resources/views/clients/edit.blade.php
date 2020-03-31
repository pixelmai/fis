@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit Client</div>
        </div>

          <div class="card-body">

            <form action="/clients/edit/{{ $client->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')
              
            <div class="form-group row d-flex">
              <div class="col-md-6">
                <label for="fname" class="col-form-label">First Name <span class="required">*</span></label>
              
                  <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') ?? $client->fname }}" required autofocus autocomplete="off">

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
                    value="{{ old('lname') ?? $client->lname }}" required 
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
                    <input type="radio" id="male" name="gender" value="m" @if($client->gender == 'm') checked @endif required>
                    <label for="male">Male</label>

                    
                  </div>
                  <div>
                    <input type="radio" id="female" name="gender" value="f" @if($client->gender == 'f') checked @endif required> 
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
                    <input name="date_of_birth" type="text" class="form-control" value="{{ old('date_of_birth') ?? datetoDpicker($client->date_of_birth) }}" autocomplete="off" placeholder="mm/dd/yyyy">
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
                    value="{{ old('email') ?? $client->email }}"  
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
                    value="{{ old('number') ?? $client->number }}"  
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
                    name="address" autofocus>{{ old('address') ?? $client->address }}</textarea>

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
                    <option value="{{ $regtype_id_unit->id }}"
                      @if($client->regtype_id == $regtype_id_unit->id) selected @endif >{{ $regtype_id_unit->name }}</option>
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
                    <option value="{{ $sector_id_unit->id }}" @if($client->sector_id == $sector_id_unit->id) selected @endif >{{ $sector_id_unit->name }}</option>
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

              <div class="col-md-6">
                <label for="company_id" class="col-form-label">Company/Institution</label>
                  <div>
                    <input id="company_name" 
                      type="text" 
                      class="w-100 form-control @error('company_name') is-invalid @enderror" 
                      name="company_name" 
                      value="{{ old('company_name') ?? $client->company->name }}"  
                      autocomplete="off" autofocus placeholder="Type name to search">

                    <input id="company_id" 
                      type="hidden" 
                      name="company_id" 
                      value="{{ old('company_id') ?? $client->company_id }}">

                    @error('company_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
              </div>
              <div class="col-md-6 d-flex">
                <div class="align-self-end"> 
                  <a href="javascript:void(0)" class="btn btn-outline-primary" id="add-company">Add New Company</a>
                </div>
              </div>


            </div>




            <div class="form-group row">


              <div class="col-md-6">
                <label for="position" class="col-form-label">Position</label>

                  <input id="position" 
                    type="text" 
                    class="form-control @error('position') is-invalid @enderror" 
                    name="position" 
                    value="{{ old('position') ?? $client->position }}"  
                    autofocus>

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
                    value="{{ old('url') ?? $client->url }}"  
                    autocomplete="off" autofocus>

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
                    value="{{ old('skillset') ?? $client->skillset }}"  
                    autocomplete="off" autofocus>

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
                    value="{{ old('hobbies') ?? $client->hobbies }}"  
                    autocomplete="off" autofocus>

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
                  <input type="checkbox" id="is_pwd" name="is_pwd" value="1" @if($client->is_pwd == 1) checked @endif >
                  <label for="is_pwd" class="pl-2 col-form-label">PWD</label>
                  <br />

                  <input type="checkbox" id="is_freelancer" name="is_freelancer" value="1" @if($client->is_freelancer == 1) checked @endif >
                  <label for="is_freelancer" class="pl-2 col-form-label">Freelancer</label>

                  <br />
                  <input type="checkbox" id="is_food" name="is_food" value="1" @if($client->is_food == 1) checked @endif >
                  <label for="is_food" class="pl-2 col-form-label">Food Industry</label>
                </div>

              </div>



            </div>


            <div class="row py-2">
              <div class="col-12">
                <button class="btn btn-primary btn-lg">Update User</button>
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

  @include('clients.modalCreateCompany')

@endpush


@push('scripts')
  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>

  <script>
  $(document).ready( function () {

    $('#date_of_birth').datepicker();

    /* Type Ahead */
    var engine = new Bloodhound({
        remote: {
            url: '{{ route('clientsauto') }}?q=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $("input#company_name").typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    }, {
        source: engine.ttAdapter(),
        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        name: 'companies',
        // the key from the array we want to display (name,id,email,etc...)
        display: 'name',
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown"><div class="list-group-item"><a id="sugg_create_comp" data-toggle="modal" href="#ajax-crud-modal">Nothing found. <br> Create New Company?</a></div></div>'
            ],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
              $('#company_id').val(1);
              return '<div class="list-group-item">' + data.name + '</div>';
            }
        }

    }).on('typeahead:select', function(ev, suggestion) {
      if(suggestion.id){
        $('#company_id').val(suggestion.id);
      }
    });

    /* Type Ahead */


    $('#add-company').click(function () {
        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');
    });
     


    $('#is_partner').click(function(){
        $('#partner_type').toggleClass('d-none');
    });


    
    //Validator and the Submit Form codes on success

    var validator = $("#ajaxForm").validate({
      errorPlacement: function(error, element) {
        // Append error within linked label
        $( element )
          .closest( "form" )
            .find( "label[for='" + element.attr( "id" ) + "']" )
              .append( error );
      },
      errorElement: "span",
      rules: {
        comp_name: {
          required: true,
          minlength: 2
        },
        comp_email: {
          email: true
        },
        comp_url: {
          url: true
        },
        comp_number: {
          minlength: 7
        },
      },
      messages: {
        comp_name: {
          required: " (required)",
          minlength: " (at least 2 characters)"
        },
        comp_email: " (invalid email format)",
        comp_url: " (invalid URL format)",
        comp_number: " (at least 7 characters)",
      },
      submitHandler: function(form) {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        //form.preventDefault();

        var check_is_partner;

        if($('#is_partner').prop("checked") == true){
          check_is_partner = 1;
        } else {
          check_is_partner = 0;
        }


        var formData = {
          name: jQuery('#comp_name').val(),
          email: jQuery('#comp_email').val(),
          number: jQuery('#comp_number').val(),
          address: jQuery('#comp_address').val(),
          description: jQuery('#comp_description').val(),
          url: jQuery('#comp_url').val(),
          partner_id: $('#partner_id').children("option:selected").val(),
          is_partner: check_is_partner,
          updatedby_id: jQuery('#updatedby_id').val(),
        };

        var state = jQuery('#btn-save').val();
        var type = "POST";
        $.ajax({
            type: type,
            url: "/companies/modalStore",
            data: formData,
            dataType: 'json',
            success: function (data) {
              $('#company_name').val(data.name);
              $('#company_id').val(data.id);
              $('#ajax-crud-modal').modal('hide');
            },
            error: function (data) {
              console.log('Error:', data);
              $('#sameCompName').text('Company already exists');

              var notifData = {
                status: 'danger',
                message: 'Unsuccessful creation. Company with the same name exists',
              };
              generateNotif(notifData);
            }
        });


      },
    });

    $('#comp_name').on('input', function(){
      if($('#sameCompName').text()){
        $('#sameCompName').text('');
      }
    });

    $('#ajax-crud-modal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
        validator.resetForm();
    });

    $('#ajax-crud-modal').on('shown.bs.modal', function(){
        if($('#company_name').val()){
          $('#comp_name').val(jQuery('#company_name').val());
        }
    });


    $('#company_name').on('input', function(){
      $('#company_id').val(1);
    });


  }); //end document ready



  </script>


@endpush
