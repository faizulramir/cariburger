
<div class="modal fade" id="reviewSubmit" tabindex="-1" role="dialog" aria-labelledby="reviewSubmitTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Submit review for <span id="reviewSubmitTitle"></span></h5>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" id="reviewSubmitForm">
                    @csrf
                    <input type="hidden" id="r_return" name="r_return">
                    <input type="hidden" id="id" name="id">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Reviewer Name <span style="color: red;">*</span></label>
                            <input type="text" name="r_name" id="r_name" class="form-control" maxlength="50" placeholder="Abe John" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Item Bought <span style="color: red;">*</span></label>
                            <input type="text" name="r_item" id="r_item" class="form-control" maxlength="50" placeholder="Burger Daging" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                            <label>Review <span style="color: red;">*</span></label>
                            <textarea name="r_review" id="r_review" cols="30" class="form-control" placeholder="Tasty" maxlength="200" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelReviewSubmit">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitReview()">Submit Review</button>

            </div>
        </div>
    </div>
</div>

<script>
    function submitReview() {
        if ($('#r_name').val() && $('#r_item').val() && $('#r_review').val())  {
            if (confirm('Submitted review cannot be edited, continue?')) {
                var data = new FormData();
                data.append('r_name', $('#r_name').val())
                data.append('id', $('#id').val())
                data.append('r_item', $('#r_item').val())
                data.append('r_review', $('#r_review').val())
                data.append('r_ts', Date.now())
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
                        localStorage.clear();
                        alert('Success!');
                        window.location.href = '{{url()->current()}}' + '/?city=' + city;
                    }
                });
            } else {
                return;
            }
        } else {
            alert('Please fill in all the required input!');
        }
    }
</script>