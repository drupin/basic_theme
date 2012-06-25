<?php
/*
Template Name: Full Width
*/
get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo FULLWIDTH_CLASSES; ?>" role="main">
        <?php basic_loop_before(); ?>
        <?php get_template_part('loop', 'page'); ?>
        <?php basic_loop_after(); ?>
      </div><!-- /#main -->
    <?php basic_main_after(); ?>
    </div><!-- /#content -->
  <?php basic_content_after(); ?>
<?php get_footer(); ?>