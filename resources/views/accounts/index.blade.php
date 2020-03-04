@extends('layouts.app')

@section('content')

<div class="container">

  <form action="/account/update" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PATCH')

    <div class="row">
      <div class="col-8 offset-2">

        <div class="row">
          <h1>Edit Profile</h1>
        </div>

        <div class="form-group row">
          <label for="fname" class="col-md-4 col-form-label">First Name</label>


        
            <input id="fname" 
              type="text" 
              class="form-control @error('fname') is-invalid @enderror" 
              name="fname" 
              value="{{ old('fname') ?? $user->fname }}" required 
              autocomplete="fname" autofocus>

            @error('fname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group row">
          <label for="lname" class="col-md-4 col-form-label">Last Name</label>
        
            <input id="lname" 
              type="text" 
              class="form-control @error('lname') is-invalid @enderror" 
              name="lname" 
              value="{{ old('lname') ?? $user->lname }}" required 
              autocomplete="lname" autofocus>

            @error('lname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>



        <div class="form-group row">
          <label for="number" class="col-md-4 col-form-label">Contact Number</label>

        
            <input id="number" 
              type="text" 
              class="form-control @error('number') is-invalid @enderror" 
              name="number" 
              value="{{ old('number') ?? $user->number }}" required 
              autocomplete="number" autofocus>

            @error('number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group row">
          <label for="number" class="col-md-4 col-form-label">Address</label>

        
            <input id="address" 
              type="text" 
              class="form-control @error('address') is-invalid @enderror" 
              name="address" 
              value="{{ old('address') ?? $user->address }}" required 
              autocomplete="address" autofocus>

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group row">
          <label for="number" class="col-md-4 col-form-label">Position</label>

        
            <input id="position" 
              type="text" 
              class="form-control @error('position') is-invalid @enderror" 
              name="position" 
              value="{{ old('position') ?? $user->position }}" required 
              autocomplete="position" autofocus>

            @error('position')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group row">
          <label for="number" class="col-md-4 col-form-label">Skillset</label>

        
            <input id="skillset" 
              type="text" 
              class="form-control @error('skillset') is-invalid @enderror" 
              name="skillset" 
              value="{{ old('skillset') ?? $user->skillset }}" required 
              autocomplete="skillset" autofocus>

            @error('skillset')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="row pt-4">
          <button class="btn btn-primary">Update Profile</button>

      </div>

    </div>


  </form>
</div>



@endsection




