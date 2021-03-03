@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Item</h3>
  </div>

  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form action="{{route('vinvoics.update',$vinvoic)}}" method="post">
            @method('put')
            @csrf
            <br>
            <table border="0">
              <tbody>
                <tr>
                  <th align="left">Select Company</th>
                  <td>
                    <select class="form-control" name="company_id" required>
                      @foreach($companies as $company)
                      <option value="{{$company->id}}" {{$company->id == $vinvoic->company_id?'selected':''}}>{{$company->name}}</option>
                      @endforeach
                  
                    </select>
                  </td>
                </tr>
                <tr>
                  <th align="left">Select Client</th>
                  <td>
                    <select class="form-control" name="client_id" required>
                      @foreach($clients as $client)
                        <option value="{{$client->id}}" {{$client->id == $vinvoic->client_id?'selected':''}}>{{$client->name}}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <tr>
                <th align="left">Invoice Date</th>
                <td>
                  <input type="text" value="{{$vinvoic->invoice_date}}" class="form-control datetimepicker" onchange="getDateData(0)" id="datetime0" name="invoice_date" placeholder="Select Invoice date">
                </td>
              </tr>
              <tr>
                <th align="left">Invoice Type</th>
                <td>
                  <select name="type" id="inv_type">
                    <option value="week" {{$vinvoic->type=='week'?'selected':''}}>Weekly</option>
                    <option value="month" {{$vinvoic->type=='month'?'selected':''}}>Monthly</option>
                  </select>
                </td>
              </tr>
              @if($vinvoic->type=='week')
              <tr id="weekly" > 
              @else
              <tr id="weekly" style="display:none;"> 
              @endif  <th align="left">From Date :</th>
                <td>
                  <input class="form-control datetimepicker" onchange="getDateData(2)" id="datetime2" value="{{$vinvoic->from_date}}" type="text"  name="from_date_w" placeholder="Select From date">
                </td>
              
                <th align="left">To Date :</th>
                <td>
                  <input class="form-control  datetimepicker" onchange="getDateData(1)" id="datetime1" value="{{$vinvoic->to_date}}" type="text" name="to_date_w" placeholder="Select to date">
                </td>
              </tr>
              @if($vinvoic->type=='month')
              <tr id="monthly" > 
              @else
              <tr id="monthly" style="display:none;"> 
              @endif<th align="left">From Date :</th>
                <td>
                  <input class="form-control" value="{{$vinvoic->from_date}}" type="text"  name="from_date_m" placeholder="Select From date">
                </td>
              
                <th align="left">To Date :</th>
                <td>
                  <input class="form-control" value="{{$vinvoic->to_date}}" type="text" name="to_date_m" placeholder="Select to date">
                </td>
              </tr>
                  
                    
                <tr>
                  <th colspan="2">
                    <input class="btn btn-primary" type="submit" value="Next" >
                  </th>
                </tr>
              </tbody>
            </table>
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
</script>
@endsection