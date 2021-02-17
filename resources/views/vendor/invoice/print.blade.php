<?php
$spc=$model->sp_note_footer;
$nbb='<tr><td ></td></tr>';
$nbspc='';
for ($sp=1;$sp<=$spc;$sp++)
{
	$nbspc=$nbspc.$nbb;
};

//---------spc notes--------//
$spc2=$model->sp_gt_note;
$nbb2='<br>';
$nbspc2='';
for ($sp=1;$sp<=$spc2;$sp++)
{
	$nbspc2=$nbspc2.$nbb2;
};
//--------------------------//
//---------spc title--------//
$spc3=$model->title_sp;
$nbb3='<br>';
$nbspc3='';
for ($sp=1;$sp<=$spc3;$sp++)
{
	$nbspc3=$nbspc3.$nbb3;
};
$cm0='#0695AD';
$cm1='#CCFFFF';
$cm2='#FFFFFF';
$cm3='#00CCCC';

?>

@extends('layouts.home')
@section('content')
<form action="{{route('invoices.change-model',$vinvoice)}}" method="post">
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
                <div class="col-12">
                  <h4>
                    <img src="{{asset('imgs/logo1.png')}}" height="240" width="240" alt="">
                    <small class="float-right">Inv Date:{{$vinvoice->invoice_date}}</small><br>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h4><b>{{$model->wfrom_company}}</b></h4>

                  <address>
                    <strong><?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->name}}</strong><br>
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->country}}<br>
                    @if($vinvoice->company->address)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->address}}<br>
                    @endif
                    @if($vinvoice->company->phone)
                    Phone: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->phone}}<br>
                    @endif
                    @if($vinvoice->company->email)
                    Email: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->email}}
                    @endif
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h4><b>{{$model->wto_client}}</b></h4>

                  <address>
                    <strong><?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->name}}</strong><br>
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->country}}<br>
                    @if($vinvoice->vendor->address)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->address}}<br>
                    @endif
                    @if($vinvoice->vendor->phone)
                    Phone: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->phone}}<br>
                    @endif
                    @if($vinvoice->vendor->email)
                    Email: <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->email}}
                    @endif
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                   <p ><b >{{$model->winvoice_number}}</b>{{$vinvoice->inv_number}}</p>
                   <p ><b >{{$model->wfrom_date}}</b>{{$vinvoice->from_date}}</p>
                   <p ><b >{{$model->wto_date}} </b>Due on Receipt</p>
                </div>
              </div>
              <p style="text-align:center;">{{$model->text1}} From Mon {{$vinvoice->invoice_date}} till Sun {{$vinvoice->to_date}}</p>
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
                    @foreach($vinvoice->invoice_items as $item)

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
                <button onclick="window.print()" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
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