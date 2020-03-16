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
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Email</th>
              <th scope="col">Contact #</th>
              <th scope="col">Company</th>
              <th scope="col">Position</th>
              <th scope="col">&nbsp;</th>
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
    $('#clients_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('clients/list') }}",
           columns: [
                    { data: 'fname', name: 'fname' },
                    { data: 'lname', name: 'lname' },
                    { data: 'email', name: 'email' },
                    { data: 'number', name: 'number' },
                    { data: 'company_id', name: 'company_id' },
                    { data: 'position', name: 'position' },

                    { data: 'id', name: 'id', render:function(data, type, row){
    return "<a class='btn btn-sm btn-outline-secondary' href='/clients/view"+ row.id +"'>View</a>"
}},
                 ]
        });
     });
  </script>
@endpush



