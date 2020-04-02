
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Project Status</h4>
    </div>
    <div class="modal-body">
        <form id="ajaxForm" name="ajaxForm" class="form-horizontal">

          <input id="updatedby_id" type="hidden" value="{{ $user->id }}">

          <div class="form-group row">
            <div class="col-12">
              <p>Please set status the selected projects</p>

              <select id="status" name="status" class="w-50 form-control @error('$status') is-invalid @enderror" autofocus>
                <option value="1">Open</option>
                <option value="2">Completed</option>
                <option value="3">Dropped</option>
              </select>

              @error('$status')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror

            </div>
            
          </div>


          <div class="form-group row">
            <div class="col-12">
             <button type="submit" class="btn btn-primary btn-lg" id="btn-save-status" value="create">Set Status
             </button>
             <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Cancel</button>


             
            </div>
          </div>
        </form>
    </div>
</div>
</div>
</div>

