@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <a type="button" href="{{route('payment_r.create')}}" class="btn btn-block bg-gradient-success">Add New Item</a>
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
                <th >Description</th>
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
      "ajax": "{{ route('payment_r.index') }}",
      "columns": [
          { "data": "id" },
          { "data": "name" },
          { "data": "description"} ,
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
   url:"payment_r/destroy/"+user_id,
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