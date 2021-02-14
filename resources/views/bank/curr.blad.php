@extends('layouts.home')
@section('header','Client Form')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">DataTable with default features</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{route('currenct.create')}}">
            <div class="form-group">
            <label for="curr">Currency</label>
            <input type="text" name="ref" class="form-control">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection