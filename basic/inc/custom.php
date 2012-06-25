<?php

load_theme_textdomain('basic');
add_image_size( 'basictheme-thumb', 160, 120, true );

add_theme_support( 'custom-header' );
add_theme_support( 'custom-background' );

function basic_extra_sidebars() {
  // Register widgetized areas
  register_sidebar(array(
    'name' => __('Front1', 'basic'),
    'id' => 'sidebar-front1',
    'before_widget' => '<section id="%1$s" class="widget %2$s span4"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('Jumbotron', 'basic'),
    'id' => 'jumbotron',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h1>',
    'after_title' => '</h1>',
  ));
  register_sidebar(array(
    'name' => __('Front3', 'basic'),
    'id' => 'sidebar-front3',
    'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('header-cart', 'basic'),
    'id' => 'headercart',
    'before_widget' => '<section id="%1$s" class=" %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => __('front-slider', 'basic'),
    'id' => 'frontslider',
    'before_widget' => '<section id="%1$s" class=" %2$s"><div class="widget-inner">',
    'after_widget' => '</div></section><hr class="soften">',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}
add_action('widgets_init', 'basic_extra_sidebars');

function basic_upgrade_link() {
	global $blog_id;
	if ( current_user_can('edit_pages') ) {
		$content = '';
		$content .= '<div class="upgrade"><a class="btn" href="' . network_home_url('pro-site/?bid=');
		$content .= $blog_id;
		$content .= '">' . __('Upgrade your store', 'basic') . '</a></div>';
	} else {
		$content = '';
	}
	echo $content;
}

function fee_disable( $allow, $args ) {
	$disabled_post_ids = array( 604 );
	return $allow && !in_array( $args['post_id'], $disabled_post_ids );
}
add_filter('front_end_editor_allow_post', 'fee_disable', 10, 2);



register_widget('Basic_Jumbotron_Widget');
class Basic_Jumbotron_Widget extends WP_Widget {
  function Basic_Jumbotron_Widget() {
    $widget_ops = array('classname' => 'widget_basic_jumbotron', 'description' => __('Use this widget to add a jumbotron', 'basic'));
    $this->WP_Widget('widget_basic_jumbotron', __('Basic: jumbotron', 'basic'), $widget_ops);
    $this->alt_option_name = 'widget_basic_jumbotron';

    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('widget_basic_jumbotron', 'widget');

    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = null;
    }

    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    ob_start();
    extract($args, EXTR_SKIP);

    $title = apply_filters('widget_title', empty($instance['title']) ? __('', 'basic') : $instance['title'], $instance, $this->id_base);
    if (!isset($instance['maintext'])) { $instance['maintext'] = ''; }
    if (!isset($instance['link_text_white'])) { $instance['link_text_white'] = ''; }
    if (!isset($instance['link_target_white'])) { $instance['link_target_white'] = ''; }
    if (!isset($instance['link_text_blue'])) { $instance['link_text_blue'] = ''; }
    if (!isset($instance['link_target_blue'])) { $instance['link_target_blue'] = ''; }
    if (!isset($instance['link_text_green'])) { $instance['link_text_green'] = ''; }
    if (!isset($instance['link_target_green'])) { $instance['link_target_green'] = ''; }
    if (!isset($instance['link_text_red'])) { $instance['link_text_red'] = ''; }
    if (!isset($instance['link_target_red'])) { $instance['link_target_red'] = ''; }
    if (!isset($instance['link_text_black'])) { $instance['link_text_black'] = ''; }
    if (!isset($instance['link_target_black'])) { $instance['link_target_black'] = ''; }

    echo $before_widget;
    if ($title) {
      echo $before_title;
      echo $title;
      echo $after_title;
    }
  ?><div style="text-align: center;">
      <h2 style="font-weight: normal !important; text-align: center;"><?php echo $instance['maintext']; ?></h2><br>
      <?php if (!empty($instance['link_target_white'])) { ?><a class="btn btn-large" href="<?php echo $instance['link_target_white']; ?>"><?php echo $instance['link_text_white']; ?></a><?php } ?>
      <?php if (!empty($instance['link_target_blue'])) { ?><a class="btn btn-large btn-primary" href="<?php echo $instance['link_target_blue']; ?>"><?php echo $instance['link_text_blue']; ?></a><?php } ?>
      <?php if (!empty($instance['link_target_green'])) { ?><a class="btn btn-large btn-success" href="<?php echo $instance['link_target_green']; ?>"><?php echo $instance['link_text_green']; ?></a><?php } ?>
      <?php if (!empty($instance['link_target_red'])) { ?><a class="btn btn-large btn-danger" href="<?php echo $instance['link_target_red']; ?>"><?php echo $instance['link_text_red']; ?></a><?php } ?>
      <?php if (!empty($instance['link_target_black'])) { ?><a class="btn btn-large btn-inverse" href="<?php echo $instance['link_target_black']; ?>"><?php echo $instance['link_text_black']; ?></a><?php } ?>
     </div>
  <?php
    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_basic_jumbotron', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['maintext'] = strip_tags($new_instance['maintext']);
    $instance['link_text_white'] = strip_tags($new_instance['link_text_white']);
    $instance['link_target_white'] = strip_tags($new_instance['link_target_white']);
    $instance['link_text_blue'] = strip_tags($new_instance['link_text_blue']);
    $instance['link_target_blue'] = strip_tags($new_instance['link_target_blue']);
    $instance['link_text_green'] = strip_tags($new_instance['link_text_green']);
    $instance['link_target_green'] = strip_tags($new_instance['link_target_green']);
    $instance['link_text_red'] = strip_tags($new_instance['link_text_red']);
    $instance['link_target_red'] = strip_tags($new_instance['link_target_red']);
    $instance['link_text_black'] = strip_tags($new_instance['link_text_black']);
    $instance['link_target_black'] = strip_tags($new_instance['link_target_black']);
    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions['widget_basic_jumbotron'])) {
      delete_option('widget_basic_jumbotron');
    }

    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_basic_jumbotron', 'widget');
  }

  function form($instance) {
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $maintext = isset($instance['maintext']) ? esc_attr($instance['maintext']) : '';
    $link_text_blue = isset($instance['link_text_white']) ? esc_attr($instance['link_text_white']) : '';
    $link_target_blue = isset($instance['link_target_white']) ? esc_attr($instance['link_target_white']) : '';
    $link_text_blue = isset($instance['link_text_blue']) ? esc_attr($instance['link_text_blue']) : '';
    $link_target_blue = isset($instance['link_target_blue']) ? esc_attr($instance['link_target_blue']) : '';
    $link_text_blue = isset($instance['link_text_green']) ? esc_attr($instance['link_text_green']) : '';
    $link_target_blue = isset($instance['link_target_green']) ? esc_attr($instance['link_target_green']) : '';
    $link_text_blue = isset($instance['link_text_red']) ? esc_attr($instance['link_text_red']) : '';
    $link_target_blue = isset($instance['link_target_red']) ? esc_attr($instance['link_target_red']) : '';
    $link_text_blue = isset($instance['link_text_black']) ? esc_attr($instance['link_text_black']) : '';
    $link_target_blue = isset($instance['link_target_black']) ? esc_attr($instance['link_target_black']) : '';
  ?>
  <table class="table table table-striped table-bordered">
  	<tbody>
  	<tr>
  		<td colspan="4">
  			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title (optional):', 'basic'); ?></label>
  			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  		</td>
  	</tr>
  	<tr>
  		<td colspan="4">
  			<label for="<?php echo esc_attr($this->get_field_id('maintext')); ?>"><?php _e('Your Text', 'basic'); ?></label>
  			<input id="<?php echo esc_attr($this->get_field_id('maintext')); ?>" name="<?php echo esc_attr($this->get_field_name('maintext')); ?>" type="text" value="<?php echo esc_attr($maintext); ?>" />
  		</td>
  	</tr>
  	<tr>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_text_white')); ?>"><?php _e('White button Text:', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_text_white')); ?>" name="<?php echo esc_attr($this->get_field_name('link_text_white')); ?>" type="text" value="<?php echo esc_attr($link_text_white); ?>" /></td>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_target_white')); ?>"><?php _e('White Button Link', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_target_white')); ?>" name="<?php echo esc_attr($this->get_field_name('link_target_white')); ?>" type="text" value="<?php echo esc_attr($link_target_white); ?>" /></td>
  	</tr>
  	<tr>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_text_blue')); ?>"><?php _e('Blue button Text:', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_text_blue')); ?>" name="<?php echo esc_attr($this->get_field_name('link_text_blue')); ?>" type="text" value="<?php echo esc_attr($link_text_blue); ?>" /></td>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_target_blue')); ?>"><?php _e('Blue Button Link', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_target_blue')); ?>" name="<?php echo esc_attr($this->get_field_name('link_target_blue')); ?>" type="text" value="<?php echo esc_attr($link_target_blue); ?>" /></td>
  	</tr>
  	<tr>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_text_green')); ?>"><?php _e('Green button Text:', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_text_green')); ?>" name="<?php echo esc_attr($this->get_field_name('link_text_green')); ?>" type="text" value="<?php echo esc_attr($link_text_green); ?>" /></td>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_target_green')); ?>"><?php _e('Green Button Link', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_target_green')); ?>" name="<?php echo esc_attr($this->get_field_name('link_target_green')); ?>" type="text" value="<?php echo esc_attr($link_target_green); ?>" /></td>
  	</tr>
  	<tr>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_text_red')); ?>"><?php _e('Red button Text:', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_text_red')); ?>" name="<?php echo esc_attr($this->get_field_name('link_text_red')); ?>" type="text" value="<?php echo esc_attr($link_text_red); ?>" /></td>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_target_red')); ?>"><?php _e('Red Button Link', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_target_red')); ?>" name="<?php echo esc_attr($this->get_field_name('link_target_red')); ?>" type="text" value="<?php echo esc_attr($link_target_red); ?>" /></td>
  	</tr>
  	<tr>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_text_black')); ?>"><?php _e('Black button Text:', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_text_black')); ?>" name="<?php echo esc_attr($this->get_field_name('link_text_black')); ?>" type="text" value="<?php echo esc_attr($link_text_black); ?>" /></td>
  		<td><label for="<?php echo esc_attr($this->get_field_id('link_target_black')); ?>"><?php _e('Black Button Link', 'basic'); ?></label></td>
  		<td><input id="<?php echo esc_attr($this->get_field_id('link_target_black')); ?>" name="<?php echo esc_attr($this->get_field_name('link_target_black')); ?>" type="text" value="<?php echo esc_attr($link_target_black); ?>" /></td>
  	</tr>
  </tbody>
  </table>
  <?php
  }
}


function basic_breadcrumb() {
	require_once( TEMPLATEPATH . '/inc/breadcrumbs.php' );

	$templates = array(
		'before' => '<nav id="breadcrumb"><ul class="breadcrumb">',
		'after' => '</ul></nav>',
		'standard' => '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">%s</li>',
		'current' => '<li class="active">%s</li>',
		'link' => '<a href="%s" itemprop="url">%s</a>'
	);
	$options = array(
		'show_htfpt' => true
	);

	$breadcrumb = new Basic_Breadcrumb( $templates, $options );
}
