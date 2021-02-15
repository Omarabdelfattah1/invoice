@extends('layouts.home')
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Bank Form</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12">
          <form method="post" enctype="multipart/form-data" metho="post" action="{{route('banks.store')}}">
            @csrf
            
            <table border="0">
              <tbody>
                <tr> 
                  <th align="left">Update Date :</th>
                  <td>
                    <input class="form-control datetimepicker" onchange="getDateData(0)" type="text" id="datetime0" name="update_date" placeholder="Select to date" required="">
                    
                  </td>
                </tr>
                <tr>
                  <th align="left">Bank Name</th>
                  <td>
                    <textarea class="form-control" name="bank_name"></textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">Amount</th>
                  <td class="row">
                    <input class="col-10 form-control" id="amount" type="text" name="amount" value="">$
                  </td>
                </tr>
                <tr>
                  <th align="left">Exchange Rate</th>
                  <td class="row">
                    <input class="col-6 form-control" id="exrate" type="text" name="exchange_rate" value="">Select Currency
                    <select class="col-3 form-control" name="currency_id">
                      @foreach($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->ref}}</option>
                      @endforeach
                    </select>
                    <a href="{{route('currencies.index')}}">....</a>
                  </td>
                </tr>
                <tr>
                  <th align="left">Exchange Amount</th>
                  <td>
                    <input id="examount" class="form-control" type="text" name="exchange_amount" readonly="">
                  </td>
                </tr>
                <tr>
                  <th align="left">Local Amount</th>
                  <td>
                    <input type="text" class="form-control" name="local_amount" value="">
                  </td>
                </tr>
                <tr>
                  <th align="left">Comment</th>
                  <td>
                    <textarea class="form-control" name="comment"></textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">File Upload :</th>
                  <td class="row">
                    <input type="text" class="col-6 form-control" name="name_image"><input class="col-6 form-control" type="file" name="file">
                  </td>
                </tr>
                <tr>
                  <th colspan="2"><input type="submit" value="Save" name="submit2"></th>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

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
@endsection
