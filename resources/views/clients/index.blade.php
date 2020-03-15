@extends('layouts.app')
@section('content')

<div class="pt-4 px-2">

  <div class="row pb-3">
    <div class="col-lg-12 d-flex justify-content-between">
      <div>
        <h1 class="pt-1 pb-0">Clients</h1>
      </div>
      <div>
        <a href="clients/create" class="btn btn-lg btn-success">Add Client</a>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card card-table">
   
          <table class="table table-responsive-md">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact #</th>
                <th scope="col">Company</th>
                <th scope="col">Position</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clients as $client)
                <tr>
                  <td>
                    <a href="team/profile/{{ $client->id }}" class="name">
                      {{ $client->fname }} {{ $client->lname }}
                    </a>
          
                  </td>
                  <td>{{ $client->email ?? 'Not Set' }}</td>
                  <td>{{ $client->number ?? 'Not Set' }}</td>
                  <td>{{ $client->company_id ?? 'Not Set' }}</td>
                  <td>{{ $client->position ?? 'Not Set' }}</td>
                  <td class="text-right">

                    <a href="team/profile/{{ $client->id }}" class="btn btn-sm btn-outline-secondary">View</a>

                  
                  </td>

                </tr>
              @endforeach
            </tbody>
          </table>

      </div>

      <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
          {{ $clients->links() }}
        </div>
      </div>

    </div>
  </div>








    



</div>



@endsection




