@extends('layouts.home')
@section('header','Client Form')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add new client</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
          <form action="{{route('clients.store')}}" method="post">
          @csrf

            <div class="card-body">
              <div class="form-group">
                <label for="name">Client Name:</label>
                <input type="text" name="name" class="form-control" id="name">
              </div>
              <div class="form-group">
                <label for="email">Client Email:</label>
                <input type="email" name="email" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="country">Client Country:</label>
                <input type="text" name="country" class="form-control" id="country">
              </div>
              <div class="form-group">
                <label for="address">Client Address:</label>
                <input type="text" name="address" class="form-control" id="address">
              <div class="form-group">
                <label for="phone">Client Phone:</label>
                <input type="text" name="tel" class="form-control" id="phone">
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