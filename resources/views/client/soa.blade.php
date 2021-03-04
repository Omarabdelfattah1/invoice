@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
<script type="text/javascript">
      _editor_url = "{{asset('htmlarea/')}}";
      _editor_lang = "en";
</script>
<script type="text/javascript" src="{{asset('htmlarea/htmlarea.js')}}"></script>
<script type="text/javascript">
  HTMLArea.loadPlugin("ContextMenu");
  HTMLArea.onload = function() {
    var editor = new HTMLArea("editor");
    editor.registerPlugin(ContextMenu);
    editor.generate();
    
  };
  HTMLArea.init();
</script>
@endsection
@section('content')
<div class="card">
  <!-- /.card-header -->
  <div class="card-body">
    <form action="{{route('clients.download')}}" method="post">
    @csrf
      <textarea  id="editor" cols=100 rows=40 name=html>
        <table border="0" cellpadding="2" cellspacing="2" width="100%" >
          <tr>
            <td>From <br>
            <table border="0">
              <tr><td>{{$company->name}}</td></tr>
              <tr><td>{{$company->adress}}</td></tr>
              <tr><td>{{$company->country}}</td></tr>
              <tr><td>{{$company->tel}}</td></tr>
              <tr><td>{{$company->email}}</td></tr>

            </table>
            </td>
          
            <td rowspan="2" style="font-size:200%;">Statement of Accounts </td>
            <td wid`th="220px" style="text-align:right"> <img alt="CompanyLogo" src="{{asset('imgs/logo1.png')}}" width="350px" height="200px" /> </td>
          </tr>
          <tr>
            <td>To <br>

              <table border="0">
                <tr><td>{{$client->name}}</td></tr>
                <tr><td>{{$client->adress}}</td></tr>
                <tr><td>{{$client->country}}</td></tr>
                <tr><td>{{$client->tel}}</td></tr>
                <tr><td>{{$client->email}}</td></tr>
              </table>

            </td>
          </tr>
        </table>
        <br>
        <p align='center'><b>Balance/Payable :
        <?php $balance=0;
          foreach($invoices as $invoice){
            $balance+=$invoice->amount;
          }
          foreach($payments as $payment){
            $balance-=$payment->amount_paid/$payment->exchange_rate;
          }
          echo $balance .' USD$';
        ?>    
      </b></p>
        <br>
        <table border="1" width="100%">
          <tr>
            <td  width="40%">
              <table border="1"  width="100%">
                <thead>
                  <tr>
                    <th colspan="4" align='center'><b>{{$company->name}}</b></th>
                  </tr>
                  <tr>
                    <th colspan="4" align='center'>Invoice/Payments</th>
                  </tr>
                  <tr>
                    <th align='center'>Invoice Date</th>
                    <th align='center'>Inv_Number</th>
                    <th align='center'>USD$</th>
                  </tr>
                </thead>
                <?php $totalv=0;?>
                  @foreach($invoices as $invoice)
                  <tr>
                    <td align='center'>{{$invoice->invoice_date}}</td>
                    <td align='center'>{{$invoice->inv_number}}</td>
                    <td align='center'>{{$invoice->amount}}</td>
                  </tr>
                  <?php $totalv+=$invoice->amount?>
                  @endforeach
              </table>
            </td>
            <td width="60%">
              <table border="1" width="100%" style="table-layout: auto;" >
                <thead>
                  <tr>
                    <th colspan="6" align='center'><b><?php echo $client->name; ?></b></th>
                  </tr>
                  <tr>
                    <th colspan="6" align='center'>Invoice/Payments</th>
                  </tr>
                  <tr>
                    <th align='center' width="15%">Date</th>
                    <th align='center' width="30%">Comment</th>
                    <th align='center' width="12.5%">Amount</th>
                    <th align='center' width="12.5%">XCH</th>
                    <th align='center' width="12.5%">USD$</th>
                  </tr>
                </thead>
                <?php $totalp=0;?>
                  @foreach($payments as $payment)
                  <tr>
                    <td align='center'>{{$payment->payment_date}}</td>
                    <td align='left' >&nbsp;{{$payment->notes}}</td>
                    <td align='center'>{{$payment->amount_paid}}</td>
                    <td align='center'>{{$payment->exchange_rate}}</td>
                    <td align='center'>{{$payment->amount_paid/$payment->exchange_rate}}</td>
                  </tr>
                  <?php $totalp=$payment->amount_paid/$payment->exchange_rate?>
                  @endforeach
              </table>
            </td>
          </tr>
          <tr>
            <td align='center'>Total : {{$totalv}} </td>
            <td align='center'>Total : {{$totalp}}</td>
          </tr>
        </table>
      </textarea> 
      <button type="submit">Generate</button>
    </form>
  </div>
</div>
<script>
</script>
@endsection
