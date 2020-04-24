@extends('layouts.app')
@section('content')

<div id="view_clients" class="container">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="sh">Client Profile</div>
    </div>
  </div>

  <div id="card_area" class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card">
        <div id="markers" class="d-flex justify-content-between align-items-center">
          <div>
            <h1>{{ $client->fname }} {{ $client->lname }}</h1>
              <div class="chip mb-2">
                {{ $client->sector->name }}
              </div>

              @if ($client->is_freelancer == 1)
                <div class="chip mb-2 chip-freelancer">
                  Freelancer
                </div>
              @endif


              @if ($client->is_pwd == 1)
                <div class="chip mb-2 chip-pwd">
                  PWD
                </div>
              @endif

          </div>

          <div>

          <a href="/clients/edit/{{ $client->id }}" class="edit btn btn-outline-secondary btn-md">
            <i class="fas fa-edit"></i>
            Edit
          </a>

          @if($sum == 0)
            <a href="javascript:void(0);" id="delete-row" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-md"><i class="fas fa-trash"></i> Delete</a>
          @else
            @if($client->is_deactivated == 0)
              <a href="javascript:void(0);" id="deactivate-row" data-id="{{ $client->id }}" class="delete btn btn-outline-danger btn-md"><i class="fas fa-ban"></i> Deactivate</a>
            @else
              <a href="javascript:void(0);" id="activate-row" data-id="{{ $client->id }}" class="delete btn btn-outline-success btn-md"><i class="fas fa-check"></i> Activate</a>
            @endif
          @endif
          </div>
  
        </div>

          @if ($sum == 0 )
            <hr id="after_marker"> 
          @else
            <ul class="nav nav-tabs card-tabs" id="tab_menu" role="tablist">

              <li class="nav-item first_item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information</a>
              </li>

              @if(count($projects) != 0)
                <li class="nav-item">
                  <a class="nav-link" id="projects-tab" data-toggle="tab" href="#projects_tab" role="tab" aria-controls="projects_tab" aria-selected="false">Projects</a>
                </li>
              @endif
           
              @if(count($client->invoices) != 0)
                <li class="nav-item">
                  <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices_tab" role="tab" aria-controls="invoices_tab" aria-selected="false">Invoices</a>
                </li>
              @endif

            </ul>
          @endif


        <div class="card-body @if($sum != 0) pt-4 @endif">

