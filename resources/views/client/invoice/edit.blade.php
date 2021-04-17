@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Company</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{route('invoices.update',$invoice)}}" method="post">
          @method('put')
          @csrf
          <br>
          <div class="row">
            <div class="col-8">
              <table border="0">
                <tbody>
                  <tr>
                    <th align="left">Select Company</th>
                    <td>
                      <select class="form-control" name="company_id">
                        @foreach($companies as $company)
                        <option value="{{$company->id}}" {{$company->id == $invoice->company_id?'selected':''}}>{{$company->name}}</option>
                        @endforeach
                    
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th align="left">Select Client</th>
                    <td>
                      <select class="form-control" name="client_id">
                        @foreach($clients as $client)
                          <option value="{{$client->id}}" {{$client->id == $invoice->client_id?'selected':''}}>{{$client->name}}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>

                  <tr>
                    <th align="left">Invoice Date</th>
                    <td>
                      <input type="text" value="{{$invoice->invoice_date}}" class="form-control datetimepicker" onchange="getDateData(0)" id="datetime0" name="invoice_date" placeholder="Select Invoice date">
                    </td>
                  </tr>
                  <tr>
                    <th align="left">Invoice Type</th>
                    <td>
                      <select name="type" id="inv_type">
                        <option value="week" {{$invoice->type=='week'?'selected':''}}>Weekly</option>
                        <option value="month" {{$invoice->type=='month'?'selected':''}}>Monthly</option>
                      </select>
                    </td>
                  </tr>
                  @if($invoice->type=='week')
                  <tr id="weekly" > 
                  @else
                  <tr id="weekly" style="display:none;"> 
                  @endif  <th align="left">From Date :</th>
                    <td>
                      <input class="form-control datetimepicker" onchange="getDateData(2)" id="datetime2" value="{{$invoice->from_date}}" type="text"  name="from_date_w" placeholder="Select From date">
                    </td>
                  
                    <th align="left">To Date :</th>
                    <td>
                      <input class="form-control  datetimepicker" onchange="getDateData(1)" id="datetime1" value="{{$invoice->to_date}}" type="text" name="to_date_w" placeholder="Select to date">
                    </td>
                  </tr>
                  @if($invoice->type=='month')
                  <tr id="monthly" > 
                  @else
                  <tr id="monthly" style="display:none;"> 
                  @endif<th align="left">From Date :</th>
                    <td>
                      <input class="form-control" value="{{$invoice->from_date}}" type="month"  name="from_date_m" placeholder="Select From date">
                    </td>
                  
                    <th align="left">To Date :</th>
                    <td>
                      <input class="form-control" value="{{$invoice->to_date}}" type="month" name="to_date_m" placeholder="Select to date">
                    </td>
                  </tr>
                      
                  <tr>
                    <th colspan="2">
                      <input class="btn btn-primary" type="submit" value="Next" >
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-4">
              <div class="row">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php if($invoice->recurring != 'none'){ echo 'checked'; }?>>
                    <label class="custom-control-label" for="customSwitch1">Recurring</label>
                  </div>
                </div>
                <div id="showRec"  style="display:<?php if($invoice->recurring == 'none'){ echo 'none'; }?>" class="row">
                  <div class="col form-group">
                    <label for="how-often"><small class="form-text text-muted">How often?</small></label>
                    <select id="how-often" class="form-control form-control-sm" name="recurring">
                      <option value="none" {{$invoice->recurring=='none'?'selected':''}}>No Recurring</option>
                      <option value="weekly" {{$invoice->recurring=='weekly'?'selected':''}}>Weekly</option>
                      <option value="monthly" {{$invoice->recurring=='monthly'?'selected':''}}>Monthly</option>
                    </select>
                  </div>
                  <div class="col form-group">
                    <label for="how-many"><small class="form-text text-muted">How many?</small></label>
                    <input id="how-many" value="{{$invoice->howmany}}" name="howmany" class="form-control form-control-sm" type="number" min="0">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group">
                  <label for="background">Choose Watermark</label>
                  <select name="background" id="background" class="form-control form-control-sm">
                    <option>__Choose watermark__</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="paid">Paid</option>
                  </select>
                </div>
              </div>
              
            </div>
          </div>
          
        </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
@section('scripts')
<script type="text/javascript">
     function getDateData(id) {
            var x = document.getElementById("datetime" + id);
            //x.value = x.value.toUpperCase();
            if(x.value){
                if(x.value.includes("00:00:00")){
                    document.getElementById("datetime" + id).value = x.value.slice(0,10);
                }
            }
        }
    $(function () {
        $('.datetimepicker').datetimepicker({
                dateFormat:"dd-mm-yy",
                timeFormat: 'HH:mm:ss'
            }
        );
    });
    
    $('#inv_type').on('change', function() {
      if(this.value=='week'){
        $('#monthly').hide();
        $('#weekly').show();
      }
      if(this.value=='month'){
        $('#monthly').show();
        $('#weekly').hide();
      }
    });
    $('#customSwitch1').click(function() {
      $("#showRec").toggle(this.checked);
    });
    
</script>
@endsection