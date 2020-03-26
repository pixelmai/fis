
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Create New Company</h4>
    </div>
    <div class="modal-body">
        <form id="ajaxForm" name="ajaxForm" class="form-horizontal">

          <input id="updatedby_id" type="hidden" value="{{ $user->id }}">

          <div class="form-group row">
            <div class="col-md-12">
              <label for="comp_name" class="col-form-label">Company Name <span class="required">*</span>
              </label>
            
                <input id="comp_name" type="text" class="form-control @error('comp_name') is-invalid @enderror" name="comp_name" value="{{ old('comp_name') }}" required autofocus minlength="2" autocomplete="off">

                @error('comp_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>

          </div>



          <div class="form-group row d-flex">

            <div class="col-md-6">
              <label for="comp_email" class="col-form-label">Email Address </label>

                <input id="comp_email" 
                  type="text" 
                  class="form-control @error('comp_email') is-invalid @enderror" 
                  name="comp_email" 
                  value="{{ old('comp_email') }}"  
                  autofocus autocomplete="off">

                @error('comp_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="col-md-6">
              <label for="comp_number" class="col-form-label">Number</label>

            
                <input id="comp_number" 
                  type="text" 
                  class="form-control @error('comp_number') is-invalid @enderror" 
                  name="comp_number" 
                  value="{{ old('comp_number') }}"  
                  autofocus autocomplete="off">

                @error('comp_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <label for="comp_url" class="col-form-label">URL</label>
            
                <input id="comp_url" type="text" class="form-control @error('comp_url') is-invalid @enderror" name="comp_url" value="{{ old('comp_url') }}" autofocus autocomplete="off">

                @error('comp_url')
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
              <label for="comp_address" class="col-form-label">Address</label>

                <textarea id="comp_address" 
                  type="text" 
                  class="form-control @error('comp_address') is-invalid @enderror" 
                  name="comp_address" autofocus>{{ old('comp_address') }}</textarea>

                @error('comp_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>

          <div class="form-group row">
            <div class="col-12">
              <label for="comp_description" class="col-form-label">Description</label>

                <input id="comp_description" type="text" class="form-control @error('comp_description') is-invalid @enderror" name="comp_description" value="{{ old('comp_description') }}" autofocus autocomplete="off">

                @error('comp_description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>



          <div class="form-group row">
            <div class="col-12">
             <button type="submit" class="btn btn-primary btn-lg" id="btn-save" value="create">Add Company
             </button>
             <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Cancel</button>


             
            </div>
          </div>
        </form>
    </div>
</div>
</div>
</div>

