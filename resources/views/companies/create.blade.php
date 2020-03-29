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
                
                <div class="col-md-6 d-flex">
                  <div class="align-self-end"> 
                    <a href="javascript:void(0)" class="btn btn-outline-primary" id="add-client">Add New Client</a>
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
  @include('companies.modalCreateClient')
@endpush


@push('scripts')

  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>

  <script>
  $(document).ready( function () {

    $('#is_partner').click(function(){
        $('#partner_type').toggleClass('d-none');
    });


  /* Type Ahead */
    var engine = new Bloodhound({
        remote: {
            url: '{{ route('companiesauto') }}?q=%QUERY%',
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
              $('#client_id').val(0);
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
      $('#client_id').val(0);
      if($('#contact_person_fname').val()){
        $('#contact_person_fname').val('');
      }
    });


    $('#add-client').click(function () {
        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');
    });

    /* Type Ahead */


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

        var check_is_freelancer, check_is_food, check_is_pwd;

        check_is_freelancer = ($('#is_freelancer').prop("checked") == true) ? 1 : 0;
        check_is_food = ($('#is_food').prop("checked") == true) ? 1 : 0;
        check_is_pwd = ($('#is_pwd').prop("checked") == true) ? 1 : 0;


        var formData = {
          fname: jQuery('#fname').val(),
          lname: jQuery('#lname').val(),
          email: jQuery('#client_email').val(),
          number: jQuery('#client_number').val(),
          position: jQuery('#position').val(),
          regtype_id: $('#regtype_id').children("option:selected").val(),
          sector_id: $('#sector_id').children("option:selected").val(),

          is_freelancer: check_is_freelancer,
          is_food: check_is_food,
          is_pwd: check_is_pwd,

          updatedby_id: jQuery('#updatedby_id').val(),
        };

        var state = jQuery('#btn-save').val();
        var type = "POST";
        $.ajax({
            type: type,
            url: "/clients/modalStore",
            data: formData,
            dataType: 'json',
            success: function (data) {
              $('#contact_person').val(data.lname);
              $('#contact_person_fname').val(data.fname);
              $('#client_id').val(data.id);
              $('#add-client').addClass('d-none');
              $("#contact_person").prop('disabled', true);
              $("#contact_person").css("background-color", "#e9ecef");
              $('#ajax-crud-modal').modal('hide');
            },
            error: function (data) {
              console.log('Error:', data);
            }
        });

      },
    });












  }); //end document ready


  </script>


@endpush
