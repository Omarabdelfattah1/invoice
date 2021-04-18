
<table border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td>{{$model->wfrom_company}} <br />
      <table border="0">
        
        @if($invoice->company->name && $model->c_name_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->name}}
          </td>
        </tr>
        @endif 
        @if($invoice->company->address && $model->c_address_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->address}}
          </td>
        </tr>
        @endif 
        @if($invoice->company->phone  && $model->c_phone_v==1)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->phone}}
          </td></tr>
        @endif 
        @if($invoice->company->country  && $model->c_country_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->country}}
        </td></tr>
        @endif 
        @if($invoice->company->email  && $model->c_email_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->email}}
        </td></tr>
        @endif 
        
      </table>
    </td>
    <td rowspan="2" style="font-size:200%;"><?php echo str_repeat("&nbsp;<br />",$model->title_sp);?>{!!$model->invoice_title!!}</td>
    <td style="text-align:right"> <img alt="CompanyLogo" src="{{asset('imgs/logo1.png')}}" width="350px" height="200px" /> </td>
  </tr>
  <tr>
    <td>{{$model->wto_client}}<br />
    <table border="0">
        
        @if($invoice->client->name && $model->cl_name_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->name}}
          </td>
        </tr>
        @endif 
        @if($invoice->client->address && $model->cl_address_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->address}}
          </td>
        </tr>
        @endif 
        @if($invoice->client->phone  && $model->cl_phone_v==1)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->phone}}
          </td></tr>
        @endif 
        @if($invoice->client->country  && $model->cl_country_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->country}}
        </td></tr>
        @endif 
        @if($invoice->client->email  && $model->cl_email_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->email}}
        </td></tr>
        @endif 
        
      </table>
    </td>
    <td>
      <table border="0">
        <tr><td>{{$model->winvoice_number}}</td><td>{{$invoice->inv_number}}</td></tr>
        <tr><td>{{$model->wfrom_date}}</td><td>{{$invoice->invoice_date}}</td></tr>
        <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
      </table>


    </td>

  </tr>
</table>
<?php echo str_repeat("&nbsp;<br />",$model->sp_date_heading)?>

@if($model->from_date_v==1 && $model->to_date_v==1 && $model->text1_v==1)
<p style="text-align:center;">
{{$model->text1}} From 
    @if($invoice->type=='week')Mon {{$invoice->from_date}}
     till Sun {{$invoice->to_date}}
    @else
    <?php echo date('F-Y',strtotime($invoice->from_date));?> till  
    <?php echo date('F-Y',strtotime($invoice->to_date));?>
    @endif</p>
@endif
<table border="0" cellspacing="2" cellpadding="2">
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
    <?php
      $received = 0;
      $time = strtotime($invoice->invoice_date);
      $p_total=0;
      $newformat = date('M',$time);
      $month=$invoice->type=='month'? '_'.$newformat:'';
      $total=0;$q=0;
    ?>
    @foreach($invoice->invoice_items as $item)
      <tr>
        <td align="{{$model->item_code_alignment_d != null?$model->item_code_alignment_d:'center'}}">{{$item->item->name}}<?= $month ?></td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}">{{$item->item->description}}<?= $month ?></td>
        <td align="{{$model->quantity_alignment_d != null?$model->quantity_alignment_d:'center'}}">{{$item->quantity}}</td>
        <td align="{{$model->price_alignment_d != null?$model->price_alignment_d:'center'}}">{{$item->item->rate}}</td>
        <td align="{{$model->amount_alignment_d != null?$model->amount_alignment_d:'center'}}"><?php echo number_format($item->item->rate*$item->quantity,2)?></td>
        <?php $total+=$item->item->rate*$item->quantity;$q+=$item->quantity;?>
      </tr>
    @endforeach
    <tr>
      <td colspan="5" style="border-bottom:2px solid {{$model->color_border}};">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td style="text-align:'center'">{{$model->wtotal_quantity}}</td>
      <td style="color:white;background-color:{{$model->color_sheme}};" align="{{$model->wtotal_alignment}}">Total : </td>
      <td align="{{$model->total_alignment}}"><?php
        // $inv_date=strtotime($invoice->to_date);
        // if($inv_date < strtotime(date('d-m-Y'))){
        //   echo "0";
        // }else{
          echo number_format($total,2);          
        // }
      ?></td>
    </tr>
      @foreach($previous as $p)
      <tr>
        <td align="{{$model->item_code_alignment_d != null?$model->item_code_alignment_d:'center'}}"></td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}" style="color:white;background-color:{{$model->color_sheme}};">{{$p->inv_number}}</td>
        <td align="{{$model->quantity_alignment_d != null?$model->quantity_alignment_d:'center'}}"></td>
        <td align="{{$model->price_alignment_d != null?$model->price_alignment_d:'center'}}" style="color:white;background-color:{{$model->color_sheme}};" >Balance</td>
        <td align="{{$model->amount_alignment_d != null?$model->amount_alignment_d:'center'}}"><?php echo number_format($p->amount-$p->received,2)?></td>
        <?php $p_total+=$p->amount-$p->received;?>
      </tr>
      @endforeach
    @if($p_total)
    <tr>
      <td colspan="2">&nbsp;</td>
      <td style="text-align:'center'">{{$model->wtotal_quantity}}</td>
      <td style="color:white;background-color:{{$model->color_sheme}};" align="{{$model->wtotal_alignment}}">Grand Total : </td>
      <td align="{{$model->total_alignment}}"><?php
        // $inv_date=strtotime($invoice->to_date);
        // if($inv_date < strtotime(date('d-m-Y'))){
        //   echo "0";
        // }else{
          echo number_format($total+$p_total,2);          
        // }
      ?></td>
    </tr>
    @endif
    @foreach($payments as $p)
      <tr>
        <td>&nbsp;</td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}" style="color:white;background-color:green;">{{$p->payment_date}}:</td>
        <td colspan="2"></td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}"><?php echo number_format($p->amount_paid/$p->exchange_rate,2);?></td>
        <?php $received += $p->amount_paid/$p->exchange_rate;?>
      </tr>
    @endforeach
    <tr>
        <td colspan="3">&nbsp;</td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}" style="background-color:yellow;">Balance:</td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}"><?php echo number_format($total - $received,2);?></td>
      </tr>
  </tbody>
  
</table>
<?php echo str_repeat("&nbsp;<br />",$model->sp_gt_note)?>

  <p style="text-align:center;border-bottom:2px solid {{$model->color_border}};">
  {!!$model->wnote!!}
  <?php echo str_repeat("&nbsp;<br />",$model->sp_note_top)?>

</p>


<table Style="background-color:#FFFFFF;" border=0>

  @if($model->note1_v==1)<tr><td> {!!$model->note1!!} </td></tr>@endif
</table>
<?php echo str_repeat("&nbsp;<br />",$model->sp_note_footer);?>

<p style="text-align:{{$model->footer_alignment != null?$model->footer_alignment:'center'}};border-top:2px solid {{$model->color_border}};">

{{$model->footer}}</p>
          
