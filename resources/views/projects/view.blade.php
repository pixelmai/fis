@extends('layouts.app')
@section('content')

<div class="container pt-3">

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div class="sh">View Project</div>
          </div>
        </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between">
                  <div>
                    <h1>{{ $project->name }}</h1>

                    <div class="chip mb-2">
                      {{ $s }}
                    </div>
      
                  </div>
                  <div>
                    <a href="/projects/edit/{{ $project->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-lg">
                      <i class="fas fa-edit"></i>
                    </a>

                    <a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn btn-outline-danger btn-lg"><i class="fas fa-trash"></i></a>

                  </div>
                </div>
              

                <hr />

                <div class="info-block pt-1">

                <h3>Project Information</h3>

                <div class="info-item">
                  <strong>Owner</strong>
                  <a href="/clients/view/{{ $project->client->id }}">
                    {{ $project->client->fname }} {{ $project->client->lname }}
                  </a>
                </div>


                <div class="info-item">
                  <strong>Project Status</strong>
                  {{ $s }}
                </div>
        


                @if ($project->url)
                <div class="info-item">
                  <strong>Portfolio URL</strong>
                  <a href="{{ $project->url }}">{{ $project->url }}</a>
                </div>
                @endif


                @if ($project->description)
                <div class="info-item">
                  <strong>Description</strong>
                  {{ $project->description }}
                </div>
                @endif



                <hr class="dotted" />

                <h3>Jobs (Invoices)</h3>

    
                <div class="info-item">
                  <strong>Soon...</strong>

                </div>
              

                  <div class="updatedby text-right">
                    Last updated by
                    <b>
                      <a href="/team/profile/{{ $updater->id }}">
                        {{ $updater->fname }}
                        {{ $updater->lname }}
                      </a>
                    </b>
                    on
                    {{ dateOnly($project->updated_at) }}
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
        var row_id = $(this).data("id");

        if (confirm('Are you sure want to delete row?')) {

          $.ajax({
              type: "get",
              url: "/projects/destroy/"+'{{ $project->id }}',
              success: function (data) {

                if(data == 'deleted_no'){
                  var notifData = {
                    status: 'danger',
                    message: 'Cannot delete a contact person of a company',
                  };
                  generateNotif(notifData);

                }else{
                  window.location.href = '{{ url('/projects') }}';
                }
              
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
