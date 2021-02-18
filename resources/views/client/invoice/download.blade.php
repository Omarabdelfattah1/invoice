
<table border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td>{{$model->wfrom_company}}
      <table border="0">
        <tr>
          <td>              
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->country}}
          </td>
        </tr>
        @if($invoice->company->address)
        <tr>
          <td> 
            <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->address}}
          </td>
        </tr>
        @endif 
        @if($invoice->company->phone)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->phone}}
          </td></tr>
        @endif 
        @if($invoice->company->country)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->country}}
        </td></tr>
        @endif 
        @if($invoice->company->email)
        <tr><td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->company->email}}
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
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->country}}
          </td>
        </tr>
        @if($invoice->client->address)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->address}}
          </td>
        </tr>
        @endif 
        @if($invoice->client->phone)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->phone}}
          </td>
        </tr>
        @endif 
        @if($invoice->client->country)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->country}}
          </td>
        </tr>
        @endif 
        @if($invoice->client->email)
        <tr>
          <td> 
          <?php echo str_repeat('&nbsp;',$model->spcr);?>{{$invoice->client->email}}
          </td>
        </tr>
        @endif 
      
      </table>
    </td>
    <td>
      <table border="0">
        <tr><td>{{$model->winvoice_number}}</td><td>{{$invoice->inv_number}}</td></tr>
        <tr><td>{{$model->wfrom_date}}</td><td>{{$invoice->from_date}}</td></tr>
        <tr><td>{{$model->wto_date}}</td><td>Due on Receipt</td></tr>
      </table>


    </td>

  </tr>
</table>
<p style="text-align:center;">{{$model->text1}} From Mon {{$invoice->from_date}} till Sun {{$invoice->to_date}}</p>

<table border="0" cellspacing="2" cellpadding="2">
  <thead>
    <tr style="background-color:#0695AD;color:#FFFFFF;text-align:center;">
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
    <tr>
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
<p style="text-align:center;border-top:2px solid #00CCCC;"><h5>{{$model->footer}}</h5> </p>
          
