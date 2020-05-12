@extends('layouts.print')
@section('content')

<div class="container">
  <div id="official_bill">

    <div id="fablab_info" class="row">
      <div class="col-md-6 text-center">
        <img src="/svg/logo.svg" width="175" heigt="175" " alt="">
      </div>

      <div class="col-md-4">
        <h3>FABLAB UP CEBU</h3>
        <p>Address: {!! nl2br(e($appsettings->address )) !!}</p>
        Number: {{ $appsettings->number }}<br />
        Email: {{ $appsettings->email }}<br />
      </div>
    </div>

    <div id="bill_for_settings">

      <div class="row">
        <div class="col-md-6">
          <table id="prepared_for">
            <thead>
              <th>
                Billing Form Prepared For
              </th>
            </thead>
            <tr>
              <td>
                <strong>{{ $bill->for_name }}</strong><br />
                @if ($bill->for_position)
                  <span>{{ $bill->for_position }}</span><br />
                @endif
                @if ($bill->for_company != '-')
                  <span>{{ $bill->for_company }}</span><br />
                @endif
              </td>
            </tr>
            
          </table>

        </div>

        <div class="form-group col-md-6">
          <table id="invoice_info">
            <tr>
              <td class="heading"><strong>Billing Date</strong></td>
              <td><span>{{ dateShortOnly($bill->billing_date) }}</span></td>
            </tr>
            <tr>
              <td class="heading"><strong>Billing No</strong></td>
              <td><span>{{ str_pad($bill->invoice_id, 6, '0', STR_PAD_LEFT) }}</span></td>
            </tr>
          </table>

        </div>
      </div>
    </div>


    <div id="bill_message">
      <h3>Billing Form</h3>
      <div class="row">
        <div class="col-lg-12">
          <p>
            {!! nl2br(e($bill->letter)) !!}
          </p>
        </div>
      </div>
    </div>


    <div id="invoice_items_table">
      <table class="w-100">
        <thead>
         
            <th>Service</th>
            <th class="quantity">Qty</th>
            <th>/Unit</th>
            <th class="price">Price</th>
            <th class="amount">Amount</th>
      
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

          <tr class="subtotal">
            <td colspan="3">&nbsp</td>
            <td>Subtotal</td>
            <td>{{ priceFormatFancy($invoice->subtotal) }}</td>
          </tr>
          <tr class="discount">
            <td colspan="3">&nbsp</td>
            <td>
            
              @if( $invoice->discount_type == 1 ) PWD @endif
              @if( $invoice->discount_type == 2 ) SC @endif
              Discount
         
            </td>
            <td>{{ $invoice->discount + 0 }}%</td>
          </tr>

          <tr class="total">
            <td colspan="3">&nbsp</td>
            <td class="grand"><strong>Total</strong></td>
            <td class="grand"><strong>{{ priceFormatFancy($invoice->subtotal) }}</strong></td>
          </tr>


        </tbody>
      </table>
    </div>


    
    <div id="prepared_by_settings" class="row">
      <div class="col-md-6">


         <h5>Prepared By</h5>


          <div class="info-item">
            <strong>{{ $bill->by_name }}</strong><br>
            @if ($bill->by_position)
              <span>{{ $bill->by_position }}</span>
            @endif

  
          </div>
          
        



      </div>

      <div class="col-md-6">


         <h5>Conforme</h5>


          <div class="info-item ">
            <strong>Printed Name and Signature</strong><br>
            
            <span>(Authorized Signatory)</span>
          

  
          </div>
        
        



      </div>

    </div>



  </div>
</div>



@stop

