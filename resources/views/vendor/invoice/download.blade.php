
<table border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td>{{$model->wfrom_company}}
      <table border="0">
        <tr>
          <td>              
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->name}}
          </td>
        </tr>
        @if($vinvoice->vendor->address)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->address}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->vendor->phone)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->phone}}
          </td></tr>
        @endif 
        @if($vinvoice->vendor->country)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->vendor->country}}
        </td></tr>
        @endif 
        @if($vinvoice->vendor->email)
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
    <td>{{$model->wto_client}}
      <table border="0">
        <tr>
          <td>              
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->name}}
          </td>
        </tr>
        @if($vinvoice->company->address)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->address}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->company->phone)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->phone}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->company->country)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->country}}
          </td>
        </tr>
        @endif 
        @if($vinvoice->company->email)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$vinvoice->company->email}}
          </td>
        </tr>
        @endif 
      
      </table>
    </td>
    <td>
      <table border="0">
        <tr><td>{{$model->winvoice_number}}</td><td>{{$vinvoice->inv_number}}</td></tr>
        <tr><td>{{$model->wfrom_date}}</td><td>{{$vinvoice->from_date}}</td></tr>
        <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
      </table>


    </td>

  </tr>
</table>
<p style="text-align:center;">{{$model->text1}} From Mon {{$vinvoice->from_date}} till Sun {{$vinvoice->to_date}}</p>

<table border="0" cellspacing="2" cellpadding="2">
  <thead>
    <tr style="border-top:solid 2px #ff0000;background-color:#0695AD;color:#FFFFFF;text-align:center;">
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
      <td colspan="5" style="border-bottom:2px solid #00CCCC;">&nbsp;</td>
    </tr>
    <tr style="border-top:solid 2px #0695AD;">
      <td colspan="2">&nbsp;</td>
      <td style="text-align:center">{{$model->wtotal_quantity}}</td>
      <td style="text-align:right">Total : </td>
      <td style="text-align:right">{{$total}}</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td style="text-align:right">{{$model->woutstanding}}</td>
      <td  style="text-align:right">{{$model->routstanding}}</td>

    </tr>
    
    <tr>
      <td colspan="3">&nbsp;</td>
      <td style="text-align:right"> {{$model->wgrandtotal}}</td>
      <td style="text-align:right">{{$model->rgrandtotal}}</td>
    </tr>
  </tbody>
  
</table>
<?php echo str_repeat('<br>',$model->sp_gt_note)?>
<p style="text-align:center;border-bottom:2px solid #00CCCC;">{!!$model->wnote!!}</p>


<table Style="background-color:#FFFFFF;" border=0>
  <tr><td> {!!$model->note1!!} </td></tr>
  <tr><td> {!!$model->note2!!} </td></tr>
  <tr><td> {!!$model->note3!!} </td></tr>
  <tr><td> {!!$model->note4!!} </td></tr> 
</table>
<table>
  <?php echo str_repeat('<tr><td ></td></tr>',$model->sp_note_footer);?>
</table>
<p style="text-align:{{$model->footer_alignment != null?$model->footer_alignment:'center'}};border-top:2px solid #00CCCC;"><h5>{{$model->footer}}</h5> </p>
          
