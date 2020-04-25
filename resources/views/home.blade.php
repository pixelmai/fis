@extends('layouts.app')

@section('content')


<div id="dashboard" class="pt-2 px-2">

  <div class="row pb-3">
    <div class="col-lg-12">
      <h1 class="pt-1 pb-0">Welcome, <strong>{{ $user->fname }}</strong>!</h1>
    </div>
  </div>

  <!-- Basic STATS -->
    <div class="row">
      <div class="col-md-3">
        <div class="green stats card">
          <p>Sales this week</p>
          <div class="stat"><strong>P{{ $wsales }}</strong></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="blue stats card">
           <p>Sales this month</p>
          <div class="stat"><strong>P{{ $msales }}</strong></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="orange stats card">
          <p>Transactions this week</p>
          <div class="stat d-flex align-items-center"><strong>{{ $winvoices }}</strong> <span>Invoices</span></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="purple stats card">
          <p>active this week</p>
          <div class="stat d-flex align-items-center"><strong>{{ $wclients }}</strong> <span>Clients</span></div>
        </div>
      </div>

    </div>
  <!-- Basic STATS -->

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <h5>Latest Invoices</h5>

        <table>
          <thead>
            <th>ID</th>
            <th>Client Name</th>
            <th>Jobs</th>
            <th>Date</th>
            <th class="price">Total</th>
          </thead>
          <tbody>
            @foreach($lastinvoices as $invoice)
              <tr>
                <td>
                  <a href="/invoices/view/{{ $invoice->id }}">
                    {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                  </a>
                </td>
                <td>
                  <a href="/clients/view/{{ $invoice->client->id }}">
                    {{ $invoice->client->fname }} {{ $invoice->client->lname }} 
                  </a>
                  @if($invoice->is_up) (UP) @endif
                </td>
                <td>{{ $invoice->jobs }}</td>
                <td>{{ dateShortOnly($invoice->created_at) }}</td>
                <td>{{ priceFormatFancy($invoice->total) }}</td>
              </tr>
            @endforeach

          </tbody>
        </table>
        
        <a href="/invoices" class="view_all">View All Invoices</a>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <h5>Recently Updated Projects</h5>

        <table>
          <thead>
            <th>Status</th>
            <th>Project Name</th>
            <th>Owner</th>
            <th>Updated on</th>
          </thead>
          <tbody>
            @foreach($lastprojects as $project)
              <tr>
                <td>
                  <span class="status status_{{ strtolower($sprojects[$project->status]) }}">{{ $sprojects[$project->status] }}</span>
                </td>
                <td>
                  <a href="/projects/view/{{ $project->id }}">{{ $project->name }}</a>
                </td>
                <td><a href="/clients/view/{{ $project->client->id }}">{{ $project->client->fname }} {{ $project->client->lname }}</a></td>
                <td>{{ dateShortOnly($project->updated_at) }}</td>
              </tr>
            @endforeach

          </tbody>
        </table>
        <a href="/projects" class="view_all">View All Projects</a>
      </div>
    </div>


  </div>


</div>



@endsection
