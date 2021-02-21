@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Item</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{route('payment_items.update',$payment_item)}}" method="post">
          @method('put')
          @csrf

            <div class="card-body">
              <div class="form-group">
                <label for="name">Item Name:</label>
                <input type="text" name="name" class="form-control" id="name" value="{{$payment_item->name}}">
              </div>
              <div class="form-group">
                <label for="description">Item Description:</label>
                <input type="text" name="description" class="form-control" id="description" value="{{$payment_item->description}}">
              </div>
             </div> 
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection