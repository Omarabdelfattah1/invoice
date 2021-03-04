@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add new Payment</h3>
  </div>
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
          <form action="{{route('receivedpayments.store')}}" method="post" enctype="multipart/form-data">
          @csrf

            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="name">Payment Type:</label>
                    <select class="form-control" name="payment_type" id="" required>
                        @foreach($paymenttypes as $paymenttype)
                        <option value="{{$paymenttype->name}}">{{$paymenttype->name}}</option>
                        @endforeach
                    </select>
                    <a href="{{route('paymenttypes.create')}}">...</a>

                  </div>
                  <div class="form-group">
                    <label for="country">Payment Date:</label>
                    <input type="text" name="payment_date" class="form-control datetimepicker" onchange="getDateData(0)" id="datetime0">
                  </div>
                  <div class="form-group">
                    <label for="paid_by">Paid by:</label>
                    <input type="text" name="paid_by" class="form-control" id="paid_by">
                  </div>
                  <div class="form-group">
                    <label for="shipping_address">Shipping Address:</label>
                    <input type="text" name="shipping_address" class="form-control" id="shipping_address">
                  </div>
                  <div class="form-group">
                    <label for="transction_id">Transction ID</label>
                    <input type="text" name="transction_id" class="form-control" id="transction_id">
                  </div>
                  <div class="form-group">
                    <label for="amount_paid">Amount Paid:</label>
                    <input type="text" name="amount_paid" class="form-control" id="amount_paid">
                  </div>
                  <div class="form-group">
                    <label for="exchange_rate">Exchange Rate:</label>
                    <input type="text" name="exchange_rate" class="form-control" id="exchange_rate">
                    <label for="exchange_rate_file">Exchange Rate File:</label>
                    <input type="file" name="exchange_rate_file"  id="exchange_rate_file">
                  </div>
                  <div class="form-group">
                    <label for="phone">Bank:</label>
                    <select class="form-control" name="bank_id" id="" required>
                        @foreach($banks as $bank)
                        <option value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="phone">Client:</label>
                    <select class="form-control" name="client_id" id="" required>
                        @foreach($clients as $client)
                        <option value="{{$client->id}}"
                          <?php if(isset($_GET['invoice_id'])){
                            $invoice=App\Models\Invoice::find($_GET['invoice_id']);
                            if($client->id==$invoice->client_id){
                              echo 'selected';
                            }
                          } 
                            ?>
                          >{{$client->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea name="notes" class="form-control" id="notes"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="details">Details:</label>
                    <textarea name="details" class="form-control" id="details"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="rcpnt">Upload Receipt:</label>
                    <input type="file" name="rcpnt" id="rcpnt">
                    <label for="rcpt_name">Receipt Name:</label>
                    <input type="text" name="rcpt_name" id="rcpt_name">
                  </div>
                </div>
                <div class="col">
                  @if(isset($_GET['invoice_id']))
                    <?php $invoice=App\Models\Invoice::find($_GET['invoice_id'])?>

                  <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                
                  <h3>INV #:{{$invoice->inv_number}}</h3>
                  <p class="lead">Amount Due {{$invoice->amount}}</p>

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
                  @endif
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