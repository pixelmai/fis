
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog modal-md">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Set Status and Log</h4>
    </div>
    <div class="modal-body">
        <form id="ajaxForm" name="ajaxForm" class="form-horizontal">

          <input id="tool_id" name="tool_id" type="hidden" value="">
          <input id="updatedby_id" type="hidden" value="{{ $user->id }}">

          <div class="form-group row">
            <div class="col-12">
              <p id="afParagraph">Please set status the selected tools</p>


              <div class="form-group row">
                <div class="col-md-5">
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
                <div class="col-12 mb-3">
                  <label for="notes" class="col-form-label">Log Note <span class="required">*</span></label>

                    <textarea id="notes" 
                      type="text" 
                      class="form-control @error('notes') is-invalid @enderror" 
                      name="notes" autofocus required>{{ old('notes') }}</textarea>

                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>  


              @error('$status')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror

            </div>
            
          </div>

          <div class="form-group row">
            <div class="col-12">
             <button type="submit" class="btn btn-primary btn-lg" id="btn-single-save-status" value="create">Set Status
             </button>
             <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Cancel</button>


             
            </div>
          </div>
        </form>
    </div>
</div>
</div>
</div>

