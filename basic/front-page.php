<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="span12" role="main">
      	<header class="jumbotron masthead">
      		<?php dynamic_sidebar('jumbotron'); ?>
      	</header>
      	<hr class="soften">
      	<div class="marketing">
	        <aside class="span12 frontpage-small row"><?php dynamic_sidebar('frontslider'); ?></aside>
	        <aside class="frontpage-small row"><?php dynamic_sidebar('sidebar-front1'); ?></aside>
    	</div>
      </div><!-- /#main -->
    <?php basic_main_after(); ?>
    </div><!-- /#content -->
  <?php basic_content_after(); ?>
<?php get_footer(); ?>