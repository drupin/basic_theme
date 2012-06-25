<?php

function basic_scripts() {
  // wp_enqueue_style('basic_bootstrap_style', get_template_directory_uri() . '/css/bootstrap.css', false, null);
//   
  wp_enqueue_style('global', get_template_directory_uri() . '/global.css', false, null);
//   
  // wp_enqueue_style('custom', get_template_directory_uri() . '/css/custom.css', false, null);
//   
  // wp_enqueue_style('sass', get_template_directory_uri() . '/sass/style.css', false, null);
// 
  // if (current_theme_supports('bootstrap-responsive')) {
    // wp_enqueue_style('basic_bootstrap_responsive_style', get_template_directory_uri() . '/css/bootstrap-responsive.css', array('basic_bootstrap_style'), null);
  // }

  // If you're not using Bootstrap, include H5BP's main.css:
  // wp_enqueue_style('basic_style', '/css/main.css', false, null);

  wp_enqueue_style('basic_app_style', get_template_directory_uri() . '/css/app.css', false, null);

  if (!is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', '', '', false);
  }

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_register_script('basic_plugins', get_template_directory_uri() . '/js/plugins.js', false, null, false);
  wp_register_script('basic_main', get_template_directory_uri() . '/js/main.js', false, null, false);
  wp_enqueue_script('basic_plugins');
  wp_enqueue_script('basic_main');
}

add_action('wp_enqueue_scripts', 'basic_scripts', 100);
