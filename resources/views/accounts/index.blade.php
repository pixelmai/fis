@extends('layouts.app')

@section('content')

<div class="container">

  <form action="/account" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PATCH')

    <div class="row">
      <div class="col-8 offset-2">

        <div class="row">
          <h1>Edit Profile</h1>
        </div>

        <div class="form-group row">
          <label for="number" class="col-md-4 col-form-label">Title</label>

        
            <input id="number" 
              type="text" 
              class="form-control @error('number') is-invalid @enderror" 
              name="number" 
              value="{{ old('number') ?? $user->profile->number }}" required 
              autocomplete="number" autofocus>

            @error('number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
       
        </div>



        <div class="row pt-4">
          <button class="btn btn-primary">Add New Post</button>

      </div>

    </div>


  </form>
</div>



@endsection




