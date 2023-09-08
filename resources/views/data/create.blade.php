@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
            <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
        </div>
        <div class="card" style="margin-bottom: 100px;">
            <div class="card-body">
                <h5 class="card-title"><b>Add Shop</b></h5>
                <form action="{{ route('create.post') }}" method="POST">
                    @csrf
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Stall Name <span style="color: red;">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Kedai Burger Abe John" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>State <span style="color: red;">*</span></label>
                            <input type="text" name="state" class="form-control" placeholder="Selangor" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>District <span style="color: red;">*</span></label>
                            <input type="text" name="district" class="form-control" placeholder="Shah Alam" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Operation Hour</label>
                            <input type="text" name="operation_time" class="form-control" placeholder="8AM-10PM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Operation Day</label>
                            <input type="text" name="operation_day" class="form-control" placeholder="Isnin - Khamis">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Landmark</label>
                            <input type="text" name="landmark" class="form-control" placeholder="Bersebelahan Pak Gembus">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Waze URL <a href="javascript:void(0);" onclick="openModal()">(?)</a></label>
                            <input type="text" name="waze_url" class="form-control" placeholder="https://waze.com/ul/hw281wb131">
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
                            <button type="submit" class="btn btn-success">Submit</button>
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
@endsection