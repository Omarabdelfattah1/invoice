@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <button type="button" data-toggle="modal" data-target="#add_payment" class="btn btn-block bg-gradient-success">Add New Payment</button>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th >Client Inv#</th>
                <th >Payment Date</th>
                <th >Type</th>
                <th >Amount</th>
                <th ></th>
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

<div id="add_payment" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 align="center" style="margin:0;">Which invoice you received payment for?</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-striped dataTable dtr-inline no-footer">
            <thead>
              <tr>
                <th>#</th>
                <th>INV Number</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
          @foreach($invoices as $invoice)          
              <tr>
                <td>
                  <a class="btn btn-primary btn-sm" href="{{route('receivedpayments.create',['invoice_id'=>$invoice->id])}}">Choose</a>
                </td>
                <td>
                  {{$invoice->inv_number}}
                </td>
                <td>
                  {{$invoice->client->name}}
                </td>
                <td>
                  {{$invoice->amount}}
                </td>
                <td>
                  {{$invoice->invoice_date}}
                </td>
              </tr>
          @endforeach
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div>
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
        </div>
        <div class="modal-footer">
        <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js">
</script>


<script>
$(document).ready(function(){
  $('#datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('receivedpayments.index') }}",
      "columns": [
          { "data": "invoice" },
          { "data": "payment_date" },
          { "data": "payment_type" },
          { "data": "amount_paid" },
          { "data": "action",
          "orderable":false },
      ]
    });
} );

 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"receivedpayments/destroy/"+user_id,
   beforeSend:function(){
    $('#ok_button').text('Deleting...');
   },
   success:function(data)
   {
    setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#datatable').DataTable().ajax.reload();
     alert('Data Deleted');
    }, 2000);
   }
  })
 });

</script>

@endsection