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
        <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <img src="{{asset('imgs/logo1.png')}}" height="240" width="240" alt="">
                    <small class="float-right">Inv Date:{{$vinvoice->invoice_date}}</small><br>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h4><b>From:</b></h4>
                  <address>
                    <strong>{{$vinvoice->company->name}}</strong><br>
                    {{$vinvoice->company->country}}<br>
                    @if($vinvoice->company->address)
                    {{$vinvoice->company->address}}<br>
                    @endif
                    @if($vinvoice->company->phone)
                    Phone: {{$vinvoice->company->phone}}<br>
                    @endif
                    @if($vinvoice->company->email)
                    Email: {{$vinvoice->company->email}}
                    @endif
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <h4><b>To:</b></h4>

                  <address>
                    <strong>{{$vinvoice->vendor->name}}</strong><br>
                    {{$vinvoice->vendor->country}}<br>
                    @if($vinvoice->vendor->address)
                    {{$vinvoice->vendor->address}}<br>
                    @endif
                    @if($vinvoice->vendor->phone)
                    Phone: {{$vinvoice->vendor->phone}}<br>
                    @endif
                    @if($vinvoice->vendor->email)
                    Email: {{$vinvoice->vendor->email}}
                    @endif
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                   <p ><b >INV #: </b>{{$vinvoice->inv_number}}</p>
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
                    @foreach($vinvoice->invoice_items as $item)
                    <tr>
                      <td>{{$item->item->name}}</td>
                      <td>{{$item->item->description}}</td>
                      <td>{{$item->quantity}}</td>
                      <td>{{$item->rate}}</td>
                      <td>{{$item->rate*$item->quantity}}</td>
                    </tr>
                    @endforeach
                    </tbody>
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