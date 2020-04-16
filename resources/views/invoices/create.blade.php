@extends('layouts.app')
@section('content')

<div class="container">
  <div id="invoice_heading" class="d-flex justify-content-between align-self-center">
    <h1>Create New Invoice</h1>
    <div id="invoice_id" class="col-md-4">
      <span>ID #</span> 
        {{ str_pad($id_num, 6, '0', STR_PAD_LEFT) }}
      <input type="hidden" name="id" value="{{ $id_num }}"> 
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-body">

            <form action="/invoices/create" enctype="multipart/form-data" method="POST">
              @csrf

              
              <div class="row">
                <div class="col-md-9">

                  <div class="form-group row">
                    <div class="col-md-6">
                      <div>

                        <label for="contact_person" class="col-form-label">Client Name <span class="required">*</span></label>
                          
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

                    <div class="d-flex col-md-3">
                      <div class="align-self-end">
                        <input type="checkbox" id="is_pwd" name="is_pwd" value="1">
                        <label for="is_pwd" class="pl-2 col-form-label">is UP?</label>
                      </div>
                    </div>
                    
                    <div class="col-md-3">
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


                  <div class="form-group row">

                    <div class="col-md-6">
                      <label for="company_name" class="col-form-label">Company/Institution</label>
                        <div>
                          <input id="company_name" 
                            type="text" 
                            class="w-100 form-control @error('company_name') is-invalid @enderror" 
                            name="company_name" 
                            value="{{ old('company_name') }}"  
                            autocomplete="off" autofocus placeholder="Search company name" disabled="disabled">

                          <input id="company_id" 
                            type="hidden" 
                            name="company_id" 
                            value="{{ old('company_id') }}">

                          @error('company_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                      <label for="project_name" class="col-form-label">Project</label>
                        <div>
                          <input id="project_name" 
                            type="text" 
                            class="w-100 form-control @error('project_name') is-invalid @enderror" 
                            name="project_name" 
                            value="{{ old('project_name') }}"  
                            autocomplete="off" autofocus placeholder="Search Project name" disabled="disabled">

                          <input id="project_id" 
                            type="hidden" 
                            name="project_id" 
                            value="{{ old('project_id') }}">

                          @error('project_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                  </div>

                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="created_at" class="col-form-label">Date Created <span class="required">*</span></label>

                      <div id="created_at" class="input-group date @error('created_at') is-invalid @enderror" data-provide="datepicker">
                          <input name="created_at" type="text" class="form-control" value="{{ old('created_at') ?? date('m/d/Y') }}" required autocomplete="off" placeholder="mm/dd/yyyy">

                          <div class="input-group-addon">
                            <span><i class="fa fa-calendar"></i></span>
                          </div>
                      </div>


                      @error('created_at')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>


                  <div class="form-group">
                    <label for="due_date" class="col-form-label">Due Date </label>

                      <div id="due_date" class="input-group date @error('due_date') is-invalid @enderror" data-provide="datepicker">
                          <input name="due_date" type="text" class="form-control" value="{{ old('due_date') }}" autocomplete="off" placeholder="mm/dd/yyyy">

                          <div class="input-group-addon">
                            <span><i class="fa fa-calendar"></i></span>
                          </div>
                      </div>


                      @error('due_date')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>


                </div>
              </div>

              <hr> 
             

              <div id="invoice_items_table">
                <table class="w-100">
                  <tr>
                    <th>Service</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Machine</th>
                    <th>Notes</th>
                    <th>Amount</th>
                  </tr>

                </table>
              </div>





              <div class="form-group row">

                <div class="col-md-2">
                  <label for="discount" class="col-form-label">Discount </label>
                    <input id="discount" 
                      type="text" 
                      class="form-control @error('discount') is-invalid @enderror" 
                      name="discount" 
                      value="{{ old('discount') }}"  
                      autofocus autocomplete="off">

                    @error('discount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-2">
                  <label for="total" class="col-form-label">Total </label>
                    <input id="total" 
                      type="text" 
                      class="form-control @error('total') is-invalid @enderror" 
                      name="total" 
                      value="{{ old('total') }}"  
                      autofocus autocomplete="off">

                    @error('total')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>







            <div class="row py-2">
              <div class="col-12">
                <button id="big-add-button" class="btn btn-primary btn-lg">Save Invoice</button>
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
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){

      $('#created_at').datepicker({
        maxViewMode: 2,
        orientation: "bottom auto",
        startDate: '01/01/2016',
        endDate: '+1m',
      });

      $('#due_date').datepicker({
        maxViewMode: 1,
        orientation: "bottom auto",
        startDate: '-1m',
        endDate: '+3m',
      });

    /* CLIENTS Typeahead */

      var proj_id = 0;


      function initClients(){

        var clients = new Bloodhound({
          remote: {
              url: '{{ route('clientinvoiceauto') }}?q=%QUERY%',
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
            source: clients.ttAdapter(),
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
            if(suggestion.company.name != '-'){
              $('#company_name').val(suggestion.company.name);
            }else{
              $('#company_name').val('');
            }
            $('#company_id').val(suggestion.company.id);
            $('#project_id').val(suggestion.mainproject.id);
            proj_id = suggestion.mainproject.id;
            $("#company_name").removeClass("disabled");
            $("#project_name").removeClass("disabled");

            initCompany(suggestion.id);
            initProject(suggestion.id);
          }
        }).on('typeahead:autocomplete', function(ev, suggestion) {
          if(suggestion.id){
            $('#client_id').val(suggestion.id);
            $('#contact_person_fname').val(suggestion.fname);
            if(suggestion.company.name != '-'){
              $('#company_name').val(suggestion.company.name);
            }else{
              $('#company_name').val('');
            }
            $('#company_id').val(suggestion.company.id);
            $('#project_id').val(suggestion.mainproject.id);
            proj_id = suggestion.mainproject.id;
            $("#company_name").removeClass("disabled");
            $("#project_name").removeClass("disabled");

            initCompany(suggestion.id);
            initProject(suggestion.id);
          }
        });
      
        $('#contact_person').on('input', function(){
          $("#company_name").prop( "disabled", true );
          $("#company_name").addClass("disabled");
          $("#project_name").prop( "disabled", true );
          $("#project_name").addClass("disabled");
          $('#client_id').val('');
          $('#company_id').val('');
          $('#company_name').val('');
          $('#project_id').val('');
          $('#project_name').val('');
          if($('#contact_person_fname').val()){
            $('#contact_person_fname').val('');
          }
        });

        $( "#contact_person" ).change(function() {
          if($('#client_id').val() == ''){
            initCompany(0);
            initProject(0);
          }
        });

      }
    /* CLIENTS Typeahead */


    /* COMPANIES Typeahead */
      function initCompany(cid){
        $('#company_name').typeahead('destroy');

        var comp_url = "{{ route('companyinvoiceauto') }}?c=" + cid + "&q=%QUERY%";

        $( "#company_name" ).prop( "disabled", false );

        var companies = new Bloodhound({
            remote: {
                url: comp_url,
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
            source: companies.ttAdapter(),
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'companies',
            // the key from the array we want to display (name,id,email,etc...)
            display: 'name',
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function (data) {
                  //$('#company_id').val(1);
                  return '<div class="list-group-item">' + data.name + '</div>';

                }
            }

        }).on('typeahead:select', function(ev, csuggestion) {
          if(csuggestion.id){
            $('#company_id').val(csuggestion.id);
          }
        }).on('typeahead:autocomplete', function(ev, csuggestion) {
          if(csuggestion.id){
            $('#company_id').val(csuggestion.id);
          }
        });

      }
    /* COMPANIES Typeahead */

    /* PROJECTS Typeahead */
      function initProject(cid){
        $('#project_name').typeahead('destroy');
        var comp_url = "{{ route('projectinvoiceauto') }}?c=" + cid + "&q=%QUERY%";

        $( "#project_name" ).prop( "disabled", false );

        var projects = new Bloodhound({
            remote: {
                url: comp_url,
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $("input#project_name").typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: projects.ttAdapter(),
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'projects',
            // the key from the array we want to display (name,id,email,etc...)
            display: 'name',
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function (data) {
                  //$('#company_id').val(1);
                  return '<div class="list-group-item">' + data.name + '</div>';

                }
            }

        }).on('typeahead:select', function(ev, suggestion) {
          if(suggestion.id){
            $('#project_id').val(suggestion.id);
          }
        }).on('typeahead:autocomplete', function(ev, suggestion) {
          if(suggestion.id){
            $('#project_id').val(suggestion.id);
          }
        });



      }
    /* PROJECTS Typeahead */


    initClients();
    //initCompany();

    $('#company_name').on('input', function(){
      $('#company_id').val(1);
    });

    $('#project_name').on('input', function(){
      $('#project_id').val(proj_id);
    });


  }); //Document Ready end
</script>

@endpush
