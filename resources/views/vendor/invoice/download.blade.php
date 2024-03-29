
<table border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td>{{$model->wfrom_company}} <br />
      <table border="0">
        
        @if($vinvoic->company->name && $model->c_name_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->company->name}}
          </td>
        </tr>
        @endif 
        @if($vinvoic->company->address && $model->c_address_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->company->address}}
          </td>
        </tr>
        @endif 
        @if($vinvoic->company->phone  && $model->c_phone_v==1)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->company->phone}}
          </td></tr>
        @endif 
        @if($vinvoic->company->country  && $model->c_country_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->company->country}}
        </td></tr>
        @endif 
        @if($vinvoic->company->email  && $model->c_email_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->company->email}}
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
        
        @if($vinvoic->client->name && $model->cl_name_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->client->name}}
          </td>
        </tr>
        @endif 
        @if($vinvoic->client->address && $model->cl_address_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->client->address}}
          </td>
        </tr>
        @endif 
        @if($vinvoic->client->phone  && $model->cl_phone_v==1)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->client->phone}}
          </td></tr>
        @endif 
        @if($vinvoic->client->country  && $model->cl_country_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->client->country}}
        </td></tr>
        @endif 
        @if($vinvoic->client->email  && $model->cl_email_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoic->client->email}}
        </td></tr>
        @endif 
        
      </table>
    </td>
    <td>
      <table border="0">
        <tr><td>{{$model->winvoice_number}}</td><td>{{$vinvoic->inv_number}}</td></tr>
        <tr><td>{{$model->wfrom_date}}</td><td>{{$vinvoic->invoice_date}}</td></tr>
        <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
      </table>


    </td>

  </tr>
</table>
<?php echo str_repeat("&nbsp;<br />",$model->sp_date_heading)?>

@if($model->from_date_v==1 && $model->to_date_v==1 && $model->text1_v==1)
<p style="text-align:center;">
{{$model->text1}} From 
    @if($vinvoic->type=='week')Mon {{$vinvoic->from_date}}
     till Sun {{$vinvoic->to_date}}
    @else
    <?php echo date('F-Y',strtotime($vinvoic->from_date));?> till  
    <?php echo date('F-Y',strtotime($vinvoic->to_date));?>
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
    
    <?php $total=0;$q=0;?>
    @foreach($vinvoic->invoice_items as $item)
      <tr>
        <td align="{{$model->item_code_alignment_d != null?$model->item_code_alignment_d:'center'}}">{{$item->item->name}}</td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}">{{$item->item->description}}</td>
        <td align="{{$model->quantity_alignment_d != null?$model->quantity_alignment_d:'center'}}">{{$item->quantity}}</td>
        <td align="{{$model->price_alignment_d != null?$model->price_alignment_d:'center'}}">{{$item->item->rate}}</td>
        <td align="{{$model->amount_alignment_d != null?$model->amount_alignment_d:'center'}}"><?php echo number_format($item->item->rate*$item->quantity, 2); ?></td>
        <?php $total+=$item->item->rate*$item->quantity;$q+=$item->quantity;?>
      </tr>
    @endforeach
    <tr>
      <td colspan="5" style="border-bottom:2px solid {{$model->color_border}};">&nbsp;</td>
    </tr>
      @foreach($previous as $p)
      <tr>
        <td align="{{$model->item_code_alignment_d != null?$model->item_code_alignment_d:'center'}}"></td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:'center'}}" style="color:white;background-color:{{$model->color_sheme}};">{{$p->inv_number}}</td>
        <td align="{{$model->quantity_alignment_d != null?$model->quantity_alignment_d:'center'}}"></td>
        <td align="{{$model->price_alignment_d != null?$model->price_alignment_d:'center'}}" style="color:white;background-color:{{$model->color_sheme}};" >Balance</td>
        <td align="{{$model->amount_alignment_d != null?$model->amount_alignment_d:'center'}}"><?php echo number_format($p->amount-$p->received,2);?></td>
        <?php $total+=$p->amount-$p->received;?>
      </tr>
      @endforeach
    <tr>
      <td colspan="2">&nbsp;</td>
      <td style="text-align:'center'">{{$model->wtotal_quantity}}</td>
      <td style="color:white;background-color:{{$model->color_sheme}};" align="{{$model->wtotal_alignment}}">Total : </td>
      <td align="{{$model->total_alignment}}"><?php
        $inv_date=strtotime($vinvoic->to_date);
        if($inv_date < strtotime(date('d-m-Y'))){
          echo "0";
        }else{
          echo number_format($total - $vinvoic->received,2);          
        }
      ?></td>
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
          
