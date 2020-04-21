
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Quick Add Client</h4>
    </div>
    <div class="modal-body">
        <form id="ajaxForm" name="ajaxForm" class="form-horizontal">

          <input id="updatedby_id" type="hidden" value="{{ $user->id }}">
          <input type="hidden" id="token_check" name="token_check" value="{{ $dtoken }}">

            <div class="form-group row d-flex">
              <div class="col-md-6">
                <label for="fname" class="col-form-label">First Name <span class="required">*</span></label>
              
                  <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autofocus autocomplete="off">

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
                    value="{{ old('lname') }}" required 
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
                <label for="position" class="col-form-label">Position in Company <span class="required">*</span></label>

                  <input id="position" 
                    type="text" 
                    class="form-control @error('position') is-invalid @enderror" 
                    name="position" 
                    value="{{ old('position') }}" required autofocus>

                  @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>


              <div class="col-md-6">
                <label for="gender" class="col-form-label">Gender <span class="required">*</span></label>

                <div class="d-flex">
                  <div class="mr-3">
                    <input type="radio" id="male" name="gender" value="m" class="@error('gender') is-invalid @enderror" required>
                    <label for="male">Male</label>
                  </div>
                  <div>
                    <input type="radio" id="female" name="gender" value="f" class="@error('gender') is-invalid @enderror">
                    <label for="female">Female</label>
                  </div>
                </div>


                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>


            </div>




            <div class="form-group row d-flex">

              <div class="col-md-6">
                <label for="client_email" class="col-form-label">Email Address (Personal)</label>

                  <input id="client_email" 
                    type="text" 
                    class="form-control @error('client_email') is-invalid @enderror"
                    name="client_email" 
                    value="{{ old('client_email') }}"  
                    autofocus autocomplete="off">

                  @error('client_email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>


              <div class="col-md-6">
                <label for="client_number" class="col-form-label">Number (Personal)</label>

              
                  <input id="client_number" 
                    type="text" class="form-control @error('client_number') is-invalid @enderror" 
                    name="client_number" 
                    value="{{ old('client_number') }}"  
                    autofocus autocomplete="off">

                  @error('client_number')
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
                    <option value="{{ $regtype_id_unit->id }}">{{ $regtype_id_unit->name }}</option>
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
                    <option value="{{ $sector_id_unit->id }}">{{ $sector_id_unit->name }}</option>
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

                <label class="col-form-label">Check everything that applies</label>

                <div>
                  <input type="checkbox" id="is_pwd" name="is_pwd" value="1">
                  <label for="is_pwd" class="pl-2 col-form-label">PWD</label>
                  <br />

                  <input type="checkbox" id="is_freelancer" name="is_freelancer" value="1">
                  <label for="is_freelancer" class="pl-2 col-form-label">Freelancer</label>

                  <br />
                  <input type="checkbox" id="is_food" name="is_food" value="1">
                  <label for="is_food" class="pl-2 col-form-label">Food Industry</label>
                </div>

              </div>


            </div>




          <div class="form-group row">
            <div class="col-12">
             <button type="submit" class="btn btn-primary btn-lg" id="btn-save" value="create">Add Client
             </button>
             <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Cancel</button>


             
            </div>
          </div>
        </form>
    </div>
</div>
</div>
</div>

