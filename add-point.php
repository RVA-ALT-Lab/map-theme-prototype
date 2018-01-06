
<?php
/*
Template Name: Add Point
**/

get_header(); ?>

            <div class="map">
                <div class="row map-ui-row">
                    <div class="col-4"></div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" data-toggle="modal" data-target="#pointSubmitModal" class="btn btn-block btn-primary"><i class="fa fa-lg fa-plus"></i> Add Map Point</button>
                                <button type="button" class="btn btn-block btn-secondary stop-geolocation">Stop Geolocation</button>
                                <button type="button" class="btn btn-block btn-success start-geolocation" style="display: none;">Start Geolocation</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="map">

                </div>
            </div>

        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="pointSubmitModal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Map Point</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                <?php if(is_user_logged_in()): ?>
                    <p>Enter some details about the point you want to capture. All of this info is optional, and you can edit it on the backend later. The logitude and latitude of your current position will be automatically logged when you click submit.</p>

                  <form action="" enctype="multipart/form-data" method="POST">
                    <?php wp_nonce_field('submit_map_point', 'map_point_nonce_field'); ?>
                    <input type="hidden" name="new_point_submitted" value="true">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Point Title</label>
                        <input type="text" name="point_title" class="form-control" id="exampleFormControlInput1">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Category</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="point_category">
                            <?php $categories = get_terms(array('taxonomy' => 'map-point-category', 'hide_empty' => false)); ?>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Point Description</label>
                        <textarea class="form-control" name="point_description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fileInput">Image</label>
                        <input type="file" name="point-image" class="form-control-file" id="fileInput">
                    </div>
                    <div class="form-group hidden">
                        <input type="text" name="latitude" class="form-control" id="latitude">
                    </div>
                    <div class="form-group hidden">
                        <input type="text" name="longitude" class="form-control" id="longitude">
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </form>
                <?php else: ?>
                <p>You need to be logged in to submit a point to the map.</p>
                <?php endif; ?>


                </div>
              </div>
            </div>
    </div>
    <?php get_footer(); ?>