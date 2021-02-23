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
    <option value="{{$model1->id}}" {{$model->id==$invoice->model_id?'selected':''}}>{{$model1->name}}</option>
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
             
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h4><b>{{$model->wfrom_company}}</b></h4>

                  <address>
                  @if($invoice->company->name && $model->c_name_v==1)
                    <strong><?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->name}}</strong><br>
                  @endif 
                  @if($invoice->company->address && $model->c_address_v==1)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->address}}<br>
                  @endif 
                  @if($invoice->company->phone  && $model->c_phone_v==1)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->phone}}<br>
                  @endif 
                  @if($invoice->company->country  && $model->c_country_v==1)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->country}}<br>
                  @endif 
                  @if($invoice->company->email  && $model->c_email_v==1)
                   <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->email}}
                  @endif
                  </address>
                  <h4><b>{{$model->wto_client}}</b></h4>

                  <address>
                    @if($invoice->client->name && $model->cl_name_v==1)
                      <strong><?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->name}}</strong><br>
                    @endif 
                    @if($invoice->client->address && $model->cl_address_v==1)
                      <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->address}}<br>
                    @endif 
                    @if($invoice->client->phone  && $model->cl_phone_v==1)
                      <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->phone}}<br>
                    @endif 
                    @if($invoice->client->country  && $model->cl_country_v==1)
                      <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->country}}<br>
                    @endif 
                    @if($invoice->client->email  && $model->cl_email_v==1)
                    <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->email}}
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
                    <tr><td>{{$model->wfrom_date}}</td><td>{{$invoice->invoice_date}}</td></tr>
                    <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
                  </table>
                </div>
              </div>
              @if($model->from_date_v==1 && $model->to_date_v==1)
                <p style="text-align:center;">
                {{$model->text1}} From 
                    @if($invoice->type=='week')Mon {{$invoice->from_date}}
                    till Sun {{$invoice->to_date}}
                    @else
                    <?php echo date('F-Y',strtotime($invoice->from_date));?> till  
                    <?php echo date('F-Y',strtotime($invoice->to_date));?>
                    @endif</p>
              @endif
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr style="border-bottom:solid 2px {{$model->color_heading}};background-color:{{$model->color_sheme}};color:#FFFFFF;text-align:'center';">
                      <th align="{{$model->item_code_alignment != null?$model->item_code_alignment:'center'}}" style="border-bottom:2px solid {{$model->color_heading}};">{{$model->witem_code}}</th>
                      <th align="{{$model->description_alignment != null?$model->description_alignment:'center'}}" style="border-bottom:2px solid {{$model->color_heading}};">{{$model->wdescription}}</th>
                      <th align="{{$model->quantity_alignment != null?$model->quantity_alignment:'center'}}" style="border-bottom:2px solid {{$model->color_heading}};">{{$model->wquantity}}</th>
                      <th align="{{$model->price_alignment != null?$model->price_alignment:'center'}}" style="border-bottom:2px solid {{$model->color_heading}};">{{$model->wprice}}</th>
                      <th align="{{$model->amount_alignment != null?$model->amount_alignment:'center'}}" style="border-bottom:2px solid {{$model->color_heading}};">{{$model->wamount}}</th>
                    </tr>	
                    </thead>
                    <tbody>
                      <?php $total=0;$q=0;?>
                      @foreach($invoice->invoice_items as $item)
                        <tr>
                          <td align="{{$model->item_code_alignment_d != null?$model->item_code_alignment_d:'center'}}">{{$item->item->name}}</td>
                          <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}">{{$item->item->description}}</td>
                          <td align="{{$model->quantity_alignment_d != null?$model->quantity_alignment_d:'center'}}">{{$item->quantity}}</td>
                          <td align="{{$model->price_alignment_d != null?$model->price_alignment_d:'center'}}">{{$item->item->rate}}</td>
                          <td align="{{$model->amount_alignment_d != null?$model->amount_alignment_d:'center'}}">{{$item->item->rate*$item->quantity}}</td>
                          <?php $total+=$item->item->rate*$item->quantity;$q+=$item->quantity;?>
                        </tr>
                      @endforeach
                      <tr>
                        <td colspan="5" style="border-bottom:2px solid {{$model->color_border}};">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                        <td style="text-align:center">{{$model->wtotal_quantity}}</td>
                        <td style="color:white;background-color:{{$model->color_sheme}};" align="{{$model->wtotal_alignment}}">Total : </td>
                        <td align="{{$model->total_alignment}}">{{$total}}</td>
                      </tr>
                      
                    </tbody>
                    
                  </table>
                  @if($model->wnote)
                    <?php echo str_repeat('<br>',$model->sp_gt_note)?>
                    <p style="text-align:'center';border-bottom:2px solid {{$model->color_border}};">{!!$model->wnote!!}</p>
                  @endif
                  <?php echo str_repeat('<br>',$model->sp_note_top)?>

                  <table Style="background-color:#FFFFFF;" border=0>

                    @if($model->note1_v==1)<tr><td> {!!$model->note1!!} </td></tr>@endif
                  </table>
                  <table>
                    <?php echo str_repeat('<tr><td ></td></tr>',$model->sp_note_footer);?>
                  </table>
                  <p style="text-align:{{$model->footer_alignment != null?$model->footer_alignment:'center'}};border-top:2px solid {{$model->color_border}};">{{$model->footer}}</p>
                      
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