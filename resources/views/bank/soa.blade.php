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
    <form action="{{route('banks.download')}}" method="post">
    @csrf
      <textarea  id="editor" cols=100 rows=40 name=html>
        <table border="0" cellpadding="2" cellspacing="2" width="100%" >
          <tr>
            <td>Bank <br>
            <table border="0">
              <tr><td>{{$bank->name}}</td></tr>
              <tr><td>{{$bank->adress}}</td></tr>
              <tr><td>{{$bank->country}}</td></tr>
              <tr><td>{{$bank->tel}}</td></tr>
              <tr><td>{{$bank->email}}</td></tr>

            </table>
            </td>
          
            <td rowspan="2" style="font-size:200%;">Statement of Accounts </td>
            <td wid`th="220px" style="text-align:right"> <img alt="bankLogo" src="{{asset('imgs/logo1.png')}}" width="350px" height="200px" /> </td>
          </tr>
        </table>
        <br>
        <p align='center'><b>Balance/Payable : </b></p>
        <br>
        <table border="1" width="100%">
          <tr>
            <td  width="40%">
              <table border="1"  width="100%">
                <thead>
                  <tr>
                    <th colspan="4" align='center'><b>{{$bank->name}}</b></th>
                  </tr>
                  <tr>
                    <th colspan="4" align='center'>Payment Paid</th>
                  </tr>
                  <tr>
                    <th align='center'>Date</th>
                    <th align='center'>Vendor Name</th>
                    <th align='center'>Amount</th>
                    <th align='center'>Currency</th>
                  </tr>
                </thead>
                <?php $totalv=0;$month_flag = array();?>
                  @foreach($payment_d as $payment)
                  <?php
                  
                    $getYear = $getMonth = ''; 
                    $getMonth=date("m",strtotime($payment->payment_date));
                    $getYear=date("Y",strtotime($payment->payment_date));
  
                    if(!isset($month_flag[$getYear][$getMonth])) {
  
                      $month_flag[$getYear][$getMonth] = true;
  
                      echo "<tr>";
                      echo "<th colspan='5' align='center'>".date("F",strtotime($payment->payment_date))."</th>";
                      echo "</tr>";
  
                    }
                  ?>
                  <tr>
                    <td align='center'>{{$payment->payment_date}}</td>
                    <td align='center'>{{$payment->invoice->vendor->name}}</td>
                    <td align='center'>{{$payment->amount}}</td>
                    <td align='center'>{{$payment->currency}}</td>
                  </tr>
                  <?php $totalv+=$payment->amount?>
                  @endforeach
              </table>
            </td>
            <td width="60%">
              <table border="1" width="100%" style="table-layout: auto;" >
                <thead>
                  <tr>
                    <th colspan="5" align='center'><b><?php echo $bank->name; ?></b></th>
                  </tr>
                  <tr>
                    <th colspan="5" align='center'>Payments Received</th>
                  </tr>
                  <tr>
                    <th align='center' width="15%">Date</th>
                    <th align='center' width="30%">Description/To Date</th>
                    <th align='center' width="30%">Comment</th>
                    <th align='center' width="12.5%">Amount</th>
                    <th align='center' width="12.5%">XCH</th>
                  </tr>
                </thead>
                <?php $totalp=0;$month_flag = array();?>
                  @foreach($payment_r as $payment)
                  <?php
                  
                    $getYear = $getMonth = ''; 
                    $getMonth=date("m",strtotime($payment->payment_date));
                    $getYear=date("Y",strtotime($payment->payment_date));
  
                    if(!isset($month_flag[$getYear][$getMonth])) {
  
                      $month_flag[$getYear][$getMonth] = true;
  
                      echo "<tr>";
                      echo "<th colspan='5' align='center'>".date("F",strtotime($payment->payment_date))."</th>";
                      echo "</tr>";
  
                    }
                  ?>
                  <tr>
                    <td align='center'>{{$payment->payment_date}}</td>
                    <td align='left' >&nbsp;{{$payment->details}}</td>
                    <td align='left' >&nbsp;{{$payment->notes}}</td>
                    <td align='center'>{{$payment->amount}}</td>
                    <td align='center'>{{$payment->exchange_rate}}</td>
                  </tr>
                  <?php $totalp=$payment->amount?>
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
