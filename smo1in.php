<?php
/*
Plugin Name: smo1in
Description: posts with most comments
Version: 1.0
Author: smo1in
*/

function smo1in_most_commented_posts()
{
  // start output buffering
  ob_start(); ?>

  <ul class="most-commented">
    <?php
    // Run WP_Query
    $query = new WP_Query('orderby=comment_count');

    //begin loop
    while ($query->have_posts()) : $query->the_post();
      global $post;
      if (0 < $post->comment_count) {
        the_post_thumbnail(array(200, 100)); ?>
        <p>
          <li>
            <div>
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
              <span class="post-date"><?php the_date(); ?></span>
              <span class="post-excerpt"><?php the_excerpt(); ?></span>
              <span class="comment-count"><?php comments_popup_link('No Comments;', '1 Comment', '% Comments'); ?></span>
            </div>
          </li>
        </p><?php
        }
      endwhile;
      ?>
  </ul>
  <?php

  // Turn off output buffering
  $output = ob_get_clean();

  //Return output 
  return $output;
};

// Create shortcode
add_shortcode('smo1in_most_commented', 'smo1in_most_commented_posts');

//Enable shortcode execution in text widgets
add_filter('widget_text', 'do_shortcode');


//creating widget for image rotate/zoom/overlay
class smo1inWidget extends WP_Widget
{

  function __construct(){
    parent::__construct(
      'smo1in_widget',
      'An image widget', 
      array('description' => 'widget for image rotate/zoom/overlay') 
    );
  }

  public function widget(){
    ?>
      <div class="zoom-effect-container">
        <div class="image-card">
          <img src="https://wallpapertag.com/wallpaper/middle/1/f/d/576948-gorgerous-huawei-wallpapers-2160x1440.jpg#.XPhM7JqzBo8.link" />
        </div>
      </div>
    <?php
  }
}

function my_styles_method() {
	wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom_script.css');
	
  $custom_css = "
  
  .zoom-effect-container {
    position: relative;
    width: 300px;
    height: 200px;
    margin: 0 auto;
    overflow: hidden;
    border: 1px solid black;
  }
  
  .image-card {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  
  .zoom-effect-container:hover .image-card:before {
    /* this is the overlay */
    position: absolute;
    z-index: 9;
    content: '';
    width: 100%;
    height: 100%;
    background: -moz-linear-gradient(top, rgba(224, 224, 224, 0) 0%, rgba(0, 250, 255, 0.65) 100%);
    /* FF3.6-15 */
    background: -webkit-linear-gradient(top, rgba(224, 224, 224, 0) 0%, rgba(0, 250, 255, 0.65) 100%);
    /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, rgba(224, 224, 224, 0) 0%, rgba(0, 250, 255, 0.65) 100%);
    /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00e0e0e0', endColorstr='#a600faff', GradientType=0);
    /* IE6-9 */
  }
  
  .image-card img {
    position: relative;
    z-index: 1;
    -webkit-transition: 300ms ease;
    transition: 300ms ease;
  }
  
  .zoom-effect-container:hover .image-card img {
    -webkit-transform: scale(1.2);
    transform: scale(1.2) rotate(30deg);
  }
  
  ";

	wp_add_inline_style( 'custom-style', $custom_css );
}


function smo1in_widget_load()
{
  register_widget('smo1inWidget');
}


add_action('widgets_init', 'smo1in_widget_load');
add_action( 'wp_enqueue_scripts', 'my_styles_method' );