<div class="tab-content" id="myTabContent">
  <!-- TAB CONTENT -->
    
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

      <div id="basic_invoice_info">
        <div class="info-block">

            @if ($client->email || $client->number || $client->url || $client->address)
              <h5 class="pb-3">Contact Information</h5>
            @endif

            @if ($client->email)
            <div class="info-item">
              <strong>Email Address</strong>
              {{ $client->email }}
            </div>
            @endif

            @if ($client->number)
            <div class="info-item">
              <strong>Contact Number</strong>
              {{ $client->number }}
            </div>
            @endif

            @if ($client->url)
            <div class="info-item">
              <strong>Portfolio URL</strong>
              <a href="{{ $client->url }}">{{ $client->url }}</a>
            </div>
            @endif


            @if ($client->address)
            <div class="info-item">
              <strong>Address</strong>
              {{ $client->address }}
            </div>

            @endif


            @if ($client->email || $client->number || $client->url || $client->address)
              <hr class="dotted" />
            @endif



            <div class="row">
              <div class="col-lg-6">
                <h5>Professional Info</h5>

                @if ($client->company_id && $client->company_id != 1)
                  <div class="info-item">
                    <strong>Company/Institution</strong>
                    <a href="/companies/view/{{ $client->company_id }}">{{ $client->company->name }}</a>
                  </div>
                @endif

                @if ($client->position)
                  <div class="info-item">
                    <strong>Position</strong>
                    {{ $client->position }}
                  </div>
                @endif

                <div class="info-item">
                  <strong>Sector</strong>
                  {{ $client->sector->name }}
                </div>

                <div class="info-item">
                  <strong>Registration Type</strong>
                  {{ $client->regtype->name }}
                </div>

                @if ($client->is_food == 1)
                  <div class="info-item">
                    <strong>Food Business</strong>
                    Yes
                  </div>
                @endif

                @if ($client->is_freelancer == 1)
                  <div class="info-item">
                    <strong>Freelancer</strong>
                    Yes
                  </div>
                @endif

              </div>

              <div class="col-lg-6">

               <h5>Personal Info</h5>

                  @if ($client->gender)
                    <div class="info-item">
                      <strong>Sex</strong>

                      {{ $client->gender === "m" ? "Male" : "Female" }}

                    </div>
                  @endif

                  @if ($client->date_of_birth)
                    <div class="info-item">
                      <strong>Date of Birth</strong>
                      {{ dateOnly($client->date_of_birth) }}
                    </div>
                  @endif

                  @if ($client->is_pwd == 1)
                    <div class="info-item">
                      <strong>PWD</strong>
                      Yes
                    </div>
                  @endif


                  @if ($client->skillset)
                    <div class="info-item">
                      <strong>Skillset</strong>
                      {{ $client->skillset }}
                    </div>
                  @endif

                  @if ($client->hobbies)
                    <div class="info-item">
                      <strong>Hobbies</strong>
                      {{ $client->hobbies }}
                    </div>
                  @endif


              </div>


            </div>



            <hr class="dotted" />





              <div class="updatedby text-right">
                Last updated by
                <b>
                  <a href="/team/profile/{{ $updater->id }}">
                    {{ $updater->fname }}
                    {{ $updater->lname }}
                  </a>
                </b>
                on
                {{ dateOnly($client->updated_at) }}
              </div>

        </div>
      </div>
    </div>
  <!-- TAB CONTENT -->

  @if(count($projects) != 0)
    <!-- TAB CONTENT -->
      
      <div class="tab-pane fade" id="projects_tab" role="tabpanel" aria-labelledby="projects-tab">

        <div class="d-flex justify-content-between pb-3">
         
          <h5>Projects</h5>
          <div>
            <a href="/projects/create" class="btn btn-sm btn-outline-success">New Project</a>
          </div>

        </div>


        <div id="results_list">
          @foreach($projects as $project)
        
              <div class="result_item d-flex justify-content-between">
                <div class="info_details">
                  <a href="/projects/view/{{ $project->id }}" class="name">
                    {{ strlen($project->name) >= 50 ? shortenText($project->name, 50) : $project->name }}
                  </a>

                  <div class="dates">
                    <strong>Created</strong> {{ dateShortOnly($project->created_at) }}
                    <span> | </span>
                    <strong>Updated</strong> {{ dateShortOnly($project->updated_at) }}
                  </div>

                  @if($project->url)
                    <div class="url">
                      <strong>URL</strong> 
                      <a href="{{ $project->url }}" target="blank">
                        {{ strlen($project->url) >= 70 ? shortenText($project->url, 70) : $project->url }}
                      </a>
                    </div>
                  @endif
                </div>
                <div class="status_count text-right">
                  @if($pstatus)
                    <div class="status status_{{ strtolower($pstatus[$project->status]) }}">
                      {{ $pstatus[$project->status] }}
                    </div>
                  @endif

                  <div class="invoice_count">
                    <span>{{ count($project->invoices) }}</span>
                    {{ count($project->invoices) == 1 ? "invoice" : "invoices" }}
                  </div>
                </div>
              </div>
        
          @endforeach
        </div>

      </div>
    <!-- TAB CONTENT -->
  @endif


  @if(count($invoices) != 0)
    <!-- TAB CONTENT -->
      
      <div class="tab-pane fade" id="invoices_tab" role="tabpanel" aria-labelledby="invoices-tab">

        <div class="d-flex justify-content-between pb-3">
         
          <h5>Invoices</h5>
          <div>
            <a href="/invoices/create" class="btn btn-sm btn-outline-success">New Invoice</a>
          </div>

        </div>


        <div id="results_list">
          @foreach($invoices as $invoice)
        
              <div class="result_item d-flex justify-content-between">
                <div class="info_details">
                  <a href="/invoices/view/{{ $invoice->id }}" class="name">
                    Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                  </a>

                  <div class="dates">
                    <strong>Created</strong> {{ dateShortOnly($invoice->created_at) }}
                    @if($invoice->due_date != '')
                      <span> | </span>
                      <strong>Due Date</strong> {{ dateShortOnly($invoice->due_date) }}
                    @endif
                  </div>

                  @if($invoice->project->is_categorized == 1)
                    <div class="client_project">
                      <strong>Project</strong> 

                      <a href="/invoices/view/{{ $invoice->project->id }}">
                        {{ strlen($invoice->project->name) >= 50 ? shortenText($invoice->project->name, 50) : $invoice->project->name }}
                      </a>
                    </div>
                  @endif
                </div>
                <div class="status_count text-right">
                  @if($istatus)
                    <div class="status status_{{ strtolower($istatus[$invoice->status]) }}">
                      {{ $istatus[$invoice->status] }}
                    </div>
                  @endif

                  <div class="total">
                    {{ priceFormatFancy($invoice->total) }}
                  </div>
                </div>
              </div>
        
          @endforeach
        </div>

      </div>
    <!-- TAB CONTENT -->
  @endif

</div>
        </div>


      </div>
    </div>
  </div>
</div>


       


@stop



@push('scripts')

  <script>
    $(document).ready( function () {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('body').on('click', '#delete-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/clients/destroy/"+'{{ $client->id }}',
              success: function (data) {

                if(data == 'deleted_no'){
                  var notifData = {
                    status: 'danger',
                    message: 'Cannot delete a contact person of a company',
                  };
                  generateNotif(notifData);

                }else{
                  window.location.href = '{{ url('/clients') }}';
                }
              
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   


      $('body').on('click', '#deactivate-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to deactivate row?')) {

          $.ajax({
              type: "get",
              url: "/clients/deactivate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/clients') }}';


                var notifData = {
                  status: 'warning',
                  message: 'Successfully deactivated a client.',
                };

                generateNotif(notifData);

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });   

      $('body').on('click', '#activate-row', function () {
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to activate row?')) {

          $.ajax({
              type: "get",
              url: "/clients/activate/"+row_id,
              success: function (data) {
                window.location.href = '{{ url('/clients') }}';
                
                var notifData = {
                  status: 'success',
                  message: 'Successfully activated a client.',
                };

                generateNotif(notifData);

              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        } 
      });  

    

    }); //end document ready




  </script>
@endpush
