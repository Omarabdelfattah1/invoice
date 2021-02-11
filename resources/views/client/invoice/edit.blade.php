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
                  <input type="datetime-local" value="{{$invoice->invoice_date->format('Y.m.d H:i:s')}}" class="form-control" name="invoice_date" placeholder="Select Invoice date">
                </td>
              </tr>
              <tr> 
                <th align="left">From Date :</th>
                <td>
                  <input class="form-control "value="{{$invoice->from_date->format('Y.m.d H:i:s')}}" type="datetime-local"  name="from_date" placeholder="Select From date">
                </td>
              </tr>
              <tr> 
                <th align="left">To Date :</th>
                <td>
                  <input class="form-control" value="{{$invoice->to_date->format('Y.m.d H:i:s')}}" type="datetime-local" name="to_date" placeholder="Select to date">
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