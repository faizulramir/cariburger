@extends('layouts.master')

@section('content')
    <div class="container" style="padding-bottom: 100px;">
        <div class="row" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
            <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
        </div>
        <div class="card" >
            <div class="card-body">
                <h5 class="card-title"><b>Add Shop</b></h5>
                <form action="#" method="POST" id="createStallForm">
                    @csrf
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Stall Name <span style="color: red;">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" maxlength="50" placeholder="Kedai Burger Abe John" value="{{old('name')}}" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>State <span style="color: red;">*</span></label>
                            <input type="text" name="state" id="state" class="form-control" maxlength="50" placeholder="Selangor" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>City <span style="color: red;">*</span></label>
                            <input type="text" name="city" id="city" class="form-control" maxlength="50" placeholder="Shah Alam" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Operation Hour</label>
                            <input type="text" name="operation_time" id="operation_time" maxlength="50" class="form-control" placeholder="8AM-10PM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Operation Day</label>
                            <input type="text" name="operation_day" id="operation_day" maxlength="50" class="form-control" placeholder="Isnin - Khamis">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Landmark</label>
                            <input type="text" name="landmark" id="landmark" class="form-control" maxlength="50" placeholder="Bersebelahan Pak Gembus">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Waze URL <a href="{{ route('map.index', ['from' => url()->current()]) }}">Get URL Here</a></label>
                            <input type="text" name="waze_url" id="waze_url" class="form-control" placeholder="Click on 'Get URL Here'" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Creator Name</label>
                            <input type="text" name="creator_name" id="creator_name" class="form-control" placeholder="Abe John">
                        </div>
                    </div>
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">
                    <div class="row">
                        <div class="col-12" style="text-align: center;">
                            <button type="button" class="btn btn-success" onclick="submitCreate()">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('modals.openWaze')
@endsection

@section('script')
    <script>
        init_values();
        
        function save_data_to_localstorage(input_id) {
            const input_val = document.getElementById(input_id).value;
            localStorage.setItem(input_id, input_val);
        }

        $('input:text').keyup(function(){
            save_data_to_localstorage($(this).attr('id'))
        });
        
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
        
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        function init_values() {
            const urlParams = getUrlParameter('latlng');
            if (urlParams)  {
                let params = urlParams.split(",")
                if (params[0] == '0') {
                    $('#lat').val('')
                    $('#lng').val('')
                    $('#waze_url').val('')
                } else {
                    let waze_url = `https://waze.com/ul?ll=${params[0]},${params[1]}&z=10`
                    $('#waze_url').val(waze_url)
                    $('#lat').val(params[0])
                    $('#lng').val(params[1])
                }
            }
            
            var inputs = document.getElementById('createStallForm').getElementsByTagName('input');

            for (const input of inputs){
                if (localStorage[$(input).attr('id')]) {
                    $(input).val(localStorage[$(input).attr('id')]);
                }
            }
        }

        function submitCreate() {
            var inputs = document.getElementById('createStallForm').getElementsByTagName('input');
            var data = new FormData();
            for (const input of inputs){
                data.append(input.name, input.value)
            }
            var url = '{{ route("create.post") }}';

            if ($('#name').val() == '' || $('#state').val() == '' || $('#city').val() == '') return;
            
            $.ajax({
                type:'post',
                url: url,
                data: data,
                cache       : false,
                contentType : false,
                processData : false,
                success:function(data) {
                    $('#createStallForm').find("input[type=text]").val("");
                    localStorage.clear();
                    alert('Success!');
                }
            });
        }
    </script>
@endsection