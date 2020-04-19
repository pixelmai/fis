@extends('layouts.app')
@section('content')

<div class="container">
  <div id="invoice_heading" class="d-flex justify-content-between align-self-center">
    <h1>Invoice Details</h1>
    <div id="invoice_id" class="col-md-4">
      <span>ID #</span> 
        {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
    </div>
  </div>

  <div id="view_invoice" class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">

          <div id="basic_invoice_info" class="row">
            <div class="col-md-9">

              <div class="info-block row">

                
               @if ($invoice->client->fname)
               <div class="col-md-6">
                  <div class="info-item">

                  <strong>Client</strong>

                    <a href="/clients/view/{{ $invoice->client->id }}">
                      {{ $invoice->client->fname }} {{ $invoice->client->lname }}
                    </a>
                  </div>
                 </div>
                @endif
                

               @if($invoice->is_up)
               <div class="col-md-3">
                  <div class="info-item">

                  @if($invoice->is_up == 1)
                    <strong>UP</strong>
                  @endif
                  &nbsp;
                  
                  </div>
                 </div>
                @endif


               @if($s)
               <div class="col-md-3">
                  <div class="info-item">

                    <strong>Status</strong>

                    {{ $s }}
                  
                  </div>
                </div>
                @endif


              </div> <!-- end row -->


              <div class="info-block row">



                @if($invoice->company->id)
                 <div class="col-md-6">
                    <div class="info-item">
                      <strong>Company/Institution</strong>
                      @if($invoice->company->id != 1)
                        <a href="/companies/view/{{ $invoice->company->id }}">
                          {{ $invoice->company->name }}
                        </a>
                      @else 
                        <em class="info_na">N/A</em>
                      @endif
                    </div>
                  </div>
                @endif



                @if($invoice->project->id)
                 <div class="col-md-6">
                    <div class="info-item">
                      <strong>Project</strong>
                      @if($invoice->project->is_categorized == 1)
                        <a href="/projects/view/{{ $invoice->project->id }}">
                          {{ $invoice->project->name }}
                        </a>
                      @else 
                        <em class="info_na">N/A</em>
                      @endif
                    </div>
                  </div>
                @endif


              </div>

            </div>

            <div class="col-md-3">
              <div class="info-block row">
                @if($invoice->created_at)
                  <div class="info-item">
                    <strong>Created at</strong>
                    {{ dateTimeFormat($invoice->created_at) }}
                   </div>
                @endif
              </div>


              <div class="info-block row">
               
                  <div class="info-item">
                    <strong>Due Date</strong>
                    @if($invoice->due_date)
                      {{ dateShortOnly($invoice->due_date) }}
                    @else
                      <em class="info_na">N/A</em>
                    @endif
                  </div>

              </div>
            </div> 

     
          </div>

          <div id="invoice_items_table">
            <table class="w-100">
              <thead>
                <tr>
                  <th>Service</th>
                  <th>Machine</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Price</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr class="itemrow">
                  <td class="services"> 
                    haha
                  </td> 
                  <td class="machines"> 
                    ahaha
                  </td> 
                  <td class="quantity"> 
                    haha
                  </td> 
                  <td class="unit"> 
                    haha
                  </td> 
                  <td class="price">
                    haha
                   </td> 
                  <td class="amount"> 
                    haha
                  </td> 
                 
                </tr> 

                <tr class="descrow"> 
                  <td class="notes" colspan="5"> 
                  </td> 
                  <td class="amount">&nbsp;</td>

              </tbody>
            </table>

              


              <br /><br /><br /><br /><br /><br />
              <div id="totals_section" class="d-flex align-items-end flex-column">

                <div id="totals_form_group">
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="subtotal" class="col-form-label">Subtotal </label>
                    </div>
                    <div class="col-md-6">
                        <input id="subtotal" 
                          type="text" 
                          class="form-control"
                          name="total" 
                          value="{{ old('subtotal') ?? '0.00' }}"  
                          readonly>

                        @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="discount" class="col-form-label"><span id="discount_type" class="required"></span> Discount %</label>
                    </div>
                    <div class="col-md-6">
                        <input id="discount" 
                          type="text" 
                          class="form-control"
                          name="discount" 
                          value="{{ old('discount') ?? 0 }}" readonly="">

                        @error('discount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                  </div>

                  <div class="form-group row">
                    <div class="col-md-6 flex align-self-center">
                      <label id="label_total" for="total" class="col-form-label">Total </label>
                    </div>
                    <div class="col-md-6">
                        <input id="total" 
                          type="text" 
                          class="form-control"
                          name="total" 
                          value="{{ old('total') ?? '0.00' }}"  
                          readonly>

                        @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                </div>
              </div>



 

        </div>


      </div>
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
