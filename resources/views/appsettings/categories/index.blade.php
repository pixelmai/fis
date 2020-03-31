@extends('layouts.app')
@section('content')

<div class="container pt-3">

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
            Used in the <strong>FABLAB UP Cebu Prototypes Developed Update Report</strong> for DTI. <br>Default types includes:
          </p>

          <ul>
            <li>Creative</li>
            <li>Furniture</li>
            <li>GDH</li>
            <li>Wearables</li>
            <li>Food</li>
          </ul>

          <h4><a href="/categories/partners">Partners</a></h4>
          <p>
            Used to categorize <strong>Partner Companies and Institutions</strong> of FABLAB. <br>Default types are: 
          </p>
          <ul>
            <li>GOV</li>
            <li>NGO</li>
            <li>Commercial</li>
          </ul>

          <h4><a href="/categories/services">Services</a></h4>
          <p>
            Used to categorize the <strong>Services Offered</strong> by FABLAB. <br>Default types are:
          </p>

          <ul>
            <li>Machine Use</li>
            <li>Consultation</li>
            <li>Tour</li>
          </ul>

          <h4><a href="/categories/registrations">Registrations</a></h4>
          <p>
            Classifies the <strong>Registration status</strong> of the clients. <br>Default values are: 
          </p>
          <ul>
            <li>Registered (DTI / SEC / CDA)</li>
            <li>Unregistered</li>
            <li>Potential (Students/Hobbyist))</li>
          </ul>

        </div>

      </div>
    </div>
  </div>
</div>



@endsection




