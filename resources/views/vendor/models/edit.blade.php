@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('content')
<div class="card">
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row card" align="center">
        <form name="form1" method="post" action="{{route('vmodels.update',$vmodel)}}">
          @csrf
          @method('put')
          <div class="card-header" width="50%"><h2>Invoice Models Form </h2>
          <b>Model name :</b>
          <input  type="text"  name="name"  value="{{$vmodel->name}}">
          </div>

          <p align="center">Model Settings</p>
          <table align="center" class="card-body" >
            <tbody>
              <tr>
                <td>

                  <table border="0"> 
                    <tbody>
                      <tr>
                        <td>
                          <table border="0"> 
                            <tbody>
                              <tr>
                                <td>
                                </td>
                              </tr>
                              <th colspan="2" align="left">From Company :<br>
                                <textarea  rows="1" name="wfrom_company">{{$vmodel->wfrom_company}}</textarea>
                              </th>
                              </tr>
                              <tr>
                                <th align="left" rowspan="5">
                                  Spaces:<input  type="text" name="spcr" value="{{$vmodel->spcr}}" size="2">
                                </th>
                                <th align="left"> Name :</th>
                                <td>
                                <select name="c_name_v">
                                  <option value="1"{{$vmodel->c_name_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->c_name_v==0?'selected':''}}>Hide</option>	
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Address :</th>
                                <td>
                                <select name="c_adress_v">
                                  <option value="1"{{$vmodel->c_adress_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->c_adress_v==0?'selected':''}}>Hide</option>	
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Country  :</th>
                                <td>
                                <select name="c_country_v">
                                  <option value="1"{{$vmodel->c_country_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->c_country_v==0?'selected':''}}>Hide</option>	
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Tel  :</th>
                                <td>
                                <select name="c_tel_v">
                                  <option value="1"{{$vmodel->c_tel_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->c_tel_v==0?'selected':''}}>Hide</option>	
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Email  :</th>
                                <td>
                                <select name="c_email_v">
                                  <option value="1"{{$vmodel->c_email_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->c_email_v==0?'selected':''}}>Hide</option>		
                                </select>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                        </td>
                        <td>
                          <table border="0"> 
                            <tbody>
                              <tr>
                                <th colspan="2" align="left">To Client :<br><textarea  rows="1" name="wto_client">{{$vmodel->wto_client}} </textarea></th>
                              </tr>
                              <tr>
                                <th align="left"> Name  :</th>
                                <td>
                                  <select name="cl_name_v">
                                    <option value="1"{{$vmodel->cl_name_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->cl_name_v==0?'selected':''}}>Hide</option>	
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Address  :</th>
                                <td>
                                  <select name="cl_adress_v">
                                    <option value="1"{{$vmodel->cl_adress_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->cl_adress_v==0?'selected':''}}>Hide</option>	
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Country  :</th>
                                <td>
                                  <select name="cl_country_v">
                                    <option value="1"{{$vmodel->cl_country_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->cl_country_v==0?'selected':''}}>Hide</option>		
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Tel  :</th>
                                <td>
                                  <select name="cl_tel_v">
                                    <option value="1"{{$vmodel->cl_tel_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->cl_tel_v==0?'selected':''}}>Hide</option>	
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Email  :</th>
                                <td>
                                  <select name="cl_email_v">
                                    <option value="1"{{$vmodel->cl_email_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->cl_email_v==0?'selected':''}}>Hide</option>	
                                  </select>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <table border="0">
                    <tbody>
                      <tr>
                        <th align="left">Invoice Title :<br>
                          <textarea name="invoice_title" class="textarea" placeholder="Place some text here"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$vmodel->invoice_title}}</textarea>
                        
                        </th>
                      </tr>
                      <tr>
                      <td><b>Title spaces</b>
                        <input  type="text" name="title_sp" value="{{$vmodel->title_sp}}" size="2">
                      </td>
                    </tr>
                    <tr>
                      <th align="left">From Date :<br>
                        <input  name="wfrom_date" type="text" value="{{$vmodel->wfrom_date}}">
                        <select name="from_date_v">
                            <option value="1"{{$vmodel->from_date_v==1?'selected':''}}>Show</option>
                            <option value="0" {{$vmodel->from_date_v==0?'selected':''}}>Hide</option>						
                        </select>
                      </th>
                    </tr>
                    <tr>
                      <th align="left">To Date :<br>
                        <input value="{{$vmodel->wto_date}}"  name="wto_date" type="text">
                        <select name="to_date_v">
                            <option value="1"{{$vmodel->to_date_v==1?'selected':''}}>Show</option>
                                  <option value="0" {{$vmodel->to_date_v==0?'selected':''}}>Hide</option>						
                        </select>
                      </th>
                    </tr>

                    <tr>
                      <th align="left">Invoice Number :<br>
                        <textarea  rows="1" name="winvoice_number">{{$vmodel->winvoice_number}} </textarea>
                      </th>
                      <td></td>
                    </tr>

                    <tr>
                      <td colspan="2"><b>Text :</b>(This invoice is for..)<br>
                        <textarea  rows="1" cols="60" name="text1">{{$vmodel->text1}} </textarea>
                        <select name="text1_v">
                            <option value="1"{{$vmodel->text1_v==1?'selected':''}}>Show</option>
                            <option value="0" {{$vmodel->text1_v==0?'selected':''}}>Hide</option>						
                        </select>
                      </td>
                    </tr>

                    </tbody>
                  </table>
                  <br>

                  <table border="0" align="center">
                    <thead>
                      <tr bgcolor="silver">
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                      </tr>
                      <tr>
                        <th><textarea  rows="1" name="witem_code">{{$vmodel->witem_code}} </textarea></th>
                        <th><textarea  rows="1" name="wdescription">{{$vmodel->wdescription}} </textarea></th>
                        <th><textarea  rows="1" name="wquantity">{{$vmodel->wquantity}} </textarea></th>
                        <th><textarea  rows="1" name="wprice">{{$vmodel->wprice}} </textarea></th>
                        <th><textarea  rows="1" name="wamount">{{$vmodel->wamount}} </textarea></th>
                        
                      </tr>
                      <tr>
                        <td>
                          <select name="item_code_alignment" id="">
                            <option value="center" {{$vmodel->item_code_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->item_code_alignment=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->item_code_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="description_alignment" id="">
                            <option value="center" {{$vmodel->item_code_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->item_code_alignment=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->item_code_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="quantity_alignment" id="">
                            <option value="center" {{$vmodel->quantity_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->quantity_alignment=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->quantity_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="price_alignment" id="">
                            <option value="center" {{$vmodel->price_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->price_alignment=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->price_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="amount_alignment" id="">
                            <option value="center" {{$vmodel->amount_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->amount_alignment=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->amount_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                      </tr>
                      <tr bgcolor="silver">
                        <th>Item Code data</th>
                        <th>Description data</th>
                        <th>Quantity data</th>
                        <th>Price data</th>
                        <th>Amount data</th>
                      </tr>
                      <tr>
                        <td>
                          <select name="item_code_alignment_d" id="">
                            <option value="center" {{$vmodel->item_code_alignment_d=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->item_code_alignment_d=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->item_code_alignment_d=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="description_alignment_d" id="">
                            <option value="center" {{$vmodel->item_code_alignment_d=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->item_code_alignment_d=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->item_code_alignment_d=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="quantity_alignment_d" id="">
                            <option value="center" {{$vmodel->quantity_alignment_d=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->quantity_alignment_d=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->quantity_alignment_d=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="price_alignment_d" id="">
                            <option value="center" {{$vmodel->price_alignment_d=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->price_alignment_d=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->price_alignment_d=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                        <td>
                          <select name="amount_alignment_d" id="">
                            <option value="center" {{$vmodel->amount_alignment_d=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->amount_alignment_d=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->amount_alignment_d=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" align="right"></td>
                        <td>
                        <b></b>
                        </td>
                        <td>
                        </td>
                        </tr>
                        <tr>
                        <td colspan="4" align="right">
                          <b>Total</b>
                        </td>
                        <td>
                        </td>
                        
                          
                      </tr>
                      <tr>
                        <td colspan="4" align="right"><b>Outstanding :<br>
                        <textarea  rows="1" name="woutstanding">{{$vmodel->woutstanding}} </textarea></b></td>
                        <td>
                          <select name="wtotal_alignment" id="">
                            <option value="center" {{$vmodel->wtotal_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->wtotal_alignment=='left'?'selected':''}}>left</option>
                            <option value="right" {{$vmodel->wtotal_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                          
                          
                      </tr>
                      <tr>
                        <td colspan="4" align="right"><b>Grand total :<br>
                        <textarea  rows="1" name="wgrandtotal">{{$vmodel->wgrandtotal}} </textarea></b></td>
                        <td>
                        <select name="total_alignment" id="">
                            <option value="center" {{$vmodel->total_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->total_alignment=='left'?'selected':''}}>left</option>
                            <option value="right" {{$vmodel->wtotal_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </td>
                            
                      </tr>
                    </tfoot>
                  </table>

                  <table border="0">
                    <tbody>
                    <tr>
                      <td colspan="3" align="center">Notes :<br>
                        <textarea  cols="30" rows="1" name="wnote">{{$vmodel->wnote}} </textarea>
                      </td>
                    </tr>
                    <tr>
                      <th align="left">Notes Text:<br>
                      <textarea name="note1" class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$vmodel->note1}} </textarea>
                      </th>
                      <td>
                        <select name="note1_v">
                          <option value="1" {{$vmodel->note1_v==1?'selected':''}}>Show</option>
                          <option value="0" {{$vmodel->note1_v==0?'selected':''}}>Hide</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                        <th align="left">Footer:<br>
                        <textarea name="footer" cols="90" rows="1" name="footer">{{$vmodel->footer}} </textarea>
                        </th>
                        <th>
                          <select name="footer_alignment" id="">
                            <option value="center" {{$vmodel->footer_alignment=='center'?'selected':''}}>center</option>
                            <option value="left" {{$vmodel->footer_alignment=='left'?'selected':''}}>left</option>
                            <option value="right"  {{$vmodel->footer_alignment=='right'?'selected':''}}>right</option>
                          </select>
                        </th>
                      </tr>

                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>



          <table border="0" align="center">
            <tbody>
              <tr>
                <th align="left">PDF Margin</th>
                <td> Right:</td>
                <td>
                  <input  type="text" name="pdf_mr" value="{{$vmodel->pdf_mr}}" size="2">
                </td>
                <td>Left:</td>
                <td>
                  <input  type="text" name="pdf_ml" value="{{$vmodel->pdf_ml}}" size="2">
                </td>
                <td> Top:</td>
                <td>
                  <input  type="text" name="pdf_mt" value="{{$vmodel->pdf_mt}}" size="2">
                </td>
              </tr>
              <tr>
                <th>Spaces</th>
                <td> Grand Total / Notes :</td>
                <td>
                  <input  type="text" name="sp_gt_note" value="{{$vmodel->sp_gt_note}}" size="2">
                </td>
                <td>notes / Footer:</td>
                <td>
                  <input  type="text" name="sp_note_footer" value="{{$vmodel->sp_note_footer}}" size="2">
                </td>
              </tr>
            </tbody>
          </table>
          Color Scheme :  <input  type="color" name="color_sheme" value="{{$vmodel->color_sheme}}">
          <br>
          <input class="btn btn-primary" type="submit">
        </form>
      </div>
    </div>
  </div>
</div>


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