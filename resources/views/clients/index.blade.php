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


        <table id="clients_datatable" class="table table-responsive-md">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Email</th>
              <th scope="col">Contact</th>
              <th scope="col">Company</th>
              <th scope="col">Position</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
        
        </table>

    </div>
  </div>
</div>

@stop



@push('scripts')
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
   <script>
   $(document).ready( function () {
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
 
  $('#clients_datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
          url: "{{ route('clients.index') }}",
          type: 'GET',
         },
         columns: [
                  { data: 'id', name: 'id', 'visible': false},
                  { data: 'fname', name: 'fname' },
                  { data: 'lname', name: 'lname' },
                  { data: 'email', name: 'email' },
                  { data: 'number', name: 'number' },
                  { data: 'company_id', name: 'company_id' },
                  { data: 'position', name: 'position' },
                  {data: 'action', name: 'action', orderable: false},
               ],
        order: [[0, 'desc']]
  });
     });
  </script>
@endpush



