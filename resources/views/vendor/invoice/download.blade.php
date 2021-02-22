
<table border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td>{{$model->wfrom_company}} <br>
      <table border="0">
        
        @if($vinvoice->vendor->name && $model->c_name_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->name}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->vendor->address && $model->c_address_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->address}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->vendor->phone  && $model->c_phone_v==1)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->phone}}
          </td></tr>
        @endif 
        @if($vinvoice->vendor->country  && $model->c_country_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->country}}
        </td></tr>
        @endif 
        @if($vinvoice->vendor->email  && $model->c_email_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->email}}
        </td></tr>
        @endif 
        
      </table>
    </td>
    <td rowspan="2" style="font-size:200%;"><?php echo str_repeat('<br>',$model->title_sp);?>{!!$model->invoice_title!!}</td>
    <td style="text-align:right"> <img alt="CompanyLogo" src="{{asset('imgs/logo1.png')}}" width="350px" height="200px" /> </td>
  </tr>
  <tr>
    <td>{{$model->wto_client}}<br>
    <table border="0">
        
        @if($vinvoice->company->name && $model->cl_name_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->name}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->company->address && $model->cl_address_v==1)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->address}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->company->phone  && $model->cl_phone_v==1)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->phone}}
          </td></tr>
        @endif 
        @if($vinvoice->company->country  && $model->cl_country_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->country}}
        </td></tr>
        @endif 
        @if($vinvoice->company->email  && $model->cl_email_v==1)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->email}}
        </td></tr>
        @endif 
        
      </table>
    </td>
    <td>
      <table border="0">
        <tr><td>{{$model->winvoice_number}}</td><td>{{$vinvoice->inv_number}}</td></tr>
        <tr><td>{{$model->wfrom_date}}</td><td>{{$vinvoice->invoice_date}}</td></tr>
        <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
      </table>


    </td>

  </tr>
</table>
<?php echo str_repeat('<br>',$model->sp_gt_note)?>
<p style="text-align:center;">
{{$model->text1}} From 
    @if($vinvoice->type=='week')Mon {{$vinvoice->from_date}}
     till Sun {{$vinvoice->to_date}}
    @else
    <?php echo date('F-Y',strtotime($vinvoice->from_date));?> till  
    <?php echo date('F-Y',strtotime($vinvoice->to_date));?>
    @endif</p>
<table border="0" cellspacing="2" cellpadding="2">
  <thead>
    <tr style="border-top:solid 2px #ff0000;background-color:{{$model->color_sheme}};color:#FFFFFF;text-align:center;">
      <th align="{{$model->item_code_alignment != null?$model->item_code_alignment:center}}" style="border-bottom:2px solid #ff0000;">{{$model->witem_code}}</th>
      <th align="{{$model->description_alignment != null?$model->description_alignment:center}}" style="border-bottom:2px solid #ff0000;">{{$model->wdescription}}</th>
      <th align="{{$model->quantity_alignment != null?$model->quantity_alignment:center}}" style="border-bottom:2px solid #ff0000;">{{$model->wquantity}}</th>
      <th align="{{$model->price_alignment != null?$model->price_alignment:center}}" style="border-bottom:2px solid #ff0000;">{{$model->wprice}}</th>
      <th align="{{$model->amount_alignment != null?$model->amount_alignment:center}}" style="border-bottom:2px solid #ff0000;">{{$model->wamount}}</th>
    </tr>
  </thead>
  <tbody>
    
    <?php $total=0;$q=0;?>
    @foreach($vinvoice->invoice_items as $item)
      <tr>
        <td align="{{$model->item_code_alignment_d != null?$model->item_code_alignment_d:center}}">{{$item->item->name}}</td>
        <td align="{{$model->description_alignment_d != null?$model->description_alignment_d:center}}">{{$item->item->description}}</td>
        <td align="{{$model->quantity_alignment_d != null?$model->quantity_alignment_d:center}}">{{$item->quantity}}</td>
        <td align="{{$model->price_alignment_d != null?$model->price_alignment_d:center}}">{{$item->item->rate}}</td>
        <td align="{{$model->amount_alignment_d != null?$model->amount_alignment_d:center}}">{{$item->item->rate*$item->quantity}}</td>
        <?php $total+=$item->item->rate*$item->quantity;$q+=$item->quantity;?>
      </tr>
    @endforeach
    <tr>
      <td colspan="5" style="border-bottom:2px solid {{$model->color_border}};">&nbsp;</td>
    </tr>
    <tr style="border-top:solid 2px #0695AD;">
      <td colspan="2">&nbsp;</td>
      <td style="text-align:center">{{$model->wtotal_quantity}}</td>
      <td style="color:white;background-color:{{$model->color_sheme}};text-align:{{$model->wtotal_alignment}}">Total : </td>
      <td style="text-align:{{$model->total_alignment}}">{{$total}}</td>
    </tr>
  </tbody>
  
</table>
<p style="text-align:center;border-bottom:2px solid {{$model->color_border}};">{!!$model->wnote!!}</p>
<?php echo str_repeat('<br>',$model->sp_note_top)?>


<table Style="background-color:#FFFFFF;" border=0>

  @if($model->note1_v==1)<tr><td> {!!$model->note1!!} </td></tr>@endif
</table>
<table>
  <?php echo str_repeat('<tr><td ></td></tr>',$model->sp_note_footer);?>
</table>
<p style="text-align:{{$model->footer_alignment != null?$model->footer_alignment:'center'}};border-top:2px solid {{$model->color_border}};"><h5>{{$model->footer}}</h5> </p>
          
