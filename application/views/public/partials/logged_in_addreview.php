         <div class="modal fade" id="create_review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Product Review</h4>
                </div>
                <div class="modal-body">
                    <div class="stars">
                        <form id="review_form" action="<?= base_url(uri_string()); ?>" method="post">
                            <div class="form-group">
                                <textarea name="review_text" id="user_review" rows="20" cols="35" placeholder="Write your review here..."></textarea>
                            </div>
                            <div class="form-group">
                                <input checked value="5" class="star star-5" id="star-5" type="radio" name="star" />
                                <label class="star star-5" for="star-5"></label>
                                <input value="4" class="star star-4" id="star-4" type="radio" name="star" />
                                <label class="star star-4" for="star-4"></label>
                                <input value="3" class="star star-3" id="star-3" type="radio" name="star" />
                                <label class="star star-3" for="star-3"></label>
                                <input value="2" class="star star-2" id="star-2" type="radio" name="star" />
                                <label class="star star-2" for="star-2"></label>
                                <input value="1" class="star star-1" id="star-1" type="radio" name="star" />
                                <label class="star star-1" for="star-1"></label>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                <span id="message" style="color:red;"></span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" value="Publish" class="btn btn-primary">
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

 <li role="presentation" class="addReview review_btn"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add a Review</li>