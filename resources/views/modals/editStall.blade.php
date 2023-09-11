<div class="modal fade" id="modalEditStall" tabindex="-1" role="dialog" aria-labelledby="modalEditStallTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Stall</h5>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="editStallForm">
                    @csrf
                    <input type="hidden" id="editId" name="id" class="form-control">
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
                            <label>Waze URL <a href="" id="getUri">Get URL Here</a></label>
                            <input type="text" name="waze_url" id="waze_url" class="form-control" placeholder="Click on 'Get URL Here'" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">
                    <div class="row">
                        <div class="col-12" style="text-align: center;">
                            <button type="button" class="btn btn-success"  onclick="submitEdit()">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function submitEdit() {
        var inputs = document.getElementById('editStallForm').getElementsByTagName('input');
        var data = new FormData();
        var city = $('#city').val();
        for (const input of inputs){
            data.append(input.name, input.value)
        }
        var url = '{{ route("home.editStall") }}';
        
        $.ajax({
            type:'post',
            url: url,
            data: data,
            cache       : false,
            contentType : false,
            processData : false,
            success:function(data) {
                $('#modalEditStall').modal('hide');
                alert('Success!');
                window.location.href = '{{url()->current()}}' + '/?city=' + city;
            }
        });
    }
</script>