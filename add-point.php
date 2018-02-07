
<?php
/*
Template Name: Add Point
**/

if (isset($_POST['new_point_submitted']) && $_POST['new_point_submitted'] == 'true'){

        $nonce = $_POST['map_point_nonce_field'];

        if (
            wp_verify_nonce( $nonce, 'submit_map_point')
            && current_user_can('publish_posts')
            ){
                $point_title = $_POST['point_title'];
                $point_description = $_POST['point_description'];
                $point_category = array( (int)$_POST['point_category'] );
                $point_latitude = $_POST['latitude'];
                $point_longitude = $_POST['longitude'];


                $postarr = array(
                    'post_title' => $point_title,
                    'post_exceprt' => $point_description,
                    'post_type' => 'map-point',
                    'post_status' => 'publish',
                    'meta_input' => array(
                        'latitude' => $point_latitude,
                        'longitude' => $point_longitude,
                    )
                );

                $post_id = wp_insert_post($postarr);

                if ( isset($_FILES['point-image']) ){
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                    $attachment_id = media_handle_upload('point-image', $post_id);
                    if (!is_wp_error($attachment_id)){
                        set_post_thumbnail($post_id, $attachment_id);
                    }
                }

               wp_set_object_terms( $post_id, $point_category, 'map-point-category', true);


            }
    }

get_header(); ?>

            <div class="map">
                <div class="row map-ui-row">
                    <div class="col-4"></div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <button type="button" data-toggle="modal" data-target="#pointSubmitModal" class="btn btn-block btn-primary"><i class="fa fa-lg fa-plus"></i> Add <span class="hidden-sm">Map</span> Point</button>
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
                <a href="<?php echo get_option('siteurl').'/wp-admin'?>">Click here to login</a>
                <?php endif; ?>


                </div>
              </div>
            </div>
    </div>
    <?php get_footer(); ?>