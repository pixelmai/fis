@extends('layouts.app')
@section('content')

<div class="container">
  <div id="invoice_heading" class="d-flex justify-content-between align-self-center">
    <h1>Official Bill Details</h1>

    <div id="invoice_id" class="col-md-4">
      <span>ID #</span> {{ $bill->id }}
    </div>

  </div>

  <div id="official_bills_view" class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div id="markers" class="d-flex justify-content-between">
          <div>
            <div class="status status_{{ strtolower($s) }}">{{ $s }}</div>
          </div>

          <div id="invoice_menu">

            @if($s != 'Paid')
              <a href="javascript:void(0);" id="add-log-row" data-id="{{ $invoice->id }}" class="edit btn btn-outline-secondary btn-md">
                <i class="fas fa-history"></i> Change Status
              </a>
            @endif

            <a href="/invoices/view/{{ $invoice->id }}/print" class="edit btn btn-outline-secondary btn-md" target="_blank">
              <i class="fas fa-print"></i> Print
            </a>


            @if($s == 'Draft')
              <a href="/invoices/edit/{{ $invoice->id }}" class="edit btn btn-outline-secondary btn-md">
                <i class="fas fa-edit"></i> Edit
              </a>

              <a href="javascript:void(0);" id="delete-row" data-id="{{ $invoice->id }}" class="delete btn btn-outline-danger btn-md">
                <i class="fas fa-trash"></i> Delete
              </a>
            @endif


          </div>


        </div>
        <div class="card-body">


          <h5>Prepared for</h5>
          <div id="bill_for_settings" class="row">

            <div class="col-lg-8">


              <div class="info-block row">

                
               
                <div class="col-md-12">
                  <div class="info-item ">
                    <strong>{{ $bill->for_name }}</strong>
                    @if ($bill->for_position)
                      <span>{{ $bill->for_position }}</span>
                    @endif
                    @if ($bill->for_company != '-')
                      <span>{{ $bill->for_company }}</span>
                    @endif

                  </div>
                 </div>
                
                



              </div> <!-- end row -->


            </div>

            <div class="form-group col-lg-4">
              <div class="row pb-0">

                <div class="col-lg-4">
                  <strong>Billing Date</strong>
                </div>
                <div class="col-lg-8">

                  @if ($bill->billing_date)
                    <span>{{ dateShortOnly($bill->billing_date) }}</span>
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <strong>Billing No</strong>
                </div>
                <div class="col-lg-8">

                  @if ($bill->billing_date)
                    <span>{{ str_pad($bill->invoice_id, 6, '0', STR_PAD_LEFT) }}</span>
                  @endif
                </div>
              </div>

           



            </div> 
          </div>

          <div id="bill_message">
            <h3>Billing Form</h3>
            <div class="row">


              <div class="col-lg-12">
                {!! nl2br(e($bill->letter)) !!}
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

              <div class="info-block row">

               
                <div class="col-md-12">
                  <div class="info-item ">
                    <strong>{{ $bill->by_name }}</strong>
                    @if ($bill->by_position)
                      <span>{{ $bill->by_position }}</span>
                    @endif

                  </div>
                 </div>
                
              

              </div> <!-- end row -->


            </div>

          </div>


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


  }); //Document Ready end
</script>

@endpush
