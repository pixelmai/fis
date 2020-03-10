@extends('layouts.app')
@section('content')

<div class="container pt-5">
  <div class="row settings_tab justify-content-center">
    <div class="col-lg-8">
      <div class="d-lg-flex justify-content-between">
        <div class="sh">Data Categories</div>
        <div>
          @include('layouts.appsettings_tab')
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">

    <div class="col-lg-8">
      <div class="card card-table">
        <div class="card-header">
          <div class="pt-1 d-flex justify-content-between">
            <div class="bh">Sectors</div>
            <div class="pt-2"><a href="/categories/sectors/create" class="btn btn-lg btn-success">Add Sector</a></div>
          </div>
        </div>

        <div class="card-body">

          <table class="table table-responsive-md">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cat_types as $cat_type)
                <tr @if($cat_type->is_active==FALSE) class="deactivated" @endif>
                  <td>
                    {{ $cat_type->name }}
                  </td>
                  <td>
                    {{ $cat_type->description }}
                  </td>
                  <td class="icon_menu text-right">
                    <a href="/categories/edit/{{ $cat_type->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>

                    @if ($cat_type->is_active)
                      <a href="/categories/deactivate/{{ $cat_type->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Deactivate">
                        <i class="fas fa-ban"></i>
                      </a>
                    @else
                      <a href="/categories/activate/{{ $cat_type->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Activate">
                        <i class="fas fa-check"></i>
                      </a>
                    @endif

                  </td>
                </tr>
              @endforeach
              </table>

        </div>

      </div>
    </div>
  </div>
</div>



@endsection




