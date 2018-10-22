
<?php

get_header(); ?>
    <h1>This is an</h1>
    <div class="point-list col-md-5">
        <button class="btn btn-primary btn-block" id="toggleHeatmap">Activate Heatmap</button>
        <?php

        $queried_object = get_queried_object();
        $the_cat_id = $queried_object->term_id;


        ?>
        <input type="hidden" id="category-id" value="<?php echo $the_cat_id;?>">
                <ul>

                <?php if(isset(get_option('map_general_options')['hidden_work']) && !current_user_can('administrator') ): ?>

                <?php
                    $args = array(
                    	'posts_per_page' => -1,
                        'post_type' => 'map-point',
                        'author' => get_current_user_id(),
                        'tax_query' => array(
                        	array(
                        		'taxonomy' => 'map-point-category',
                        		'terms' => $the_cat_id
                        	)
                        )
                    );
                    $query = new WP_Query($args);
                ?>
                <?php if ($query->have_posts()): ?>
                        <?php while($query->have_posts()): $query->the_post(); ?>
                        <li class="point-tile">
                            <h4><?php the_title(); ?></h4>
                            <p><?php the_excerpt(); ?></p>
                            <input type="hidden" class="category-id" value="<?php echo $the_cat_id; ?>">
                            <button type="button" class="btn btn-default zoom-button" data-id="<?php echo get_the_ID(); ?>"><i class="fa fa-search"></i></button>
                            <a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary">Read More</a>
                        </li>
                    <?php endwhile;?>
                    <?php wp_reset_postdata();?>
                    <?php endif;?>

                <!-- Do Custom Query Here -->

                <?php else: ?>
                    <?php
                        $args = array(
                        	'posts_per_page' => -1,
                            'post_type' => 'map-point',
                            'tax_query' => array(
	                        	array(
	                        		'taxonomy' => 'map-point-category',
	                        		'terms' => $the_cat_id
	                        	)
	                        )
                        );
                        $query = new WP_Query($args);
                    ?>
                    <?php if (have_posts()): ?>
                        <?php while(have_posts()): the_post(); ?>
	                        <li class="point-tile">
	                            <h4><?php the_title(); ?></h4>
	                            <p><?php the_excerpt(); ?></p>
	                            <input type="hidden" class="category-id" value="<?php echo get_the_terms($post, 'map-point-category')[0]->term_id; ?>">
	                            <button type="button" class="btn btn-default zoom-button" data-id="<?php echo get_the_ID(); ?>"><i class="fa fa-search"></i></button>
	                            <a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary">Read More</a>
	                        </li>
                    	<?php endwhile;?>
                    <?php endif;?>
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