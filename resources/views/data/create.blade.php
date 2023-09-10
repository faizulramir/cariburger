@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
            <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
        </div>
        <div class="card" style="margin-bottom: 100px;">
            <div class="card-body">
                <h5 class="card-title"><b>Add Shop</b></h5>
                <form action="#" method="POST" id="createStallForm">
                    @csrf
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Stall Name <span style="color: red;">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" maxlength="50" placeholder="Kedai Burger Abe John" required>
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
                            <input type="text" name="district" id="district" class="form-control" maxlength="50" placeholder="Shah Alam" required>
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
                            <label>Waze URL <a href="javascript:void(0);" onclick="openModal()">(?)</a></label>
                            <input type="text" name="waze_url" id="waze_url" maxlength="50" class="form-control" placeholder="https://waze.com/ul/hw281wb131">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Creator Name</label>
                            <input type="text" name="creator_name" class="form-control" placeholder="Abe John">
                        </div>
                    </div>
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
    @include('scripts.openWazeModal')
    
    <script>
        function submitCreate() {
            var inputs = document.getElementById('createStallForm').getElementsByTagName('input');
            var data = new FormData();
            for (const input of inputs){
                data.append(input.name, input.value)
            }
            $.ajax({
                type:'post',
                url:'/cariburger/create/post',
                data: data,
                cache       : false,
                contentType : false,
                processData : false,
                success:function(data) {
                    $('#createStallForm').find("input[type=text]").val("");
                    alert('Success!');
                }
            });
        }
    </script>
@endsection