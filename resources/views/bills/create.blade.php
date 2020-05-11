@extends('layouts.app')
@section('content')

<div class="container">
  <div id="invoice_heading">
    <h1>Create Official Bill</h1>
  </div>

  <div id="official_bills_form" class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form if="invoices_form" action="/bills/store" enctype="multipart/form-data" method="POST">

          @csrf

          <input type="hidden" name="token_check" value="{{ $dtoken }}">
          <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

          <h5>Prepared for</h5>
          <div id="bill_for_settings" class="row">

            <div class="col-lg-8">
              <div class="form-group w-75">

                <div class="row">
                  <div class="col-lg-3">
                    <label for="for_name" class="col-form-label">Name <span class="required">*</span></label>
                  </div>
                  <div class="col-lg-9">

                    <input id="for_name_orig" type="hidden" 
                    value="{{ $invoice->client->fname }} {{ $invoice->client->lname }}">

                    <input id="for_name" 
                      type="text" 
                      class="w-100 form-control @error('for_name') is-invalid @enderror"
                      name="for_name" required="required" 
                      value="{{ $invoice->client->fname }} {{ $invoice->client->lname }}">
                    @error('for_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                </div>
               
                <div class="row">
                  <div class="col-lg-3">
                    <label for="for_position" class="col-form-label">Position</label>
                  </div>
                  <div class="col-lg-9">

                    <input id="for_position_orig" type="hidden" 
                    value="{{ $invoice->client->position }}">

                    <input id="for_position" 
                      type="text" 
                      class="w-100 form-control @error('for_position') is-invalid @enderror"
                      name="for_position" 
                      value="{{ $invoice->client->position }}">
                    @error('for_position')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-3">
                    <label for="for_company" class="col-form-label">Company</label>
                  </div>
                  <div class="col-lg-9">

                    <input id="for_company_orig" type="hidden" 
                    value="{{ $invoice->company->name }}">

                    <input id="for_company" 
                      type="text" 
                      class="w-100 form-control @error('for_company') is-invalid @enderror"
                      name="for_company" 
                      value="{{ $invoice->company->name != '-' ? $invoice->company->name : '' }}">
                    @error('for_company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                </div>


                <div class="row">
                  <div class="col-md-3">
                    &nbsp;
                  </div>
                  <div class="col-md-9">
                    <a id="invoice_defaults" class="btn btn-outline-secondary btn-sm">
                      Use Invoice Details
                    </a>
                    <a id="clear_invoice_defaults" class="btn btn-outline-secondary btn-sm">
                      Clear
                    </a>
                  </div>
                </div>


              </div>

            </div>

            <div class="form-group col-lg-4">
              <div class="row">
                <div class="col-lg-4">
                  <label for="billing_date" class="col-form-label">Date <span class="required">*</span></label>
                </div>
                <div class="col-lg-8">

                  <div id="billing_date" class="input-group date @error('billing_date') is-invalid @enderror" data-provide="datepicker">
                      <input name="billing_date" type="text" class="form-control" value="{{ old('billing_date') ?? datetoDpicker($invoice->created_at) }}" required autocomplete="off" placeholder="mm/dd/yyyy">

                      <div class="input-group-addon">
                        <span><i class="fa fa-calendar"></i></span>
                      </div>
                  </div>


                  @error('billing_date')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror

                </div>

              </div>


              <div class="row">
                <div class="col-lg-4">
                  <strong>Billing No</strong>
                </div>
                <div class="col-lg-8">
                  {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                </div>

              </div>



            </div> 
          </div>

          <div id="bill_message">
            <div class="row">
              <div class="col-lg-12">
                <label for="letter" class="col-form-label">Letter Message <span class="required">*</span></label>

                <textarea id="letter" 
                  type="text" 
                  class="form-control @error('address') is-invalid @enderror" 
                  name="letter" autofocus required="required" placeholder="Type message here">{{ old('letter') }}</textarea>

                @error('letter')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
          </div>

          <h5>Invoice Items</h5>

          <div id="invoice_items_table">
            <table class="w-100">
              <thead>
                <tr>
                  <th>Service</th>
                  <th class="quantity">Qty</th>
                  <th>/Unit</th>
                  <th class="price">Price</th>
                  <th class="amount">Amount</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $k => $item)
                  <tr class="itemrow">
                    <td class="services"> 
                      {{ $item["services_name"] }} 

                      @if($item["notes"] !='') <em>({{ $item["notes"] }})</em> @endif
                    </td> 
                    <td class="quantity"> 
                      {{ $item["quantity"] + 0 }}
                    </td> 
                    <td class="unit"> 
                      {{ $item["unit"] }}
                    </td> 
                    <td class="price">
                      {{ priceFormatFancy($item["price"]) }}
                     </td> 
                    <td class="amount"> 
                      {{ priceFormatFancy($item["price"] * $item["quantity"]) }}
                    </td> 
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div id="totals_section" class="d-flex align-items-end flex-column">

            <div id="totals_form_group">
              <div class="info-block row">
                <div class="col-6 flex align-self-center">
                  <strong>Subtotal</strong>
                </div>
                <div class="col-6 num">
                  {{ priceFormatFancy($invoice->subtotal) }}
                </div>
              </div>


              <div class="info-block row">
                <div class="col-6 flex align-self-center">
                  <strong>
                    @if( $invoice->discount_type == 1 ) PWD @endif
                    @if( $invoice->discount_type == 2 ) SC @endif
                    Discount
                  </strong>
                </div>
                <div class="col-6 num">
                  {{ $invoice->discount + 0 }}%
                </div>

              </div>

              <div id="grand_total" class="form-group row">
                <div class="col-6 flex align-self-center">
                   <strong>Total</strong>
                </div>
                <div class="col-6 num">
                  <strong>{{ priceFormatFancy($invoice->total) }}</strong>
                </div>
              </div>
            </div>
          </div>

          <h5>Prepared By</h5>
          <div id="prepared_by_settings" class="row">
            <div class="col-lg-8">
              <div class="form-group w-75">

                <div class="row">
                  <div class="col-lg-3">
                    <label for="by_name" class="col-form-label">Name <span class="required">*</span></label>
                  </div>
                  <div class="col-lg-9">

                    <input id="by_fablab_manager" type="hidden" 
                    value="{{ $appsettings->manager }}">

                    <input id="by_name_orig" type="hidden" 
                    value="{{ $user->fname }} {{ $user->lname }}">

                    <input id="by_name" 
                      type="text" 
                      class="w-100 form-control @error('by_name') is-invalid @enderror"
                      name="by_name" required="required" 
                      value="{{ $user->fname }} {{ $user->lname }}">
                    @error('by_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                </div>
               
                <div class="row">
                  <div class="col-lg-3">
                    <label for="by_position" class="col-form-label">Position <span class="required">*</span></label>
                  </div>
                  <div class="col-lg-9">

                    <input id="by_position_orig" type="hidden" 
                    value="{{ $user->position }}">

                    <input id="by_position" 
                      type="text" 
                      class="w-100 form-control @error('by_position') is-invalid @enderror"
                      name="by_position" required="required" 
                      value="{{ $user->position }}">
                    @error('by_position')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-3">
                    &nbsp;
                  </div>
                  <div class="col-md-9">
                    <a id="own_details" class="btn btn-outline-secondary btn-sm">
                      Use Own Details
                    </a>
                    <a id="fablab_manager" class="btn btn-outline-secondary btn-sm">
                      Use Fablab Manager
                    </a>
                    <a id="clear_prepby" class="btn btn-outline-secondary btn-sm">
                      Clear
                    </a>
                  </div>
                </div>


              </div>

            </div>

          </div>

          <div class="row">
            <div class="col-12">
              <button id="submit-button" class="btn btn-primary btn-lg" type="submit">Save Official Bill</button>
            </div>
          </div>


        </form>
      </div>
    </div>
  </div>
</div>



@stop


@push('modals')
  @include('invoices.modalSetStatus')
@endpush


@push('scripts')
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){

      $('#created_at').datepicker({
        maxViewMode: 2,
        orientation: "bottom auto",
        startDate: '01/01/2016',
        endDate: '+1m',
      });


      $('body').on('click', '#invoice_defaults', function () {
        $('#for_name').val($('#for_name_orig').val());
        $('#for_position').val($('#for_position_orig').val());
        $('#for_company').val($('#for_company_orig').val());
      });   
  
      $('body').on('click', '#clear_invoice_defaults', function () {
        $('#for_name').val('');
        $('#for_position').val('');
        $('#for_company').val('');
      });   

      $('body').on('click', '#own_details', function () {
        $('#by_name').val($('#by_name_orig').val());
        $('#by_position').val($('#by_position_orig').val());
      });   

      $('body').on('click', '#fablab_manager', function () {
        $('#by_name').val($('#by_fablab_manager').val());
        $('#by_position').val('Fablab Manager');
      });   
  
      $('body').on('click', '#clear_prepby', function () {
        $('#by_name').val('');
        $('#by_position').val('');
      });   


  }); //Document Ready end
</script>

@endpush
