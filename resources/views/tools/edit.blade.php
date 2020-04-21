@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Edit Tool</div>
        </div>

          <div class="card-body">

            <form action="/tools/edit/{{ $tool->id }}" enctype="multipart/form-data" method="POST">
              @csrf
              @method('PATCH')
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="name" class="col-form-label">Tool Name <span class="required">*</span></label>
                
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $tool->name }}" required autofocus autocomplete="off">

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

              </div>



              <div class="form-group row d-flex">

                <div class="col-md-6">
                  <label for="model" class="col-form-label">Model </label>

                    <input id="model" 
                      type="text" 
                      class="form-control @error('model') is-invalid @enderror" 
                      name="model" 
                      value="{{ old('model') ?? $tool->model }}"  
                      autofocus autocomplete="off">

                    @error('model')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="col-md-6">
                  <label for="brand" class="col-form-label">Brand</label>
                    <input id="brand" 
                      type="text" 
                      class="form-control @error('brand') is-invalid @enderror" 
                      name="brand" 
                      value="{{ old('brand') ?? $tool->brand }}"  
                      autofocus autocomplete="off">

                    @error('brand')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>

              <div class="form-group row">
                <div class="col-12 mb-3">
                  <label for="notes" class="col-form-label">Notes</label>

                    <textarea id="notes" 
                      type="text" 
                      class="form-control @error('notes') is-invalid @enderror" 
                      name="notes" autofocus>{{ old('notes') ?? $tool->notes }}</textarea>

                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>  


              <hr >

              <div class="form-group">
                <label for="name" class="col-form-label">Suppliers</label>
      
                  <div class="field_wrapper">

                    @if(count($tool->suppliers) == 0)
                      <div class="generated_inputs row">
                        <div class="col-6">
                          <div class="input_holder"><input type="text" name="supplier_name[]" value="" class="form-control supplier_name" placeholder="Search by Supplier Name" /><input type="hidden" name="supplier_id[]" value="" class="supplier_id" /></div>
                        </div>
                        <div>
                          <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/images/add-icon.png"/></a>
                        </div>
                      </div>
                      <?php $key = 1; ?>
                    @else
                      @foreach($tool->suppliers as $key => $supplier)
                        @if($key == 0)
                          <div class="generated_inputs row">
                            <div class="col-6">
                              <div class="input_holder"><input type="text" name="supplier_name[]" value="{{ $supplier->name }}" class="form-control supplier_name" placeholder="Search by Supplier Name" /><input type="hidden" name="supplier_id[]" value="{{ $supplier->id }}" class="supplier_id" /></div>
                            </div>
                            <div>
                              <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/images/add-icon.png"/></a>
                            </div>
                          </div>
                        @else
                          <div class="generated_inputs row" data-rowid="{{ $key }}"><div class="col-6 pt-2"><div class="input_holder"><input type="text" name="supplier_name[]" value="{{ $supplier->name }}" class="form-control supplier_name" placeholder="Search by Supplier Name" /><input type="hidden" name="supplier_id[]" value="{{ $supplier->id }}" class="supplier_id" /></div></div><div><a href="javascript:void(0);" class="remove_button" data-delid="{{ $key }}"><img src="/images/remove-icon.png" /></a></div></div>
                        @endif
                        <?php $key++; ?>
                      @endforeach
            
                    @endif




                  </div>
             

              </div>


            <div class="row py-2">
              <div class="col-12">
                <button id="submit-button" type="submit" class="btn btn-primary btn-lg">Edit Tool</button>
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

<script type="text/javascript">
  $(document).ready(function(){
      var maxField = 5; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      //var x = 1; //Initial field counter is 1
      var x = {{ $key }};
      
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
