@extends('layouts.app')
@section('content')

<div class="container">
<div class="d-flex justify-content-between">
  <div class="bh">Create New Invoice</div>
  <div class="col-md-2">
    <span class="d-inline">ID #</span>
    <input id="invoice_id" 
      type="text" 
      class="form-control @error('invoice_id') is-invalid @enderror" 
      name="invoice_id" 
      value="{{ old('invoice_id') ?? $id_num }}"  
      autofocus autocomplete="off">

      @error('invoice_id')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
</div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-body">

            <form action="/machines/create" enctype="multipart/form-data" method="POST">
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
                            autocomplete="off" autofocus placeholder="Search company name">

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
                            autocomplete="off" autofocus placeholder="Search Project name">

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
                          <input name="due_date" type="text" class="form-control" value="{{ old('due_date') }}" required autocomplete="off" placeholder="mm/dd/yyyy">

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
             

              <div class="form-group row">

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
        todayBtn: true,
        orientation: "bottom auto",
        startDate: '01/01/2016',
        endDate: '+3m',
      });

      $('#due_date').datepicker({
        maxViewMode: 2,
        todayBtn: true,
        orientation: "bottom auto",
        orientation: "bottom auto",
        startDate: '-1m',
        endDate: '+3m',
      });


      var maxField = 5; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var x = 1; //Initial field counter is 1
      
      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields

        var fieldHTML = '<div class="generated_inputs row" data-rowid="' + x + '"><div class="col-6 pt-2"><div class="input_holder"><input type="text" name="supplier_name[]" value="" class="form-control supplier_name" placeholder="Search by Supplier Name" /><input type="hidden" name="supplier_id[]" value="" class="supplier_id" /></div></div><div><a href="javascript:void(0);" class="remove_button" data-delid="' + x + '"><img src="/images/remove-icon.png" /></a></div></div>'; //New input field html 

          if(x < maxField){ 
              x++; //Increment field counter
              $(wrapper).append(fieldHTML); //Add field html
          }

        $('.supplier_name').typeahead('destroy');

        initTypeAhead(".supplier_name");

      });
      
      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          var toDelete = $(this).data("delid"); //Remove field html
          $("[data-rowid=" + toDelete + "]").remove();

          x--; //Decrement field counter
      });



      /* Bloodhound Type Ahead */

        var engine = new Bloodhound({
            remote: {
                url: '{{ route('suppliersauto') }}?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        initTypeAhead(".supplier_name");

      /* Bloodhound Type Ahead */


      function initTypeAhead(className){
        $(className).typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: engine.ttAdapter(),
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'supplier',
            // the key from the array we want to display (name,id,email,etc...)
            //display: function(cname){return cname.fname+' '+cname.lname},
            display: 'name',
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function (data) {
                  $(this).parent().siblings('.supplier_id').val('');
                  return '<div class="list-group-item">' + data.name +'</div>';
                }
            }

        }).on('typeahead:select', function(ev, suggestion) {
          if(suggestion.id){
            console.log(suggestion.id);
            $(this).parent().siblings('.supplier_id').val(suggestion.id);
          }
        }).on('typeahead:autocomplete', function(ev, suggestion) {
          if(suggestion.id){
            console.log(suggestion.id);
            $(this).parent().siblings('.supplier_id').val(suggestion.id);
          }
        });
      }

      $('.supplier_name').on('input', function(){
        $(this).parent().siblings('.supplier_id').val('');
      });


  }); //Document Ready end
</script>

@endpush
