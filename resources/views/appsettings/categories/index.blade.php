@extends('layouts.app')
@section('content')

<div class="container pt-5">

  @include('layouts.appsettings_tab')

  <div class="row justify-content-center">

    <div class="col-lg-8">
      <div class="card card-table">
        <div class="card-header">
          <div class="pt-2">
            <div class="bh">Information</div>
          </div>
        </div>

        <div class="card-body">
          <h4><a href="/categories/sectors">Sectors</a></h4>
          <p>
            Used in the <strong>FABLAB UP Cebu Prototypes Developed Update Report</strong> for DTI. Sector categories includes labels such as Creative / Furniture / GDH / Wearables / Food / etc.
          </p>

          <h4><a href="/categories/partners">Partners</a></h4>
          <p>
            Used to categorize <strong>companies and institutions</strong> that have partnerships with FABLAB. Types are: GOV, NGO, COMMERCIAL
          </p>

        </div>

      </div>
    </div>
  </div>
</div>



@endsection




