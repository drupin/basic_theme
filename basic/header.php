<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

  <?php if (current_theme_supports('bootstrap-responsive')) { ?><meta name="viewport" content="width=device-width, initial-scale=1.0"><?php } ?>

  <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.5.3.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.7.2.min.js"><\/script>')</script>

  <?php basic_head(); ?>
  <?php wp_head(); ?>

<script type="text/javascript" charset="utf-8">
jQuery(document).ready(function(){
	jQuery('.pagination a').live('click', function(e){
		e.preventDefault();
		var link = jQuery(this).attr('href');
		jQuery('#main').html('<?php _e('Please Wait...'); ?>');
		jQuery('#main').load(link+' #product-grid');
		$('html, body').animate({scrollTop:0}, 'slow');
	});
});
</script>

<?php 
	require_once( TEMPLATEPATH . '/inc/lessc.inc.php' );
	try {
		lessc::ccompile( TEMPLATEPATH . '/global.less', TEMPLATEPATH . '/global.css');
	} catch (exception $ex) {
		exit($ex->getMessage());
	}
?>

</head>

<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php basic_header_before(); ?>
  <?php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header', 'top-navbar');
    } else {
      get_template_part('templates/header', 'default');
    }
  ?>
  <?php basic_header_after(); ?>

  <?php basic_wrap_before(); ?>
  <div id="wrap" class="<?php echo WRAP_CLASSES; ?>" role="document">

  	<div class="header-branding" style="clear: both;">
	  	<div class="header_logo">
  			<a href="/"><img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" /></a>
	  	</div>
  	</div>
  	
  	<?php global $blog_id; if ($blog_id == 1) {
  	} else {
		if (is_front_page()){
		} else {
			basic_breadcrumb();
		}
	}?>

<?php if ( class_exists( 'MarketpressFadminWidget' ) ) {
	$mp_frontend_settings = get_option( 'mp_frontend_settings' );
	$mp_frontend_settings = unserialize($mp_frontend_settings);
	$adminpage = $mp_frontend_settings['page_id'];
	$administrationpermalink = '<a class="btn btn-danger" style="float: right;" href="' . get_permalink($adminpage) . '?ptype=orders">' . __('Order Management', 'basic') . '</a></div>';
	} else {
		$administrationpermalink = '';
	} ?>

<?php
    if (current_user_can('edit_others_posts') && !$settings['disable_cart']) {
      $num_posts = wp_count_posts('mp_order'); //get pending order count
      $count = $num_posts->order_received + $num_posts->order_paid;
	  $received = $num_posts->order_received;
	  $paid = $num_posts->order_paid;
	  
	  if ( $received = 1 )
	  $received_msg = '' . __('Congratulations, you have', 'basic') . ' <span class="badge badge-important">' . $received . '</span>' . __('new order', 'basic') . '';
	  else $received_msg = '';

	  if ( $received > 1 )
	  $received_msg = '' . __('Congratulations, you have', 'basic') . ' <span class="badge badge-important">' . $received . '</span>' . __('new orders', 'basic') . '';
	  else $received_msg = '';

	  if ( $paid = 1 )
	  $paid_msg = '<span class="badge badge-important">' . $received . '</span>' . __('order has not been sent yet', 'basic') . '';
	  else $paid_msg = '';

	  if ( $paid > 1 )
	  $paid_msg = '<span class="badge badge-important">' . $received . '</span>' . __('orders have not been sent yet', 'basic') . '';
	  else $paid_msg = '';
	  
      if ( $count > 0 )
  			$count_output = '<div class="alert alert-block alert-error fade in"><a class="close" data-dismiss="alert" href="#">&times;</a>'
  								. __('Unresolved orders:', 'basic') . '<span class="badge badge-important">' . $count . '</span>' . $received_msg . '' . $paid_msg . '' . $administrationpermalink . '';
  		else
  			$count_output = '';
      echo $count_output;
    }
?>