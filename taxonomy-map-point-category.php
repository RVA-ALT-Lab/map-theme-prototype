
<?php

get_header(); ?>
    <h1>This is an</h1>
    <div class="point-list col-md-5">
        <input type="hidden" id="category-id" value="<?php get_queried_object()->term_id;?>">
                <ul>


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
                </ul>

            </div>
            <div class="map">

                <div id="map">

                </div>
            </div>

        </div>
    </div>
    <?php get_footer(); ?>