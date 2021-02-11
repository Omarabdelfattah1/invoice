@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add new Company</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
        <div class="col-sm-12">
        
        <form action="{{route('vinvoices.add_items',$vinvoice)}}" method="post">
          
          @csrf
          <br>
          <table border="0">
            <tbody>
              <tr>
                <td>Invoice Date: </td>
                <td>
                  <input class="form-control" type="text" name="inv_date" value="{{$vinvoice->invoice_date}}">
                </td>
              </tr>
              <tr>
                <td>Invoice Number: </td>
                <td>
                  <input class="form-control" type="text" name="invoice_id" value="{{$vinvoice->id}}">
                </td>
              </tr>
              <tr>
                <td>From Date: </td>
                <td>
                  <input class="form-control" type="text" name="date_from" value="{{$vinvoice->from_date}}">
                </td>
                <td>To Date: </td>
                <td>
                  <input class="form-control" type="text" name="inv_date2" value="{{$vinvoice->to_date}}">
                </td>
              </tr>
              <tr>
                <td>
                  <b>Company :</b>
                </td>
                <td>
                  <select class="form-control" name="company_id">
                  @foreach($companies as $company)
                  
                    <option value="{{$company->id}}" {{ $company->id == $vinvoice->company_id ? 'selected' : '' }}>{{$company->name}}</option>
                  @endforeach
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
          <h3>Invoice Items List</h3>
          <table border="1" class="table table-bordered table-striped dataTable dtr-inline">
            <thead>
                <tr>
                  <th>Id</th>
                  <th>Item Name</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>-</th>
                  <th>-</th>
                </tr>
            </thead>
            <tbody>
            <?php $total=0;?>
              @foreach($vinvoice->invoice_items as $item)
              <tr>
                <td>{{$item->item->id}}</td>
                <td>{{$item->item->name}}</td>
                <td>{{$item->item->description}}</td>
                <td align="center">{{$item->quantity}}</td>
                <td align="right">{{$item->item->rate}}</td>
                <td align="right">{{$item->quantity*$item->item->rate}}</td>
                <td><a href="{{url('invoices/'.$vinvoice->id.'/'.$item->id.'/edit_item')}}"><i class="fas fa-trash"></i></a></td>
                <td><a href="{{url('invoices/'.$vinvoice->id.'/'.$item->id.'/delete_item')}}"><i class="fas fa-edit"></i></a></td>
                <?php $total+=$item->quantity*$item->item->rate;?>
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
          </form>
          <form method="post" action="{{url('invoices/'.$vinvoice->id.'/'.$item->id.'/update_item')}}">
            @csrf
          <table border="0">
            <tbody>
              <tr>
                <th align="left">Select Item</th>
                <td>
                  <select class="form-control" required id="invoice_item_select" name="item_id" data-select2-id="invoice_item_select" tabindex="-1" class="select2-hidden-accessible" aria-hidden="true">
                    @foreach($items as $item)
                    <option value="{{$item->id}}" {{$item->id== $item1->id?'selected':''}}>{{$item->name}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                  <th align="left">Quantity</th>
                  <td><input class="form-control" type="text" value='{{$item1->quantity}}' name="quantity" required></td>
              </tr>
              <tr>
                <th colspan="2">
                  <input class="btn btn-primary" class="btn btn-primary" type="submit" value="Update Item" name="saveitem">
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