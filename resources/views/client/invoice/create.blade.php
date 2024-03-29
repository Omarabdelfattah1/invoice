@extends('layouts.home')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add new Invoice</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
        
        <form action="{{route('invoices.store')}}" method="post">
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
                        <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th align="left">Select Client</th>
                    <td>
                      <select class="form-control" name="client_id">
                        @foreach($clients as $client)
                          <option value="{{$client->id}}">{{$client->name}}</option>
                        @endforeach
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th align="left">Invoice Date</th>
                    <td>
                      <input type="text" class="form-control datetimepicker" onchange="getDateData(1)" id="datetime1" name="invoice_date">
                    </td>
                  </tr>
                  <tr>
                    <th align="left">Invoice Type</th>
                    <td>
                      <select name="type" id="inv_type">
                        <option value="week" selected>Weekly</option>
                        <option value="month">Monthly</option>
                      </select>
                    </td>
                  </tr>
                  <tr id="weekly" > 
                    <th align="left">From Date :</th>
                    <td>
                      <input class="form-control datetimepicker" type="text" onchange="getDateData(0)" id="datetime0" value="" name="from_date_w" placeholder="Select From date">
                    </td>
                  
                    <th align="left">To Date :</th>
                    <td>
                      <input class="form-control datetimepicker" onchange="getDateData(2)" id="datetime2" type="text" value="" name="to_date_w" placeholder="Select to date">
                    </td>
                  </tr>
                  <tr id="monthly" style="display:none;"> 
                    <th align="left">From Date :</th>
                    <td>
                      <input class="form-control" type="month" name="from_date_m" placeholder="Select From date">
                    </td>
                    <th align="left">To Date :</th>
                    <td>
                      <input class="form-control" type="month" name="to_date_m" placeholder="Select to date">
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
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="customSwitch1">
                  <label class="custom-control-label" for="customSwitch1">Recurring</label>
                </div>
              </div>
              <div id="showRec" style="display:none;" class="row">
                <div class="col form-group">
                  <label for="how-often"><small class="form-text text-muted">How often?</small></label>
                  <select id="how-often" class="form-control form-control-sm" name="recurring">
                    <option value="none">No Recurring</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
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
    // if($('#customSwitch1').checked){
    //   $("#showRec").show()
    // }
    $('#customSwitch1').click(function() {
      $("#showRec").toggle(this.checked);
    });
</script>
@endsection