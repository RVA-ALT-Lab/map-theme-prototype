<?php

get_header(); ?>

        <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <div class="main-post col-md-7">
            <div class="row">
                <div class="col-lg-12 post-content">
                    <input type="hidden" class="post-id" value="<?php echo get_the_ID();?>">
                    <h1><?php the_title(); ?></h1>
                    <h2><?php the_author(); ?></h2>
                    <?php $content = get_the_content(); echo $content; ?>
                    <?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>
                </div>
            </div>
        </div>
        <?php endwhile; endif; ?>

        <div class="map fixed-right">
            <div id="map">

            </div>
        </div>

        </div>
    </div>


<?php get_footer(); ?>