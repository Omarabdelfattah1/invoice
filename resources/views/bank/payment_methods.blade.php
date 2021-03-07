@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">paymenttypes</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form method="post" action="{{isset($paymenttype)?route('paymenttypes.update',$paymenttype):route('paymenttypes.store')}}">
            @if(isset($paymenttype))
              @method('put')
            @endif
            @csrf
            <div class="form-group">
              <label for="curr">Method Name</label>
              <input type="text" value="{{isset($paymenttype)?$paymenttype->name:''}}" name="name" class="form-control">
            </div>
            <button class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
      <div class="row">
        <table class="table" border="1">
          <thead>
            <tr>
              <th>Id</th>
              <th>Method</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($paymenttypes as $paymenttype)
              <tr>
                <td>{{$paymenttype->id}}</td>
                <td>{{$paymenttype->name}}</td>
                <td><a class="btn btn-primary" href="{{route('paymenttypes.edit',$paymenttype)}}"><i class="fas fa-edit"></i></a></td>
                <td><a class="btn btn-danger" href="{{route('paymenttypes.delete',$paymenttype)}}"><i class="fas fa-trash"></i></a><td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


@endsection