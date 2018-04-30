<?php get_header(); ?>

            <div class="map">

                <div id="map">
                <div class="container full-page">
                    <div class="row">
                    <div class="col-lg-12">
                        <?php if(have_posts()): while(have_posts()): the_post(); ?>
                        <?php $the_content = the_content();
                        echo $the_content; ?>
                        <?php endwhile; endif; ?>
                    </div>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>


<?php get_footer(); ?>