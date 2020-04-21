@extends('layouts.print')
@section('content')

<div class="container">
  <div id="view_invoice" class="row justify-content-center">
    <div class="col-lg-12">

      <!-- one copy -->
        <div class="text-right">
          FABLAB UP CEBU COPY
        </div>
        <h2>Billing Form</h2>

        <div class="basic_invoice_info row">
          <div class="col-md-9">
            <table>
              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>Name</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->fname }} {{ $invoice->client->lname }}

                      @if($invoice->is_up && $invoice->is_up == 1)
                        <em>(UP)</em>
                      @endif
                  </td>
                </tr>
              @endif

              @if($invoice->company->id)
                <tr>
                  <td class="label">
                    <strong>Company</strong>
                  </td>
                  <td class="value">
                    @if($invoice->company->id != 1)
                        {{ $invoice->company->name }}
                    @else 
                      <em class="info_na">N/A</em>
                    @endif
                  </td>
                </tr>
              @endif

              @if($invoice->project->is_categorized == 1)
                <tr>
                  <td class="label">
                    <strong>Project</strong>
                  </td>
                  <td class="value">
                    {{ $invoice->project->name }}
                  </td>
                </tr>
              @endif

              @if ($invoice->client->address)
                <tr>
                  <td class="label">
                    <strong>Address</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->address }} 
                  </td>
                </tr>
              @endif


              @if ($invoice->client->number)
                <tr>
                  <td class="label">
                    <strong>Contact</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->number }} 
                  </td>
                </tr>
              @endif
            </table>
          </div>

          <div class="col-md-3">


            <table>
              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>FORM No</strong>
                  </td>
                  <td class="value">
                    {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                  </td>
                </tr>
              @endif

              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>Issue Date</strong>
                  </td>
                  <td class="value">
                    {{ dateTimeFormat($invoice->created_at) }}
                  </td>
                </tr>
              @endif

              @if($invoice->due_date)
                <tr>
                  <td class="label">
                    <strong>Due Date</strong>
                  </td>
                  <td class="value">
                    {{ dateShortOnly($invoice->due_date) }}
                  </td>
                </tr>
              @endif

            </table>
          </div> 
        </div>

        <div class="invoice_items_table">
          <table class="w-100">
            <thead>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th class="quantity">Qty</th>
                <th>Unit</th>
                <th class="price">Price</th>
                <th class="amount">Amount</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $k => $item)
                <tr class="itemrow">
                  <td class="id"> 
                    {{ $k + 1 }}
                  </td> 
                  <td class="services"> 
                    {{ $item["services_name"] }}
                    @if($item["notes"] != '')
                      <span class="notes">
                        @if (strlen($item["notes"]) >= 50) 
                          {{ shortenText($item["notes"], 50) }}
                        @else
                          {{ $item["notes"] }}
                        @endif
                      </span>
                    @endif
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

        <div class="totals_section">
          <table class="totals_form_group">
            <tr>
              <td>&nbsp;</td>
              <td class="label">
                Subtotal
              </td>
              <td class="value">
                {{ priceFormatFancy($invoice->subtotal) }}
              </td>
            </tr>
            
            <tr>
              <td>&nbsp;</td>
              <td class="label">
                @if( $invoice->discount_type == 1 ) PWD @endif
                @if( $invoice->discount_type == 2 ) SC @endif
                Discount
              </td>
              <td class="value">
                @if(round($invoice->discount) == 0)
                  ------
                @else
                  {{ $invoice->discount + 0 }}%
                @endif
              </td>
            </tr>

            <tr class="grand_total">
              <td>&nbsp;</td>
              <td class="label">
                Total
              </td>
              <td class="value">
                <strong>{{ priceFormatFancy($invoice->total) }}</strong>
              </td>
            </tr>

          </table>
        </div>

        <div class="signatories">
          <table>
            <tr>
              <td class="label">Prepared by</td>
              <td class="value">{{ $user->fname }} {{ $user->lname }}</td>
              <td class="label">Customer Signature</td>
              <td class="value">&nbsp;</td>
            </tr>
          </table>
        </div>
      

        <div class="footer">
          <img src="/images/invoice_footer.png" alt="" />
          <p><strong><u>Note:</u></strong> After paying at the UP Cebu Cashier's Office, kindly return this copy to Fablab with the  written O.R.#
          </p>
        </div>

        <hr />

      <!-- one copy -->


      <!-- one copy -->
        <div class="text-right">
          CASHIER COPY  
        </div>
        <h2>Billing Form</h2>

        <div class="basic_invoice_info row">
          <div class="col-md-9">
            <table>
              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>Name</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->fname }} {{ $invoice->client->lname }}

                      @if($invoice->is_up && $invoice->is_up == 1)
                        <em>(UP)</em>
                      @endif
                  </td>
                </tr>
              @endif

              @if($invoice->company->id)
                <tr>
                  <td class="label">
                    <strong>Company</strong>
                  </td>
                  <td class="value">
                    @if($invoice->company->id != 1)
                        {{ $invoice->company->name }}
                    @else 
                      <em class="info_na">N/A</em>
                    @endif
                  </td>
                </tr>
              @endif

              @if($invoice->project->is_categorized == 1)
                <tr>
                  <td class="label">
                    <strong>Project</strong>
                  </td>
                  <td class="value">
                    {{ $invoice->project->name }}
                  </td>
                </tr>
              @endif

              @if ($invoice->client->address)
                <tr>
                  <td class="label">
                    <strong>Address</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->address }} 
                  </td>
                </tr>
              @endif


              @if ($invoice->client->number)
                <tr>
                  <td class="label">
                    <strong>Contact</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->number }} 
                  </td>
                </tr>
              @endif
            </table>
          </div>

          <div class="col-md-3">


            <table>
              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>FORM No</strong>
                  </td>
                  <td class="value">
                    {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                  </td>
                </tr>
              @endif

              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>Issue Date</strong>
                  </td>
                  <td class="value">
                    {{ dateTimeFormat($invoice->created_at) }}
                  </td>
                </tr>
              @endif

              @if($invoice->due_date)
                <tr>
                  <td class="label">
                    <strong>Due Date</strong>
                  </td>
                  <td class="value">
                    {{ dateShortOnly($invoice->due_date) }}
                  </td>
                </tr>
              @endif

            </table>
          </div> 
        </div>

        <div class="invoice_items_table">
          <table class="w-100">
            <thead>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th class="quantity">Qty</th>
                <th>Unit</th>
                <th class="price">Price</th>
                <th class="amount">Amount</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $k => $item)
                <tr class="itemrow">
                  <td class="id"> 
                    {{ $k + 1 }}
                  </td> 
                  <td class="services"> 
                    {{ $item["services_name"] }}
                    @if($item["notes"] != '')
                      <span class="notes">
                        @if (strlen($item["notes"]) >= 50) 
                          {{ shortenText($item["notes"], 50) }}
                        @else
                          {{ $item["notes"] }}
                        @endif
                      </span>
                    @endif
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

        <div class="totals_section">
          <table class="totals_form_group">
            <tr>
              <td>&nbsp;</td>
              <td class="label">
                Subtotal
              </td>
              <td class="value">
                {{ priceFormatFancy($invoice->subtotal) }}
              </td>
            </tr>
            
            <tr>
              <td>&nbsp;</td>
              <td class="label">
                @if( $invoice->discount_type == 1 ) PWD @endif
                @if( $invoice->discount_type == 2 ) SC @endif
                Discount
              </td>
              <td class="value">
                @if(round($invoice->discount) == 0)
                  ------
                @else
                  {{ $invoice->discount + 0 }}%
                @endif
              </td>
            </tr>

            <tr class="grand_total">
              <td>&nbsp;</td>
              <td class="label">
                Total
              </td>
              <td class="value">
                <strong>{{ priceFormatFancy($invoice->total) }}</strong>
              </td>
            </tr>

          </table>
        </div>

        <div class="signatories">
          <table>
            <tr>
              <td class="label">Prepared by</td>
              <td class="value">{{ $user->fname }} {{ $user->lname }}</td>
              <td class="label">Customer Signature</td>
              <td class="value">&nbsp;</td>
            </tr>
          </table>
        </div>
      

        <div class="footer">
          <img src="/images/invoice_footer.png" alt="" />
        </div>

        <hr />

      <!-- one copy -->

      <!-- one copy -->
        <div class="text-right">
          CUSTOMER COPY   
        </div>
        <h2>Billing Form</h2>

        <div class="basic_invoice_info row">
          <div class="col-md-9">
            <table>
              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>Name</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->fname }} {{ $invoice->client->lname }}

                      @if($invoice->is_up && $invoice->is_up == 1)
                        <em>(UP)</em>
                      @endif
                  </td>
                </tr>
              @endif

              @if($invoice->company->id)
                <tr>
                  <td class="label">
                    <strong>Company</strong>
                  </td>
                  <td class="value">
                    @if($invoice->company->id != 1)
                        {{ $invoice->company->name }}
                    @else 
                      <em class="info_na">N/A</em>
                    @endif
                  </td>
                </tr>
              @endif

              @if($invoice->project->is_categorized == 1)
                <tr>
                  <td class="label">
                    <strong>Project</strong>
                  </td>
                  <td class="value">
                    {{ $invoice->project->name }}
                  </td>
                </tr>
              @endif

              @if ($invoice->client->address)
                <tr>
                  <td class="label">
                    <strong>Address</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->address }} 
                  </td>
                </tr>
              @endif


              @if ($invoice->client->number)
                <tr>
                  <td class="label">
                    <strong>Contact</strong>
                  </td>
                  <td class="value">
                      {{ $invoice->client->number }} 
                  </td>
                </tr>
              @endif
            </table>
          </div>

          <div class="col-md-3">


            <table>
              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>FORM No</strong>
                  </td>
                  <td class="value">
                    {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                  </td>
                </tr>
              @endif

              @if ($invoice->client->fname)
                <tr>
                  <td class="label">
                    <strong>Issue Date</strong>
                  </td>
                  <td class="value">
                    {{ dateTimeFormat($invoice->created_at) }}
                  </td>
                </tr>
              @endif

              @if($invoice->due_date)
                <tr>
                  <td class="label">
                    <strong>Due Date</strong>
                  </td>
                  <td class="value">
                    {{ dateShortOnly($invoice->due_date) }}
                  </td>
                </tr>
              @endif

            </table>
          </div> 
        </div>

        <div class="invoice_items_table">
          <table class="w-100">
            <thead>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th class="quantity">Qty</th>
                <th>Unit</th>
                <th class="price">Price</th>
                <th class="amount">Amount</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $k => $item)
                <tr class="itemrow">
                  <td class="id"> 
                    {{ $k + 1 }}
                  </td> 
                  <td class="services"> 
                    {{ $item["services_name"] }}
                    @if($item["notes"] != '')
                      <span class="notes">
                        @if (strlen($item["notes"]) >= 50) 
                          {{ shortenText($item["notes"], 50) }}
                        @else
                          {{ $item["notes"] }}
                        @endif
                      </span>
                    @endif
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

        <div class="totals_section">
          <table class="totals_form_group">
            <tr>
              <td>&nbsp;</td>
              <td class="label">
                Subtotal
              </td>
              <td class="value">
                {{ priceFormatFancy($invoice->subtotal) }}
              </td>
            </tr>
            
            <tr>
              <td>&nbsp;</td>
              <td class="label">
                @if( $invoice->discount_type == 1 ) PWD @endif
                @if( $invoice->discount_type == 2 ) SC @endif
                Discount
              </td>
              <td class="value">
                @if(round($invoice->discount) == 0)
                  ------
                @else
                  {{ $invoice->discount + 0 }}%
                @endif
              </td>
            </tr>

            <tr class="grand_total">
              <td>&nbsp;</td>
              <td class="label">
                Total
              </td>
              <td class="value">
                <strong>{{ priceFormatFancy($invoice->total) }}</strong>
              </td>
            </tr>

          </table>
        </div>

        <div class="signatories">
          <table>
            <tr>
              <td class="label">Prepared by</td>
              <td class="value">{{ $user->fname }} {{ $user->lname }}</td>
              <td class="label">Customer Signature</td>
              <td class="value">&nbsp;</td>
            </tr>
          </table>
        </div>
      

        <div class="footer">
          <img src="/images/invoice_footer.png" alt="" />
        </div>

      <!-- one copy -->

    </div>

  </div>
</div>



@stop


@push('modals')
@endpush


@push('scripts')


<script type="text/javascript">

  $(document).ready(function(){

  


  }); //Document Ready end
</script>

@endpush
