@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Vendor</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{route('vendors.update',$vendor)}}" method="post">
          @method('put')
          @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
              <div class="form-group">
                <label for="name">Vendor Name:</label>
                <input type="text" name="name" class="form-control" id="name" value="{{$vendor->name}}">
              </div>
              <div class="form-group">
                <label for="email">Vendor Email:</label>
                <input type="email" name="email" class="form-control" id="email" value="{{$vendor->email}}">
              </div>
              <div class="form-group">
                <label for="country">Vendor Country:</label>
                <input type="text" name="country" class="form-control" id="country" value="{{$vendor->Country}}">
              </div>
              <div class="form-group">
                <label for="address">Vendor Address:</label>
                <input type="text" name="address" class="form-control" id="address" value="{{$vendor->address}}">
              <div class="form-group">
                <label for="phone">Vendor Phone:</label>
                <input type="text" name="tel" class="form-control" id="phone" value="{{$vendor->tel}}">
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