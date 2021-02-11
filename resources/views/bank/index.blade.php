@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection
@section('header','Client Form')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">DataTable with default features</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th >#</th>
                <th >Name</th>
                <th >Country</th>
                <th >Address</th>
                <th >Email</th>
                <th >Phone</th>
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
      "ajax": "{{ route('clients.api') }}",
      "columns": [
          { "data": "id" },
          { "data": "name" },
          { "data": "Country" },
          { "data": "address" },
          { "data": "email" },
          { "data": "tel" },
      ]
    });
} );
</script>
@endsection
@endsection