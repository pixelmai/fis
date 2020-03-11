@extends('layouts.app')
@section('content')

<div class="container pt-5">

  @include('layouts.appsettings_tab')

  <div class="row justify-content-center">

    <div class="col-lg-8">
      <div class="card card-table">

        <div class="card-header">
          <div class="pt-2 d-flex justify-content-between">
            <div class="bh">Registrations</div>
            <div class="pt-2"><a href="/categories/registrations/create" class="btn btn-lg btn-success">Add Type</a></div>
          </div>
        </div>

        <div class="card-body">

          <table class="table table-responsive-md">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">MSME</th>
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
                    {{ $cat_type->regmsmes->name }}
                  </td>
                  <td>
                    {{ $cat_type->description }}
                  </td>
                  <td class="icon_menu text-right">
                    <a href="/categories/registrations/edit/{{ $cat_type->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>

                    @if ($cat_type->is_active)
                      <a href="/categories/registrations/deactivate/{{ $cat_type->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Deactivate" onclick="return confirm('Are you sure you want to deactivate this item?');">
                        <i class="fas fa-ban"></i>
                      </a>
                    @else
                      <a href="/categories/registrations/activate/{{ $cat_type->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Activate">
                        <i class="fas fa-check"></i>
                      </a>
                    @endif

                  </td>
                </tr>
              @endforeach
              </table>

        </div>


        <hr>
        <div class="card-header">
          <div class="pt-2 d-flex justify-content-between">
            <div class="bh">MSME</div>
            <div class="pt-2"><a href="/categories/registrations/msmecreate" class="btn btn-lg btn-success">Add MSME</a></div>
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
              @foreach($msme_types as $msme_types)
                <tr @if($msme_types->is_active==FALSE) class="deactivated" @endif>
                  <td>
                    {{ $msme_types->name }}
                  </td>
                  <td>
                    {{ $msme_types->description }}
                  </td>
                  <td class="icon_menu text-right">
                    <a href="/categories/registrations/msmeedit/{{ $msme_types->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>

                    @if ($msme_types->is_active)
                      <a href="/categories/registrations/msmedeactivate/{{ $msme_types->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Deactivate" onclick="return confirm('Are you sure you want to deactivate this item?');">
                        <i class="fas fa-ban"></i>
                      </a>
                    @else
                      <a href="/categories/registrations/msmeactivate/{{ $msme_types->id }}" class="name" data-toggle="tooltip" data-placement="left" title="Activate">
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




