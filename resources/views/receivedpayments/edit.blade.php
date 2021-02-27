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
          <form action="{{route('receivedpayments.update',$receivedpayment)}}" method="post">
          @method('put')
          @csrf

            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="name">Payment Type:</label>
                    <select class="form-control" name="payment_type" id="">
                        @foreach($paymenttypes as $paymenttype)
                        <option value="{{$paymenttype->name}}" {{$receivedpayment->payment_type==$paymenttype->name?'selected':''}}>{{$paymenttype->name}}</option>
                        @endforeach
                    </select>
                    <a href="{{route('paymenttypes.create')}}">...</a>

                  </div>
                  <div class="form-group">
                    <label for="country">Payment Date:</label>
                    <input type="text" value="{{$receivedpayment->payment_date}}" name="payment_date" class="form-control datetimepicker" onchange="getDateData(0)" type="text" id="datetime0">
                  </div>
                  <div class="form-group">
                    <label for="amount_paid">Amount Paid:</label>
                    <input type="text" value="{{$receivedpayment->amount_paid}}" name="amount_paid" class="form-control" id="amount_paid">
                  </div>
                  <div class="form-group">
                    <label for="phone">Bank:</label>
                    <select class="form-control" name="bank_id" id="">
                        @foreach($banks as $bank)
                        <option value="{{$bank->id}}" {{$receivedpayment->bank_id==$bank->id?'selected':''}}>{{$bank->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <input type="hidden" name="invoice_id" value="{{$receivedpayment->invoice->id}}">
                </div>
                <div class="col">
                  <h3>INV #:{{$receivedpayment->invoice->inv_number}}</h3>
                  <p class="lead">Amount Due {{$receivedpayment->invoice->invoice_date}}</p>
                    
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Amount: </th>
                        <td>{{$receivedpayment->invoice->amount}}</td>
                      </tr>
                      <tr>
                        <th>Received: </th>
                        <td>{{$receivedpayment->invoice->received}}</td>
                      </tr>
                      <tr>
                        <th>The rest: </th>
                        <td>{{$receivedpayment->invoice->amount-$receivedpayment->invoice->received}}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
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