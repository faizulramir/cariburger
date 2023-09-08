<div class="modal fade" id="modalEditStall" tabindex="-1" role="dialog" aria-labelledby="modalEditStallTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Stall</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('home.editStall') }}" method="POST">
                    @csrf
                    <input type="hidden" id="editId" name="id" class="form-control">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Stall Name <span style="color: red;">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Kedai Burger Abe John" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>State <span style="color: red;">*</span></label>
                            <input type="text" name="state" id="state" class="form-control" placeholder="Selangor" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>District <span style="color: red;">*</span></label>
                            <input type="text" name="district" id="district" class="form-control" placeholder="Shah Alam" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Operation Hour</label>
                            <input type="text" name="operation_time" id="operation_time" class="form-control" placeholder="8AM-10PM">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Operation Day</label>
                            <input type="text" name="operation_day" id="operation_day" class="form-control" placeholder="Isnin - Khamis">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Landmark</label>
                            <input type="text" name="landmark" id="landmark" class="form-control" placeholder="Bersebelahan Pak Gembus">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Waze URL <a href="javascript:void(0);" onclick="openModal()">(?)</a></label>
                            <input type="text" name="waze_url" id="waze_url" class="form-control" placeholder="https://waze.com/ul/hw281wb131">
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
</div>

