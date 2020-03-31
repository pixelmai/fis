@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">Company</div>
          </div>
        </div>

        <div class="card-body">

          <div class="row">
            <div class="col-md-12">
              <div class="d-flex justify-content-between">
                <div>
                  <h1>{{ $company->name }}</h1>

                  @if ($company->partner->id != 1)
                    <div class="chip mb-2">
                      {{ $company->partner->name }}
                    </div>
                  @endif


                </div>
                <div>
                  <a href="/companies/edit/{{ $company->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                    <i class="fas fa-edit"></i>
                  </a>

                  <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>

                </div>


              </div>

              @if (count($employees) <= 1 )
                <hr class="mb-0"> 
              @endif
            </div>
          </div>
        </div>
              

        @if (count($employees) > 1)
          <ul class="nav nav-tabs card-tabs" id="myTab" role="tablist">

            <li class="nav-item ml-3">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information</a>
            </li>

            
              <li class="nav-item">
                <a class="nav-link" id="employees-tab" data-toggle="tab" href="#employees" role="tab" aria-controls="employees" aria-selected="false">Employees</a>
              </li>
           
          </ul>
        @endif


        <div class="card-body @if(count($employees) <= 1) pt-0 @endif">

          <div class="row">
            <div class="col-md-12">

                <div class="tab-content" id="myTabContent">
                  <!-- TAB CONTENT -->
                    
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                      <div class="info-block pt-1">

                        <h5>Company Information</h5>

                        <div class="info-item">
                          <strong>Contact Person</strong>
                          <a href="/clients/view/{{ $company->contactperson->id }}">
                            {{ $company->contactperson->fname }} {{ $company->contactperson->lname }}
                          </a>
                        </div>


                        @if ($company->partner->id != 1)
                          <div class="info-item">
                            <strong>Partner Type</strong>
                            {{ $company->partner->name }}
                          </div>
                        @endif


                        @if ($company->email)
                        <div class="info-item">
                          <strong>Email Address</strong>
                          {{ $company->email }}
                        </div>
                        @endif

                        @if ($company->number)
                        <div class="info-item">
                          <strong>Contact Number</strong>
                          {{ $company->number }}
                        </div>
                        @endif

                        @if ($company->url)
                        <div class="info-item">
                          <strong>URL</strong>
                          <a href="{{ $company->url }}">{{ $company->url }}</a>
                        </div>
                        @endif


                        @if ($company->address)
                        <div class="info-item">
                          <strong>Address</strong>
                          {{ $company->address }}
                        </div>
                        @endif


                        @if ($company->description)
                        <div class="info-item">
                          <strong>Description</strong>
                          {{ $company->description }}
                        </div>
                        @endif

                      </div>
                    </div>
                  <!-- TAB CONTENT -->

                  <!-- TAB CONTENT -->
                    <div class="tab-pane fade" id="employees" role="tabpanel" aria-labelledby="employees-tab">

                      <div class="info-block pt-1">
                        <h5>Employees</h5>

                        <ul class="tab-content-list">
                        @foreach($employees as $employee)
                          <li>
                            <a href="/clients/view/{{ $employee['id'] }}">
                             {{ $employee['fname'] }} {{ $employee['lname'] }} 
                            </a>
                          </li>

                        @endforeach
                        </ul>

                    </div>
                  <!-- TAB CONTENT -->
                </div>

                  


                <div class="info-block pt-1">
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
                    {{ dateOnly($company->updated_at) }}
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



@push('scripts')

  <script>
    $(document).ready( function () {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      $('body').on('click', '#delete-row', function () {
        

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/companies/destroy/"+ {{ $company->id }},
              success: function (data) {
                console.log(data);
                window.location.href = '{{ url('/companies') }}';
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
