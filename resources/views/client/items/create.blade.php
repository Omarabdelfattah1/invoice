@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add new Item</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
          <form action="{{route('items.store')}}" method="post">
          @csrf

            <div class="card-body">
              <div class="form-group">
                <label for="name">Item Name:</label>
                <input type="text" name="name" class="form-control" id="name">
              </div>
              <div class="form-group">
                <label for="item">Item Description:</label>
                <input type="text" name="description" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="item">Item Rate:</label>
                <input type="text" name="rate" class="form-control" id="email">
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