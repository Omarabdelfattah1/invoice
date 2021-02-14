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
        
        <form action="{{route('vinvoices.store')}}" method="post">
          @csrf
          <br>
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
                  <input type="text" class="form-control datetimepicker" onchange="getDateData(1)" id="datetime1" name="invoice_date" placeholder="Select Invoice date">
                </td>
              </tr>
              <tr> 
                <th align="left">From Date :</th>
                <td>
                  <input class="form-control datetimepicker" type="text" onchange="getDateData(0)" id="datetime0" name="from_date" placeholder="Select From date">
                </td>
              </tr>
              <tr> 
                <th align="left">To Date :</th>
                <td>
                  <input class="form-control datetimepicker" onchange="getDateData(2)" id="datetime2" type="text" name="to_date" placeholder="Select to date">
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
</script>
@endsection