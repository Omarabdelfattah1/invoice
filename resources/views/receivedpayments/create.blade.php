@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add new Payment</h3>
  </div>
  <?php $invoice=App\Models\Invoice::find($_GET['invoice_id'])?>
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
          <form action="{{route('receivedpayments.store')}}" method="post">
          @csrf

            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="name">Payment Type:</label>
                    <select class="form-control" name="payment_type" id="">
                        @foreach($paymenttypes as $paymenttype)
                        <option value="{{$paymenttype->name}}">{{$paymenttype->name}}</option>
                        @endforeach
                    </select>
                    <a href="{{route('paymenttypes.create')}}">...</a>

                  </div>
                  <div class="form-group">
                    <label for="country">Payment Date:</label>
                    <input type="text" name="payment_date" class="form-control datetimepicker" onchange="getDateData(0)" type="text" id="datetime0">
                  </div>
                  <div class="form-group">
                    <label for="amount_paid">Amount Paid:</label>
                    <input type="text" name="amount_paid" class="form-control" id="amount_paid">
                  </div>
                  <div class="form-group">
                    <label for="phone">Bank:</label>
                    <select class="form-control" name="bank_id" id="">
                        @foreach($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                </div>
                <div class="col">
                  <h3>INV #:{{$invoice->inv_number}}</h3>
                  <p class="lead">Amount Due {{$invoice->invoice_date}}</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Amount: </th>
                        <td>{{$invoice->amount}}</td>
                      </tr>
                      <tr>
                        <th>Received: </th>
                        <td>{{$invoice->received}}</td>
                      </tr>
                      <tr>
                        <th>The rest: </th>
                        <td>{{$invoice->amount-$invoice->received}}</td>
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
<script>
$(document).ready(function(){
    
    $("#exrate,#amount").on('keyup',function(){

        document.getElementById("examount").value = '';
        var price = document.getElementById("amount").value
        var amount = document.getElementById("exrate").value
        var val = price * amount;
        
      if(price &&amount) {
       document.getElementById("examount").value = val;
      }
       
    });

});
</script>
@section('scripts')
<script type="text/javascript">
     function getDateData(id) {
            var x = document.getElementById("datetime" + id);
            //x.value = x.value.toUpperCase();
            if(x.value){
                if(x.value.includes("00:00:00")){
                    document.getElementById("datetime" + id).value = x.value.slice(0,10);
                }
            }
        }
    $(function () {
        $('.datetimepicker').datetimepicker({
                dateFormat:"dd-mm-yy",
                timeFormat: 'HH:mm:ss'
            }
        );
    });

</script>
@endsection
@endsection