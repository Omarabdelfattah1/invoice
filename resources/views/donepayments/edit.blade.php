@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Company</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{route('companys.update',$company)}}" method="post">
          @method('put')
          @csrf

            <div class="card-body">
              <div class="form-group">
                <label for="name">Company Name:</label>
                <input type="text" name="name" class="form-control" id="name" value="{{$company->name}}">
              </div>
              <div class="form-group">
                <label for="email">Company Email:</label>
                <input type="email" name="email" class="form-control" id="email" value="{{$company->email}}">
              </div>
              <div class="form-group">
                <label for="country">Company Country:</label>
                <input type="text" name="country" class="form-control" id="country" value="{{$company->Country}}">
              </div>
              <div class="form-group">
                <label for="address">Company Address:</label>
                <input type="text" name="address" class="form-control" id="address" value="{{$company->address}}">
              <div class="form-group">
                <label for="phone">Company Phone:</label>
                <input type="text" name="tel" class="form-control" id="phone" value="{{$company->tel}}">
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