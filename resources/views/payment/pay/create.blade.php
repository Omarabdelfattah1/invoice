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
          <form action="{{route('payment_rs.store')}}" method="post">
            @csrf
            <div class="card-body">

              <h3>Receive Payment Form</h3>
              <table border="0">
              <tbody><tr> 
              <th align="left">Date :</th><td><input class="form-control" class="form-control datetimepicker hasDatepicker" type="text" id="datetime" name="pdate" placeholder="Select to date" required="">
                      </td></tr>


              <tr>
              <th align="left">Select Client</th><td>
              <select class="form-control" name="vendor_id">
              @foreach($vendors as $vendor)
              <option value="{{$vendor->id}}">{{$vendor->name}}</option>
              @endforeach
              </select>
              </td></tr>

              <tr><th align="left">Select Bank</th><td>
              <select class="form-control" name="bank_id">
                @foreach($banks as $bank)
                <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
              </select></td></tr>

              <tr><th align="left">Select Item</th><td>
                <select class="form-control" name="item_id">
                    @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
              </td></tr>
              <tr><th align="left">Description</th><td><textarea class="form-control" name="description"></textarea></td></tr>
              <tr><th align="left">Amount</th><td><input class="form-control" type="text" name="amount" id="amount"></td></tr>
              <tr><th align="left">Exchange</th><td><input class="form-control" type="checkbox" name="exchange" ></td></tr>
              <tr><th align="left">Select Currency</th><td>
              <select class="form-control" name="currency">
              
              </select></td></tr>
              <tr><th align="left">Exchange Rate</th><td><input class="form-control" id="exrate" type="text" name="exrate"></td></tr>
              <tr><th align="left">Exchange Amount</th><td><input class="form-control" id="examount" type="text" name="examount" readonly=""></td></tr>
              <tr><th align="left">Comment</th><td><textarea class="form-control" name="comment"></textarea></td></tr>
              <tr><th align="left">File Upload :</th><td><input class="form-control" type="text" name="name_image"><input class="form-control" type="file" name="file"></td></tr>
              <tr><th colspan="2"><input class="btn btn-primary" type="submit"  name="submit2"></th>
              </tr></tbody></table>
              
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection