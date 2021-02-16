@extends('layouts.home')
@section('content')
<div class="card">
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
        <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <img src="{{asset('imgs/logo1.png')}}" height="240" width="240" alt="">
                    <small class="float-right">Inv Date:{{$invoice->invoice_date}}</small><br>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h4><b>From:</b></h4>
                  <address>
                    <strong>{{$invoice->client->name}}</strong><br>
                    {{$invoice->client->country}}<br>
                    @if($invoice->client->address)
                    {{$invoice->client->address}}<br>
                    @endif
                    @if($invoice->client->phone)
                    Phone: {{$invoice->client->phone}}<br>
                    @endif
                    @if($invoice->client->email)
                    Email: {{$invoice->client->email}}
                    @endif
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h4><b>To:</b></h4>

                  <address>
                    <strong>{{$invoice->company->name}}</strong><br>
                    {{$invoice->company->country}}<br>
                    @if($invoice->company->address)
                    {{$invoice->company->address}}<br>
                    @endif
                    @if($invoice->company->phone)
                    Phone: {{$invoice->company->phone}}<br>
                    @endif
                    @if($invoice->company->email)
                    Email: {{$invoice->company->email}}
                    @endif
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                   <p ><b >INV #: </b>{{$invoice->inv_number}}</p>
                </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Item Code</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total=0;?>
                    @foreach($invoice->invoice_items as $item)

                    <tr>
                      <td>{{$item->item->name}}</td>
                      <td>{{$item->item->description}}</td>
                      <td>{{$item->quantity}}</td>
                      <td>{{$item->item->rate}}</td>
                      <td>{{$item->item->rate*$item->quantity}}</td>
                      <?php $total+=$item->item->rate*$item->quantity?>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="5" align="center">Total</td>
                        <td align="right"><?php echo $total;?></td>
                        <td></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <div class="row no-print">
                <div class="col-12">
                <button onclick="window.print()" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                </div>
              </div>
            </div>
        
        </div>
      </div>
    </div>
  </div>
</div>
<script>
</script>
@endsection