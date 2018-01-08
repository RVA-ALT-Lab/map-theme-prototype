<?php
/*
Template Name: Points List
**/

get_header(); ?>
            <div class="point-list col-md-5">
                <ul>

                <?php
                $args = array();
                $point_query = new WP_Query(
                    array(
                        'post_type' => 'map-point',
                        'posts_per_page' => -1
                    )
                );

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