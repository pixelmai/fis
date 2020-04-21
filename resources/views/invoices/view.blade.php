@extends('layouts.app')
@section('content')

<div class="container">
  <div id="invoice_heading" class="d-flex justify-content-between align-self-center">
    <h1>Invoice Details</h1>

    <div id="invoice_id" class="col-md-4">
      <span>ID #</span> {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
    </div>

  </div>

  <div id="view_invoice" class="row justify-content-center">
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
          <div id="basic_invoice_info" class="row">
            <div class="col-md-9">

              <div class="info-block row">

                
               @if ($invoice->client->fname)
               <div class="col-md-12">
                  <div class="info-item ">
                    <strong>Client</strong>
                    <a href="/clients/view/{{ $invoice->client->id }}" class="d-flex align-items-center">
                      <span>{{ $invoice->client->fname }} {{ $invoice->client->lname }}</span>

                      @if($invoice->is_up && $invoice->is_up == 1)
                        <span id="up_candy"></span>
                      @endif

                    </a>



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
                    </td> 
                    <td class="machines"> 

                      @if($item["machines_name"])
                        {{ $item["machines_name"] }}
                      @else
                        <em class="info_na">N/A</em>
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
   
                  <tr class="descrow"> 
                    <td class="notes" colspan="5"> 
                      {{ $item["notes"] }}
                    </td> 
                    <td class="amount">&nbsp;</td>
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

      </div>
    </div>
  </div>
</div>



@stop


@push('modals')
  @include('invoices.modalSetStatus')
@endpush


@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>


<script type="text/javascript">

  $(document).ready(function(){

      $('body').on('click', '#delete-row', function () {
        

        if (confirm('Are you sure want to delete invoice?')) {

          $.ajax({
              type: "get",
              url: "/invoices/destroy/"+ {{ $invoice->id }},
              success: function (data) {
                console.log(data);
                window.location.href = '{{ url('/invoices') }}';
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   



      $('body').on('click', '#add-log-row', function () {
        $('#ajaxForm #invoice_id').val({{ $invoice->id }});
        $('#ajax-crud-modal').trigger("reset");
        $('#ajax-crud-modal').modal('show');
        $('#btn-edit-status').addClass('d-none');
        $('#btn-multiple-save-status').addClass('d-none');
        $('#btn-single-save-status').removeClass('d-none');
      });   

    
      $('body').on('click', '#btn-single-save-status', function () {
        initvalidator("{{ $invoice->id }}");
      });   


      function initvalidator(ids){
        var validator = $("#ajaxForm").validate({
          errorPlacement: function(error, element) {
            // Append error within linked label
            $( element )
              .closest( "form" )
                .find( "label[for='" + element.attr( "id" ) + "']" )
                  .append( error );
          },
          errorElement: "span",
          rules: {
            status: {
              required: true
            }
          },
          messages: {
            status: " (required)",
          },
          submitHandler: function(form) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

        
            var formData = {
              status: $('#status').children("option:selected").val(),
              updatedby_id: $('#updatedby_id').val(),
            };

            var state = jQuery('#btn-save').val();
            var type = "POST";

            $.ajax({
                type: type,
                url: "/invoices/status",
                data: { "formData" : formData, "id": ids } ,
                dataType: 'json',
                success: function (data) {
                  $('#ajax-crud-modal').trigger("reset");
                  $('#ajax-crud-modal').modal('hide');

                  var notifData = {
                    status: 'success',
                    message: 'Successfully updated status of the selected ' + data + ' invoice.',
                  };

                  generateNotif(notifData);

              
                  window.location.href = '{{ url( '/invoices/view/'.$invoice->id ) }}';
                },
                error: function (data) {
                  console.log('Error:', data);
                }
            });

          },
        });

      }


  }); //Document Ready end
</script>

@endpush
