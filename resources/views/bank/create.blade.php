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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table border="0" width="100%">
              <tbody>
                <tr> 
                  <th width="20%" align="left">Date :</th>
                  <td width="80%">
                    <input class="form-control datetimepicker" onchange="getDateData(0)" type="text" id="datetime0" name="date" placeholder="Select to date" required="">
                    
                  </td>
                </tr>
                <tr>
                  <th width="20%" align="left">Bank Name</th>
                  <td width="80%">
                    <textarea class="form-control" name="name" required></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left">Title</th>
                  <td width="80%">
                    <textarea class="form-control" name="title"></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left">City</th>
                  <td width="80%">
                    <textarea class="form-control" name="city"></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left">Country</th>
                  <td width="80%">
                    <textarea class="form-control" name="country" required></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left">Address</th>
                  <td width="80%">
                    <textarea class="form-control" name="address"></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left">Details</th>
                  <td width="80%">
                    <textarea class="form-control" name="details"></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left">Account</th>
                  <td width="80%">
                    <textarea class="form-control" name="account" required></textarea>
                    </td>
                </tr>
                <tr>
                  <th width="20%" align="left" >Note</th>
                  <td width="80%">
                    <textarea class="form-control" name="notes" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                   <th width="20%">Select Currency</th> 
                   <td width="80%">
                    <select class="form-control" name="currency">
                      @foreach($currencies as $currency)
                        <option value="{{$currency->ref}}">{{$currency->ref}}</option>
                      @endforeach
                    </select>
                    <a href="{{route('currencies.index')}}">....</a>
                  </td>
                </tr>
                <tr>
                  <th width="20%" colspan="2"><input type="submit" value="Save" name="submit2"></th>
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
