@extends('layouts.home')
@section('style')
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('content')
<div class="card">
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row card">
        <form name="form1" method="post" action="{{route('models.store')}}">
          @csrf
          <div class="card-header"><h2>Invoice Models Form </h2>
          <b>Model name :</b>
          <input class="form-control" type="text"  name="name">
          </div>

          <p align="center">Model Settings</p>
          <table class="card-body">
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
                                <textarea class="form-control" rows="1" name="wfrom_company"></textarea>
                              </th>
                              </tr>
                              <tr>
                                <th align="left" rowspan="5">Spaces:<input class="form-control" type="text" name="spcr" value="" size="2"></th>
                                <th align="left"> Name :</th>
                                <td>
                                <select class="form-control" name="c_name_v">;
                                  <option value="1">Show</option>
                                  <option value="0">Hide</option>	
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Address :</th>
                                <td>
                                <select class="form-control" name="c_adress_v">";
                                  <option value="1">Show</option>
                                  <option value="0">Hide</option>										</select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Country  :</th>
                                <td>
                                <select class="form-control" name="c_country_v">";
                                  <option value="1">Show</option>
                                  <option value="0">Hide</option>										</select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Tel  :</th>
                                <td>
                                <select class="form-control" name="c_tel_v">";
                                  <option value="1">Show</option>
                                  <option value="0">Hide</option>
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Email  :</th>
                                <td>
                                <select class="form-control" name="c_email_v">";
                                  <option value="1">Show</option>
                                  <option value="0">Hide</option>	
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
                                <th colspan="2" align="left">To Client :<br><textarea class="form-control" rows="1" name="wto_client"> </textarea></th>
                              </tr>
                              <tr>
                                <th align="left"> Name  :</th>
                                <td>
                                  <select class="form-control" name="cl_name_v">";
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Address  :</th>
                                <td>
                                  <select class="form-control" name="cl_adress_v">";
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Country  :</th>
                                <td>
                                  <select class="form-control" name="cl_country_v">";
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>	
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Tel  :</th>
                                <td>
                                  <select class="form-control" name="cl_tel_v">";
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <th align="left"> Email  :</th>
                                <td>
                                  <select class="form-control" name="cl_email_v">";
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
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
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        
                        </th>
                      </tr>
                      <tr>
                      <td><b>Title spaces</b>
                        <input class="form-control" type="text" name="title_sp" value="" size="2">
                      </td>
                    </tr>
                    <tr>
                      <th align="left">From Date :<br>
                        <input class="form-control" name="wfrom_date" type="datetime-local">
                        <select class="form-control" name="from_date_v">";
                          <option value="1">Show</option>
                          <option value="0">Hide</option>							
                        </select>
                      </th>
                    </tr>
                    <tr>
                      <th align="left">To Date :<br>
                        <input class="form-control" name="wto_date" type="datetime-local">
                        <select class="form-control" name="to_date_v">";
                          <option value="1">Show</option>
                                <option value="0">Hide</option>							</select>
                      </th>
                    </tr>

                    <tr>
                      <th align="left">Invoice Number :<br><textarea class="form-control" rows="1" name="winvoice_number"></textarea></th><td></td>
                    </tr>

                    <tr>
                      <td colspan="2"><b>Text :</b>(This invoice is for..)<br><textarea class="form-control" rows="1" cols="60" name="text1"></textarea><select class="form-control" name="text1_v">";
                          <option value="1">Show</option>
                                <option value="0">Hide</option>							</select>
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
                        <th><textarea class="form-control" rows="1" name="witem_code"></textarea></th>
                        <th><textarea class="form-control" rows="1" name="wdescription"></textarea></th>
                        <th><textarea class="form-control" rows="1" name="wquantity"></textarea></th>
                        <th><textarea class="form-control" rows="1" name="wprice"></textarea></th>
                        <th><textarea class="form-control" rows="1" name="wamount"></textarea></th>
                        
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
                        <textarea class="form-control" rows="1" name="woutstanding"></textarea></b></td>
                        <td></td>
                          
                          
                      </tr>
                      <tr>
                        <td colspan="4" align="right"><b>Grand total :<br><textarea class="form-control" rows="1" name="wgrandtotal"></textarea></b></td>
                        <td></td>
                            
                      </tr>
                    </tfoot>
                      
                    
                  </table>

                  <table border="0">
                    <tbody>
                    <tr>
                      <td colspan="3" align="center">Notes :<br>
                        <textarea class="form-control" cols="30" rows="1" name="wnote">															</textarea>
                      </td>
                    </tr>
                    <tr>
                      <th align="left">Notes Text:<br>
                      <textarea class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </th>
                      <td>
                        <select class="form-control" name="note1_v">
                          <option value="1">Show</option>
                          <option value="0">Hide</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                        <th align="left">Footer:<br>
                        <textarea class="form-control" cols="90" rows="1" name="footer">															</textarea>
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
                  <input class="form-control" type="text" name="pdf_mr" value="" size="2">
                </td>
                <td>Left:</td>
                <td>
                  <input class="form-control" type="text" name="pdf_ml" value="" size="2">
                </td>
                <td> Top:</td>
                <td>
                  <input class="form-control" type="text" name="pdf_mt" value="" size="2">
                </td>
              </tr>
              <tr>
                <th>Spaces</th>
                <td> Grand Total / Notes :</td>
                <td>
                  <input class="form-control" type="text" name="sp_gt_note" value="" size="2">
                </td>
                <td>notes / Footer:</td>
                <td>
                  <input class="form-control" type="text" name="sp_note_footer" value="" size="2">
                </td>
              </tr>
            </tbody>
          </table>
          Color Scheme :  <input class="form-control" type="color" name="color_scheme">
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