
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Set Status</h4>
    </div>
    <div class="modal-body">
        <form id="ajaxForm" name="ajaxForm" class="form-horizontal">
          <input id="bill_id" name="bill_id" type="hidden" value="">
          <input id="updatedby_id" type="hidden" value="{{ $user->id }}">

          <div class="form-group row">
            <div class="col-12">

              <div class="form-group row">
                <div class="col-md-12">
                  

                    <select id="status" name="status" class="form-control @error('$status') is-invalid @enderror" autofocus>


                    @foreach($status as $statnum => $statdesc) 
                      @if($statnum != 1 )
                        <option value="{{ $statnum }}">{{ $statdesc }}</option>
                      @endif
                    @endforeach

                    </select>

                    @error('$status')
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
             <button type="submit" class="btn btn-primary btn-lg d-none" id="btn-single-save-status" value="create">Set Status
             </button>

             <button type="submit" class="btn btn-primary btn-lg d-none" id="btn-edit-status" value="create">Edit Status
             </button>

             <button type="submit" class="btn btn-primary btn-lg" id="btn-multiple-save-status" value="create">Set Status
             </button>

             <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Cancel</button>


             
            </div>
          </div>
        </form>
    </div>
</div>
</div>
</div>

