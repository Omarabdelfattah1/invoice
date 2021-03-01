@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection
@section('header','Bank Form')
@section('content')
<div class="card">
  <div class="card-header">
    <a type="button" href="{{route('banks.create')}}" class="btn btn-block bg-gradient-success">Add New Bank</a>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th>Id</th>
                <th>Name</th>
                <th>Date</th>
                <th>Account</th>
                <th>City</th>
                <th>Country</th>
                <th>Address</th>
                <th>Currency</th>
                <th>SOA</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js">
</script>
<script>
$(document).ready( function () {
    $('#datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('banks.index') }}",
      "columns": [
          { "data": "id" },
          { "data": "name" },
          { "data": "date" },
          { "data": "account" },
          { "data": "city" },
          { "data": "country" },
          { "data": "address" },
          { "data": "currency" },
          { "data": "soa" },
          { "data": "action",
          "orderable":false },
      ]
    });
} );



</script>
@endsection
@endsection