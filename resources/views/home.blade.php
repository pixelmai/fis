@extends('layouts.app')

  
@section('content')
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="bh">Dashboard</div>
        </div>

        <div class="card-body">
          <p>Welcome to FABLAB WIS, {{ $user->fname }}!</p>

          <h4>Current Development Links</h4>
          <ul>
            <li><a href="">Sectors</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
