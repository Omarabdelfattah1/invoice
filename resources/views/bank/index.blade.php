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
                <th>Date</th>
                <th>Bank Name</th>
                <th>Amount</th>
                <th>Exchange Rate</th>
                <th>Exchange Amount</th>
                <th>Local Amount</th>
                <th>Currency</th>
                <th>Comment</th>
                <th>Image</th>
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
          { "data": "update_date" },
          { "data": "amount" },
          { "data": "exchange_rate" },
          { "data": "exchange_amount" },
          { "data": "local_amount" },
          { "data": "currency_id" },
          { "data": "comment" },
          { "data": "image" },
          { "data": "action",
          "orderable":false },
      ]
    });
} );



</script>
@endsection
@endsection