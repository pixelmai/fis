@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit Service</div>
        </div>

          <div class="card-body">

            <form action="/services/edit/{{ $service->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Service Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $service->name  }}" required autofocus autocomplete="off">

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
                      <option value="{{ $servcat_id_unit->id }}" @if($service->servcats_id == $servcat_id_unit->id) selected @endif>{{ $servcat_id_unit->name }}</option>
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
                      value="{{ old('unit') ?? $service->unit  }}"  
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
                      value="{{ old('def_price') ?? priceFormat($service->current->def_price)  }}"  
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
                      value="{{ old('up_price') ?? priceFormat($service->current->up_price) }}"  
                      autofocus required autocomplete="off">

                    @error('up_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>


              <hr >

              <div class="form-group">
                <label for="name" class="col-form-label">Machines</label>
      
                  
                  <div class="field_wrapper">
                    <?php $key = 1; ?>
                     @if(count($service->machines) == 0)
                      <div class="generated_inputs row">
                        <div class="col-6">
                          <div class="input_holder"><input type="text" name="machine_name[]" value="" class="form-control machine_name" placeholder="Search by Machine Name" /><input type="hidden" name="machine_id[]" value="" class="machine_id" /></div>
                        </div>
                        <div>
                          <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/images/add-icon.png"/></a>
                          <input type="radio" id="def1" name="default" class="def" value="0" checked><label for="def1">default</label>
                        </div>
                      </div>
                      <?php $key++; ?>
                    @else
                      @foreach($service->machines as $machine)
                        @if($key == 1)
                          <div class="generated_inputs row">
                            <div class="col-6">
                              <div class="input_holder"><input type="text" name="machine_name[]" value="{{ $machine->name }}" class="form-control machine_name" placeholder="Search by Machine Name" /><input type="hidden" name="machine_id[]" value="{{ $machine->id }}" class="machine_id" /></div>
                            </div>
                            <div>
                              <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/images/add-icon.png"/></a>
                              <input type="radio" id="def1" name="default" class="def" value="{{ $machine->id }}" @if($machine->id == $service->machines_id) checked @endif><label for="def1">default</label>
                            </div>
                          </div>
                        @else
                          <div class="generated_inputs row" data-rowid="{{ $key }}"><div class="col-6"><div class="input_holder"><input type="text" name="machine_name[]" value="{{ $machine->name }}" class="form-control machine_name" placeholder="Search by Machine Name" /><input type="hidden" name="machine_id[]" value="{{ $machine->id }}" class="machine_id" /></div></div><div><a href="javascript:void(0);" class="remove_button" data-delid="{{ $key }}"><img src="/images/remove-icon.png" /></a>
                          <input type="radio" id="def{{ $key }}" name="default" class="def" value="{{ $machine->id }}" required @if($machine->id == $service->machines_id) checked @endif><label for="def{{ $key }}">default</label></div></div>
                        @endif
                        <?php $key++; ?>
                      @endforeach

                    @endif



                  </div>
              </div>

            <div class="row py-2">
              <div class="col-12">
                <button id="submit-button" type="submit" class="btn btn-primary btn-lg">Edit Service</button>
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

      var maxField = 5; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var x = {{ $key }};
      
      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields

        var fieldHTML = '<div class="generated_inputs row" data-rowid="' + x + '"><div class="col-6"><div class="input_holder"><input type="text" name="machine_name[]" value="" class="form-control machine_name" placeholder="Search by Machine Name" /><input type="hidden" name="machine_id[]" value="" class="machine_id" /></div></div><div><a href="javascript:void(0);" class="remove_button" data-delid="' + x + '"><img src="/images/remove-icon.png" /></a> <input type="radio" id="def' + x + '" name="default" class="def" value="" required><label for="def' + x + '">default</label></div></div></div></div>'; //New input field html 

          if(x < maxField){ 
              x++; //Increment field counter
              $(wrapper).append(fieldHTML); //Add field html
          }

        $('.machine_name').typeahead('destroy');

        initTypeAhead(".machine_name");

        initValResetters();
      });
      
      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          var toDelete = $(this).data("delid"); //Remove field html
          $("[data-rowid=" + toDelete + "]").remove();
          x--; //Decrement field counter
          $('#def1').prop("checked", true);
      });



      /* Bloodhound Type Ahead */

        var engine = new Bloodhound({
            remote: {
                url: '{{ route('machinesauto') }}?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        initTypeAhead(".machine_name");

      /* Bloodhound Type Ahead */


      function initTypeAhead(className){

        $(className).typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: engine.ttAdapter(),
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'machine',
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
                  $(this).parent().siblings('.machine_id').val('');
                  return '<div class="list-group-item">' + data.name +'</div>';
                }
            }

        }).on('typeahead:select', function(ev, suggestion) {
          if(suggestion.id){
            console.log(suggestion.id);
            $(this).parent().siblings('.machine_id').val(suggestion.id);
            var p = $(this).parent().parent().parent().parent();
            p.find('.def').val(suggestion.id);
          }
        }).on('typeahead:autocomplete', function(ev, suggestion) {
          if(suggestion.id){
            console.log(suggestion.id);
            $(this).parent().siblings('.machine_id').val(suggestion.id);
            var p = $(this).parent().parent().parent().parent();
            p.find('.def').val(suggestion.id);
          }
        });
      }

      initValResetters();

      function initValResetters(){
        $('.machine_name').on('input', function(){
          $(this).parent().siblings('.machine_id').val('');
          var p = $(this).parent().parent().parent().parent();
          p.find('.def').val(0);
          $('#def1').prop("checked", true);
        });
      }

  }); //end document ready


  </script>


@endpush
