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
                            <a href="/">
                            <i class="fa fa-3x fa-home"></i>
                            </br>Home
                            </a>
                        </li>
                        <li>
                            <a href="/map">
                            <i class="fa fa-3x fa-map"></i>
                            </br>Map
                            </a>
                        </li>
                        <li>
                            <a href="/points" id="openPoints">
                                <i class="fa fa-3x fa-map-signs"></i>
                                </br>Points
                            </a>
                        </li>
                        <li>
                            <a href="/add-point">
                                <i class="fa fa-3x fa-plus"></i>
                                </br>Add
                            </a>
                        </li>
                        <hr>
                        <?php $categories = get_terms(array('taxonomy' => 'map-point-category', 'hide_empty' => false)); ?>
                            <?php foreach($categories as $category): ?>
                            <li>
                                <a href="/map-point-category/<?php echo $category->slug; ?>">
                                <i class="fa fa-3x fa-map-marker"></i>
                                </br><?php echo $category->name; ?>
                            </a></li>
                            <? endforeach;?>
                    </ul>
                </nav>
            </div>