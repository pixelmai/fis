@extends('layouts.app')


@section('content')
       
<h2>Laravel DataTable - Tuts Make</h2>
  <table class="table table-bordered" id="laravel_datatable">
  <thead>
  <tr>
     <th>Id</th>
     <th>Name</th>
     <th>Email</th>
     <th>Created at</th>
  </tr>
  </thead>
  </table>

@stop



@push('scripts')
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
   <script>
   $(document).ready( function () {
    $('#laravel_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('dbase-list') }}",
           columns: [
                    { data: 'id', name: 'id', render:function(data, type, row){
    return "<a href='/users/"+ row.id +"'>" + row.fname + "</a>"
}},
                    { data: 'lname', name: 'lname' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' }
                 ]
        });
     });
  </script>
@endpush



