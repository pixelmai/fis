
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Create Company</h4>
    </div>
    <div class="modal-body">
        <form id="postForm" name="postForm" class="form-horizontal">

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
            
                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" required autofocus autocomplete="off">

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

                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autofocus autocomplete="off">

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>







          <div class="form-group row">

            <div class="col-12">
             <button type="submit"  class="btn btn-primary btn-lg" id="btn-save" value="create">Save
             </button>
            </div>
          </div>
        </form>
    </div>
</div>
</div>
</div>

