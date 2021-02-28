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
          <form enctype="multipart/form-data" action="{{route('receivedpayments.update',$donepayment)}}" method="post">
          @method('put')
          @csrf

            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="name">Payment Type:</label>
                    <select class="form-control" name="payment_type" id="">
                        @foreach($paymenttypes as $paymenttype)
                        <option value="{{$paymenttype->name}}" {{$paymenttype->name==$donepayment->payment_type?'selected':''}}>{{$paymenttype->name}}</option>
                        @endforeach
                    </select>
                    <a href="{{route('paymenttypes.create')}}">...</a>

                  </div>
                  <div class="form-group">
                    <label for="country">Payment Date:</label>
                    <input value="{{$donepayment->payment_date}}" type="text" name="payment_date" class="form-control datetimepicker" onchange="getDateData(0)" type="text" id="datetime0">
                  </div>
                  <div class="form-group">
                    <label for="paid_by">Paid by:</label>
                    <input value="{{$donepayment->paid_by}}" type="text" name="paid_by" class="form-control" id="paid_by">
                  </div>
                  <div class="form-group">
                    <label for="shipping_address">Shipping Address:</label>
                    <input value="{{$donepayment->shipping_address}}" type="text" name="shipping_address" class="form-control" id="shipping_address">
                  </div>
                  <div class="form-group">
                    <label for="transction_id">Transction ID</label>
                    <input value="{{$donepayment->transction_id}}" type="text" name="transction_id" class="form-control" id="transction_id">
                  </div>
                  <div class="form-group">
                    <label for="amount_paid">Amount Paid:</label>
                    <input value="{{$donepayment->amount_paid}}" type="text" name="amount_paid" class="form-control" id="amount_paid">
                  </div>
                  <div class="form-group">
                    <label for="phone">Bank:</label>
                    <select class="form-control" name="bank_id" id="">
                      @foreach($banks as $bank)
                      <option value="{{$bank->id}}"{{$bank->id==$donepayment->bank_id?'selected':''}}>{{$bank->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea name="notes" class="form-control" id="notes">{{$donepayment->notes}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="details">Details:</label>
                    <textarea name="details" class="form-control" id="details">{{$donepayment->details}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="rcpnt">Upload Receipt:</label>
                    <input type="file" name="rcpnt" id="rcpnt">
                  </div>
                </div>
                <div class="col">
                  <h3>INV #:{{$donepayment->invoice->inv_number}}</h3>
                  <p class="lead">Amount Due {{$donepayment->invoice->invoice_date}}</p>
                    
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Amount: </th>
                        <td>{{$donepayment->invoice->amount}}</td>
                      </tr>
                      <tr>
                        <th>Received: </th>
                        <td>{{$donepayment->invoice->received}}</td>
                      </tr>
                      <tr>
                        <th>The rest: </th>
                        <td>{{$donepayment->invoice->amount-$donepayment->invoice->received}}</td>
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