<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="reviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Review <span id="reviewTitle"></span> <span id="wrapperReviewBtn"></span></h5>
            </div>
            <div class="modal-body">
                <div id="wrapperReview"></div>
                <div id="page-content"></div>
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="Page navigation example">
                            <span id="reviewIndex"></span>
                            <ul id="pagReview" class="pagination justify-content-center">
                              {{-- <li class="page-item"><a class="page-link disabled" href="#">Previous</a></li>
                              <li class="page-item"><a class="page-link" href="#">1</a></li>
                              <li class="page-item"><a class="page-link disabled" href="#">Next</a></li> --}}
                            </ul>
                            
                        </nav>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeReview">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    $('#pagination-review').twbsPagination({
        totalPages: 100,
        visiblePages: 5,
        onPageClick: function (event, page) {
            getPaginateReview(page)
        }
    });
</script> --}}