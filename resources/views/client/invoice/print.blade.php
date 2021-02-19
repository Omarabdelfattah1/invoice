<?php

$cm0='#0695AD';
$cm1='#CCFFFF';
$cm2='#FFFFFF';
$cm3='#00CCCC';

?>

@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('content')
<form action="{{route('invoices.change-model',$invoice)}}" method="post">
  @csrf
  @method('put')
  <label for="mmm">Choose Model</label>
  <input type="hidden" name="model" value="1">
  <select name="model_id" id="mmm">
    @foreach($models as $model1)
    <option value="{{$model1->id}}">{{$model1->name}}</option>
    @endforeach
  </select>
  <button type="submit" class="btn btn-primary">Change</button>
</form>
<div class="card">
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h4><b>{{$model->wfrom_company}}</b></h4>

                  <address>
                    <strong><?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->name}}</strong><br>
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->country}}<br>
                    @if($invoice->company->address)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->address}}<br>
                    @endif
                    @if($invoice->company->phone)
                    Phone: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->phone}}<br>
                    @endif
                    @if($invoice->company->email)
                    Email: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->email}}
                    @endif
                  </address><br><br><br><br>
                  <h4><b>{{$model->wto_client}}</b></h4>

                  <address>
                    <strong><?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->name}}</strong><br>
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->country}}<br>
                    @if($invoice->client->address)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->address}}<br>
                    @endif
                    @if($invoice->client->phone)
                    Phone: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->phone}}<br>
                    @endif
                    @if($invoice->client->email)
                    Email: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->email}}
                    @endif
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                  {!!$model->invoice_title!!}
                  </div>
                  <div class="col-sm-4 invoice-col">
                  <h4>
                    <img src="{{asset('imgs/logo1.png')}}"  width="350" height="200" alt="">
                  </h4>
                  <table border="0">
                    <tr><td>{{$model->winvoice_number}}</td><td>{{$invoice->inv_number}}</td></tr>
                    <tr><td>{{$model->wfrom_date}}</td><td>{{$invoice->from_date}}</td></tr>
                    <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
                  </table>
                </div>
              </div>
              <p style="text-align:center;">{{$model->text1}} From Mon {{$invoice->from_date}} till Sun {{$invoice->to_date}}</p>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr style="background-color:{{$cm0}};color:{{$cm2}};text-align:center;">
                      <th align="center" style="border-bottom:solid 2px #ff0000;">{{$model->witem_code}}</th>
                      <th align="center" style="border-bottom:solid 2px #ff0000;">{{$model->wdescription}}</th>
                      <th align="center" style="border-bottom:solid 2px #ff0000;">{{$model->wquantity}}</th>
                      <th align="center" style="border-bottom:solid 2px #ff0000;">{{$model->wprice}}</th>
                      <th align="center" style="border-bottom:solid 2px #ff0000;">{{$model->wamount}}</th>
                    </tr>		
                    </thead>
                    <tbody>
                    <?php $total=0;$q=0;?>
                    @foreach($invoice->invoice_items as $item)

                    <tr>
                      <td align="left">{{$item->item->name}}</td>
                      <td align="center">{{$item->item->description}}</td>
                      <td align="left">{{$item->quantity}}</td>
                      <td align="center">{{$item->item->rate}}</td>
                      <td align="left">{{$item->item->rate*$item->quantity}}</td>
                      <?php $total+=$item->item->rate*$item->quantity;$q+=$item->quantity;?>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>{{$q}}</td>
                        <td align="center">Total</td>
                        <td ><?php echo $total;?></td>
                      </tr>
                    </tfoot>
                  </table>
                  <?php echo str_repeat('<br>',$model->sp_gt_note)?>
                  <p style="text-align:center;border-bottom:2px solid #00CCCC;">{!!$model->wnote!!}</p>
   
 
                  <table Style="background-color:#FFFFFF;" border=0>
                  
                  
                  <tr><td> {!!$model->note1!!} </td></tr>
                  <tr><td> {!!$model->note2!!} </td></tr>
                  <tr><td> {!!$model->note3!!} </td></tr>
                  <tr><td> {!!$model->note4!!} </td></tr> 
                    </table>
                    <?php echo str_repeat('<tr><td ></td></tr>',$model->sp_note_footer)?>
                  
                  <table>
                  <p style="text-align:center;border-top:2px solid #00CCCC;"><h5>{{$model->footer}}</h5> </p>
                </div>
                <!-- /.col -->
              </div>
              <div class="row no-print">
                <div class="col-12">
                <a href="{{route('invoices.download',$invoice)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
        
        </div>
      </div>
    </div>
  </div>
</div>
<script>
</script>
@endsection
@section('scripts')
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
@endsection