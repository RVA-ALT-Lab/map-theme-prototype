
<?php

get_header(); ?>
    <h1>This is an</h1>
    <div class="point-list col-md-5">
                <ul>


                <?php if (have_posts()): ?>
                    <?php while(have_posts()): the_post(); ?>
                    <li class="point-tile">
                        <h4><?php the_title(); ?></h4>
                        <p><?php the_excerpt(); ?></p>
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