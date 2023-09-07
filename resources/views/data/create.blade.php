@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row" style="background: rgba(255,255,255,0.7); padding-top:10px;">
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

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">How to get waze URL</h5>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>Open waze app on your phone</li>
                        <li>Tap and hold on your desired location</li>
                        <li>Tap on "Send"</li>
                        <li>Tap on "Copy Link"</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function openModal() {
            $('#create').modal('show');
        }
    </script>
@endsection