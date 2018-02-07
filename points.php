<?php
/*
Template Name: Points List
**/

get_header(); ?>
            <div class="point-list col-md-5">
                <ul>

                <?php
                if (isset(get_option('map_general_options')['hidden_work']) && !current_user_can('administrator') ){
                    $args = array(
                        'author' => get_current_user_id(),
                        'post_type' => 'map-point',
                        'posts_per_page' => -1
                    );
                } else {
                    $args = array(
                        'post_type' => 'map-point',
                        'posts_per_page' => -1
                    );
                }

                $point_query = new WP_Query($args);

                ?>

                <?php if ($point_query->have_posts()): ?>
                    <?php while($point_query->have_posts()): $point_query->the_post(); ?>
                    <li class="point-tile">
                        <input type="hidden" class="point-id" value="<?php echo get_the_ID(); ?>">
                        <h4><?php the_title(); ?></h4>
                        <p><?php the_excerpt(); ?></p>
                        <button type="button" class="btn btn-default zoom-button" data-id="<?php echo get_the_ID(); ?>"><i class="fa fa-search"></i></button>
                        <a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary">Read More</a>
                    </li>
                <?php endwhile;?>
                <?php endif;?>
                </ul>

            </div>
            <div class="map">

                <div id="map">

                </div>
            </div>

        </div>
    </div>


<?php get_footer(); ?>