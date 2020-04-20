@extends('layouts.app')
@section('content')

<div class="container">
  <div id="invoice_heading" class="d-flex justify-content-between align-self-center">
    <h1>Edit Invoice</h1>
    <div id="invoice_id" class="col-md-4">
      <span>ID #</span> 
        {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-body">

            <form action="/invoices/edit/{{ $invoice->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')

              
              <div class="row">
                <div class="col-md-9">

                  <div class="form-group row">
                    <div class="col-md-6">
                      <div>

                        <label for="contact_person" class="col-form-label">Client Name <span class="required">*</span></label>
                          
                          <div class="d-flex">
                            <div class="w-50">
                              <input id="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') ?? $invoice->client->lname }}" required autofocus autocomplete="off" placeholder="Search last name">
                            </div>
                            <div class="w-50">
                              <input id="contact_person_fname" class="form-control ml-2" type="text" value=" {{ old('contact_person_fname') ?? $invoice->client->fname }}" disabled>
                            </div>
                          </div>

                          <input id="client_id" type="hidden" name="client_id" value="{{ old('client_id') ?? $invoice->client->id }}" required>

                          @error('contact_person')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                      </div>
                    </div>


                    <div class="d-flex col-md-3">
                      <div class="align-self-end">
                        <input type="checkbox" id="is_up" name="is_up" value="1" @if($invoice->is_up == 1) checked @endif >
                        <label for="is_up" class="pl-2 col-form-label">is UP?</label>
                      </div>
                    </div>
                    
                    <div class="col-md-3">
                      <label for="status" class="col-form-label">Status <span class="required">*</span></label>

                        <select id="status" name="status" class="form-control @error('$status') is-invalid @enderror" autofocus>



                        @foreach($status as $statnum => $statdesc) 
                          <option value="{{ $statnum }}" @if($statnum == $invoice->status) selected @endif >{{ $statdesc }}</option>
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
                            value="{{ old('company_name') ?? $current_data['company_name'] }}"  
                            autocomplete="off" autofocus placeholder="Search company name">

                          <input id="company_id" 
                            type="hidden" 
                            name="company_id" 
                            value="{{ old('company_id') ?? $invoice->company->id }}">

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
                            value="{{ old('project_name') ?? $current_data['project_name'] }}"  
                            autocomplete="off" autofocus placeholder="Search Project name">

                          <input id="project_id" 
                            type="hidden" 
                            name="project_id" 
                            value="{{ old('project_id') ?? $invoice->project->id }}">

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
                          <input name="created_at" type="text" class="form-control" value="{{ old('created_at') ?? datetoDpicker($invoice->created_at) }}" required autocomplete="off" placeholder="mm/dd/yyyy">

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
                          <input name="due_date" type="text" class="form-control" value="{{ old('due_date') ?? $current_data['due_date'] }}" autocomplete="off" placeholder="mm/dd/yyyy">

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

     
             
              <?php $key = 1; ?>

              <div id="invoice_items_table">
                <table class="w-100">
                  <thead>
                    <tr>
                      <th>Service</th>
                      <th>Machine</th>
                      <th>Qty</th>
                      <th>Unit</th>
                      <th>Price</th>
                      <th>Amount</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>

                  

@foreach($items as $k => $item)
  <tbody data-rowid="{{ $key }}">
    <tr id="itemrow{{$key}}" class="itemrow"> 
      <td class="services">
        <input type="hidden" id="currentid{{$key}}" name="currentid[]" value="{{ $item['id'] }}" required />

        <select id="services_id{{$key}}" name="services_id[]" class="services_id form-control @error('$services_id') is-invalid @enderror" data-live-search="true" title="Select availed service" data-width="100%" required> 
          @foreach($services as $service) <option value="{{ $service->id }}" @if($item['services_id'] == $service->id) selected @endif >{{ $service->name }}</option> @endforeach </select> 
      </td>

      <td class="machines"> 
        <select id="machines_id{{$key}}" name="machines_id[]" class=" machines_id form-control w-100 @error('$machines_id') is-invalid @enderror" required>
           @foreach($machines as $z => $smachine) 
            @if($smachine['service_id'] == $item['services_id'] )
              <option value="{{ $smachine['smachine_id'] }}" @if($item['machines_id'] == $smachine['smachine_id'] ) selected @endif >{{ $smachine['smachine_name'] }}
              </option>
            @endif
          @endforeach 
        </select> 

        </select> 
      </td> 

      <td class="quantity"> 
        <input type="text" id="quantity{{$key}}" name="quantity[]" value="{{ $item['services_id'] }}" class="form-control w-100 quantity" required /> 
      </td> 

      <td class="unit"> 
        <input type="text" id="unit{{$key}}" name="unit[]" value="{{ $item['unit'] }}" class="form-control unit w-100 quantity" disabled="disabled" /> 
      </td> 

      <td class="price">
        <input type="hidden" id="up_price{{$key}}" name="up_price[]" value="{{ $item['up_price'] }}" class="form-control up_price w-100 quantity" disabled="disabled" /> 
        <input type="hidden" id="def_price{{$key}}" name="def_price[]" value="{{ $item['def_price'] }}" class="form-control def_price w-100 quantity" disabled="disabled" /> 
        <input type="text" id="price{{$key}}" name="price[]" value="{{ pricesInvoiceForm($item['price']) }}" class="form-control price w-100 quantity" disabled="disabled" /> 
      </td> 

      <td class="amount"> 
        <input type="text" id="amount{{$key}}" name="amount[]" value="{{ pricesInvoiceForm($item['amount']) }}" class="form-control amount w-100 quantity" disabled="disabled" /> 
      </td> 

      <td class="option"> 
        <a href="javascript:void(0);" class="remove_button" data-delid="{{ $key }}"><img src="/images/remove-icon.png" /></a> 
      </td> 
    </tr> 

    <tr id="itemrow{{$key}}" class="descrow"> 
      <td class="notes" colspan="5"> 
        <input type="text" id="notes{{$key}}" name="notes[]" value="{{ $item['notes'] }}" class="form-control w-100 quantity" placeholder="Description (optional)" /> 
      </td> 
      <td class="amount">&nbsp;</td> <td class="option">&nbsp;</td> 
    </tr>

  </tbody>
  <?php $key++; ?>
@endforeach



                  
                </table>

                <a href="javascript:void(0);" id="invoice_add_button" class="add_button" title="Add field">
                  <i class="fas fa-plus"></i>
                  <span>Add another line item</span>
                </a>

              </div>





              <div id="totals_section" class="d-flex align-items-end flex-column">

                <div id="totals_form_group">
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="subtotal" class="col-form-label">Subtotal </label>
                    </div>
                    <div class="col-md-6">
                        <input id="subtotal" 
                          type="text" 
                          class="form-control"
                          name="subtotal" 
                          value="{{ old('subtotal') ?? pricesInvoiceForm($invoice->subtotal) }}"  
                          readonly>

                        @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="discount" class="col-form-label"><span id="discount_type" class="required"></span> Discount %</label>
                    </div>
                    <div class="col-md-6">
                        <input id="discount" 
                          type="text" 
                          class="form-control"
                          name="discount" 
                          value="{{ old('discount') ?? $invoice->discount + 0 }}" readonly="">

                          <input id="dtype" 
                          type="hidden" 
                          name="dtype" value="{{ old('dtype') ?? $invoice->discount_type }}">

                        @error('discount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                  </div>

                  <div class="form-group row">
                    <div class="col-md-6 flex align-self-center">
                      <label id="label_total" for="total" class="col-form-label">Total </label>
                    </div>
                    <div class="col-md-6">
                        <input id="total" 
                          type="text" 
                          class="form-control"
                          name="total" 
                          value="{{ old('total') ?? pricesInvoiceForm($invoice->total) }}"  
                          readonly>

                        @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                </div>
              </div>


            <div class="row py-2">
              <div class="col-12">
                <button id="big-add-button" class="btn btn-primary btn-lg" type="submit">Update Invoice</button>
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


 

      var maxField = 10; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('tbody'); //Input field wrapper
      var x = {{ $key }};

      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields

        var fieldHTML = '<tbody data-rowid="' + x + '"><tr id="itemrow' + x + '" class="itemrow"> <td class="services"> <input type="hidden" id="currentid"' + x + '" name="currentid[]" value="0" required /> <select id="services_id' + x + '" name="services_id[]" class="services_id form-control @error('$services_id') is-invalid @enderror" data-live-search="true" title="Select availed service" data-width="100%" required> @foreach($services as $service) <option value="{{ $service->id }}">{{ $service->name }}</option> @endforeach </select> </td> <td class="machines"> <select id="machines_id' + x + '" name="machines_id[]" class=" machines_id form-control w-100 @error('$machines_id') is-invalid @enderror" disabled="disabled" required> </select> </td> <td class="quantity"> <input type="text" id="quantity' + x + '" name="quantity[]" value="" class="form-control w-100 quantity" required /> </td> <td class="unit"> <input type="text" id="unit' + x + '" name="unit[]" value="" class="form-control unit w-100 quantity" disabled="disabled" /> </td> <td class="price"> <input type="hidden" id="up_price' + x + '" name="up_price[]" value="" class="form-control up_price w-100 quantity" disabled="disabled" /> <input type="hidden" id="def_price' + x + '" name="def_price[]" value="" class="form-control def_price w-100 quantity" disabled="disabled" /> <input type="text" id="price' + x + '" name="price[]" value="" class="form-control price w-100 quantity" disabled="disabled" /> </td> <td class="amount"> <input type="text" id="amount' + x + '" name="amount[]" value="" class="form-control amount w-100 quantity" disabled="disabled" /> </td> <td class="option"> <a href="javascript:void(0);" class="remove_button" data-delid="' + x + '"><img src="/images/remove-icon.png" /></a> </td> </tr> <tr id="itemrow' + x + '" class="descrow"> <td class="notes" colspan="5"> <input type="text" id="notes' + x + '" name="notes[]" value="" class="form-control w-100 quantity" placeholder="Description (optional)" /> </td> <td class="amount">&nbsp;</td> <td class="option">&nbsp;</td> </tr></tbody>'; 
        //New input field html 

        if(x < maxField){ 
            x++; //Increment field counter
            var body = $('#invoice_items_table table');
            body.append(fieldHTML); //Add field html
            body.find('.services_id').selectpicker();
            body.find('.machines_id').selectpicker();
            initItemsTable();
        }

        initDeleteItemRow();
      });


      function initDeleteItemRow(){
        $('.remove_button').on('click', function(){
          var toDelete = $(this).data("delid"); //Remove field html
          $("[data-rowid=" + toDelete + "]").remove();
          x--; //Decrement field counter
          updateTotal();
        });

      }


      initDeleteItemRow();




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
            $("#discount").val(0);
            $("#discount_type").text('');
            $("#dtype").val(0);
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


            // FOR Discounts 
              var dob = new Date(suggestion.date_of_birth);
              var discounts = [<?php echo '"'.implode('","', $discounts).'"' ?>];

              if(dob != null){
                var today = new Date();
                var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
                var age = parseInt(dayDiff);
              }

              if(suggestion.is_pwd == 1 || age >= 60){
                if(suggestion.is_pwd == 1 && age >= 60){
                  applied_discount = (discounts[0] < discounts[1]) ? discounts[1] : discounts[0];
                  $("#discount_type").text('');
                  $("#discount").val(applied_discount);

                  if(discounts[0] == applied_discount){
                    $("#discount_type").text('(PWD)');
                    $("#dtype").val(1);
                  }else{
                    $("#discount_type").text('(SC)');
                    $("#dtype").val(2);
                  }
                }else{
                  if(suggestion.is_pwd == 1){
                    $("#discount_type").text('');
                    $("#discount").val(discounts[0]);
                    $("#discount_type").text('(PWD)');
                    $("#dtype").val(1);
                  }

                  if(age >= 60){
                    $("#discount_type").text('');
                    $("#discount").val(discounts[1]);
                    $("#discount_type").text('(SC)');
                    $("#dtype").val(2);
                  }
                }
                updateTotal();
              }
            // FOR Discounts 

            initCompany(suggestion.id);
            initProject(suggestion.id);
            $("#status").focus();
          }
        }).on('typeahead:autocomplete', function(ev, suggestion) {
          if(suggestion.id){
            $("#discount").val(0);
            $("#discount_type").text('');
            $("#dtype").val(0);
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


            // FOR Discounts 
              var dob = new Date(suggestion.date_of_birth);
              var discounts = [<?php echo '"'.implode('","', $discounts).'"' ?>];

              if(dob != null){
                var today = new Date();
                var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
                var age = parseInt(dayDiff);
              }

              if(suggestion.is_pwd == 1 || age >= 60){
                if(suggestion.is_pwd == 1 && age >= 60){
                  applied_discount = (discounts[0] < discounts[1]) ? discounts[1] : discounts[0];
                  $("#discount_type").text('');
                  $("#discount").val(applied_discount);

                  if(discounts[0] == applied_discount){
                    $("#discount_type").text('(PWD)');
                    $("#dtype").val(1);
                  }else{
                    $("#discount_type").text('(SC)');
                    $("#dtype").val(2);
                  }
                }else{
                  if(suggestion.is_pwd == 1){
                    $("#discount_type").text('');
                    $("#discount").val(discounts[0]);
                    $("#discount_type").text('(PWD)');
                    $("#dtype").val(1);
                  }

                  if(age >= 60){
                    $("#discount_type").text('');
                    $("#discount").val(discounts[1]);
                    $("#discount_type").text('(SC)');
                    $("#dtype").val(2);
                  }
                }
                updateTotal();
              }
            // FOR Discounts 

            initCompany(suggestion.id);
            initProject(suggestion.id);
            $("#status").focus();
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
          $('#discount').val(0);
          $('#dtype').val(0);
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

    $('#company_name').on('input', function(){
      $('#company_id').val(1);
    });

    $('#project_name').on('input', function(){
      $('#project_id').val(proj_id);
    });


    function initItemsTable(){

      $('#is_up').change(function() {

        $("#invoice_items_table table tr.itemrow").each(function() {
            var pp = $(this).find('.price');
            var am = $(this).find('.amount').children('input.amount');
            var qu = $(this).find('.quantity').children('input.quantity');
            var up = pp.find('input.up_price').val();
            var dp = pp.find('input.def_price').val();

            if($('#is_up').is(":checked")) {
              pp.find('input.price').val(up);
            }else{
              pp.find('input.price').val(dp);
            }

            var amount = pp.find('input.price').val() * qu.val();
            am.val(amount.toFixed(2));
            updateTotal();
        });
      });


      $('.quantity').on('input', function(){
        var parent = $(this).parents('td');
        var a = parent.siblings('.amount').find('input');
        var p = parent.siblings('.price').find('input.price');
        var qu = $(this).val();
        var amount = p.val() * qu;
        a.val(amount.toFixed(2));
        updateTotal();
      });
    
      $( ".services_id" ).change(function() {
        var parent = $(this).parents('td');
        var up = $('#is_up').is(":checked") ? 1 : 0;
        var u = parent.siblings('.unit').find('input');
        var q = parent.find('.services_id').children("option:selected").val();
        var upp = parent.siblings('.price').find('input.up_price');
        var dp = parent.siblings('.price').find('input.def_price');
        var p = parent.siblings('.price').find('input.price');
        var a = parent.siblings('.amount').find('input');
        var qu = parent.siblings('.quantity').find('input');

        parent.siblings('.quantity').find('input').val('1');
        machine = parent.siblings('.machines').find("select");

        $.ajax({
          url: '{{ route('servicemachines') }}?&q='+ q,
          type: 'get',
          dataType: 'json',
          success:function(response){
            var len = response.length;
            machine.selectpicker('destroy');
            machine.prop( "disabled", false );
            machine.empty();
    
            if (len != 0){  
              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                if (response[i]['main'] == 1){
                  machine.append("<option value='"+id+"' selected>"+name+"</option>");
                }else{
                  machine.append("<option value='"+id+"'>"+name+"</option>");
                }
              }
              machine.selectpicker();
            }
          }
        });

        $.ajax({
          url: '{{ route('servicedetails') }}?&q='+ q,
          type: 'get',
          dataType: 'json',
          success:function(response){
            console.table(response);

            u.val(response['unit']);
            upp.val(response['up_price'].toFixed(2));
            dp.val(response['def_price'].toFixed(2));


            if(up == 1){
              p.val(upp.val());
            }else{
              p.val(dp.val());
            }
            
            var amount = p.val() * qu.val();
            a.val(amount.toFixed(2));

            updateTotal();
          }
        });

      });

    }



    function updateTotal(){ 
      var subtotal = 0;

      $("#invoice_items_table table tr.itemrow").each(function() {
          var pp = $(this).find('.price');
          var am = $(this).find('.amount').children('input.amount');
          var qu = $(this).find('.quantity').children('input.quantity');
          var amount = pp.find('input.price').val() * qu.val();
          
          subtotal = subtotal + amount;
      });

       $("#subtotal").val(subtotal.toFixed(2));

       var discount = $("#discount").val() / 100;

        
        var total = subtotal - (subtotal * discount);
        $("#total").val(total.toFixed(2));



    }

    initClients();
    initProject('{{ $invoice->client->id }}');
    initCompany('{{ $invoice->client->id }}');
    initItemsTable();
    updateTotal();

  }); //Document Ready end
</script>

@endpush
