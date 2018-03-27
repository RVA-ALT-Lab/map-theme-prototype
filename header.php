<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php the_title() ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="container-fluid">
        <div class="row site-wrapper">
            <div class="side-nav">
                <nav>
                    <ul>
                        <li>
                            <a href="<?php echo get_home_url();?>">
                            <i class="fa fa-3x fa-home"></i>
                            </br>Home
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/map';?>">
                            <i class="fa fa-3x fa-map"></i>
                            </br>Map
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/points';?>" id="openPoints">
                                <i class="fa fa-3x fa-map-signs"></i>
                                </br>Points
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo get_site_url(). '/add-point';?>">
                                <i class="fa fa-3x fa-plus"></i>
                                </br>Add
                            </a>
                        </li>
                        <hr>
                        <?php $color_array = array(
                            '#E57200',
                            '#FFCE00',
                            '#00B3BE',
                            '#8568BE',
                            '#275E37'

                        );
                        $increment = 0;
                        ?>
                        <?php $categories = get_terms(array('taxonomy' => 'map-point-category', 'hide_empty' => false)); ?>
                            <?php foreach($categories as $category): ?>
                            <li data-category="<?php echo $category->term_id; ?>" data-color="<?php echo isset($color_array[$increment]) ? $color_array[$increment] : 'purple'; ?>" >
                                <?php
                                    $site_url = get_option('siteurl');
                                    $cat_link = $site_url . '/map-point-category/' . $category->slug;
                                ?>
                                <a href="<?php echo $cat_link; ?>">
                                <i class="fa fa-2x fa-map-marker" style="color: <?php echo isset($color_array[$increment]) ? $color_array[$increment] : 'purple'; ?>;"></i>
                                </br><?php echo $category->name; ?>
                            </a></li>
                            <?php $increment++; ?>
                            <?php endforeach;?>
                    </ul>
                </nav>
            </div>