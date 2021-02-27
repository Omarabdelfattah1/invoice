@extends('layouts.home')
@section('header','Client Form')
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
          <form method="post" action="{{route('banks.update',$bank)}}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <table border="0">
              <tbody>
                <tr> 
                  <th align="left">Date :</th>
                  <td>
                    <input value="{{$bank->date}}" class="form-control datetimepicker" onchange="getDateData(0)" type="text" id="datetime0" name="date" placeholder="Select to date" required="">
                    
                  </td>
                </tr>
                <tr>
                  <th align="left">Bank Name</th>
                  <td>
                    <textarea class="form-control" name="name">{{$bank->name}}</textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">City</th>
                  <td>
                    <textarea class="form-control" name="city">{{$bank->city}}</textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">Country</th>
                  <td>
                    <textarea class="form-control" name="country">{{$bank->country}}</textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">Address</th>
                  <td>
                    <textarea class="form-control" name="address">{{$bank->address}}</textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">Details</th>
                  <td>
                    <textarea class="form-control" name="details">{{$bank->details}}</textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">Account</th>
                  <td>
                    <textarea class="form-control" name="account">{{$bank->account}}</textarea>
                    </td>
                </tr>
                <tr>
                  <th align="left">Note</th>
                  <td>
                    <textarea class="form-control" name="notes">{{$bank->notes}}</textarea>
                    </td>
                </tr>
                <tr>
                   <th>Select Currency</th> 
                   <td>
                    <select class="form-control" name="currency">
                      @foreach($currencies as $currency)
                        <option value="{{$currency->ref}}"{{$bank->currency==$currency->ref?'selected':''}}>{{$currency->ref}}</option>
                      @endforeach
                    </select>
                    <a href="{{route('currencies.index')}}">....</a>
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