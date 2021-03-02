@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Currencies</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form method="post" action="{{isset($currency)?route('currencies.update',$currency):route('currencies.store')}}">
            @if(isset($currency))
              @method('put')
            @endif
            @csrf
            <div class="form-group">
              <label for="curr">Ref</label>
              <input type="text" value="{{isset($currency)?$currency->ref:''}}" name="ref" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="curr">Description</label>
              <input type="text" value="{{isset($currency)?$currency->description:''}}" name="description" class="form-control">
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
              <th>Currency</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($currencies as $currency)
              <tr>
                <td>{{$currency->id}}</td>
                <td>{{$currency->ref}}</td>
                <td>{{$currency->description}}</td>
                <td><a class="btn btn-primary" href="{{route('currencies.edit',$currency)}}"><i class="fas fa-edit"></i></a></td>
                <td><a class="btn btn-danger" href="{{route('currencies.delete',$currency)}}"><i class="fas fa-trash"></i></a><td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


@endsection