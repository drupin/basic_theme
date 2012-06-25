<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo FULLWIDTH_CLASSES; ?>" role="main">
        <div class="page-header">
          <h1><?php _e('File Not Found', 'basic'); ?></h1>
        </div>
        <div class="alert alert-block fade in">
          <a class="close" data-dismiss="alert">&times;</a>
          <p><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'basic'); ?></p>
        </div>
        <p><?php _e('Please try the following:', 'basic'); ?></p>
        <ul>
          <li><?php _e('Check your spelling', 'basic'); ?></li>
          <li><?php printf(__('Return to the <a href="%s">home page</a>', 'basic'), home_url()); ?></li>
          <li><?php _e('Click the <a href="javascript:history.back()">Back</a> button', 'basic'); ?></li>
        </ul>
        <?php get_search_form(); ?>
      </div><!-- /#main -->
    <?php basic_main_after(); ?>
    </div><!-- /#content -->
  <?php basic_content_after(); ?>
<?php get_footer(); ?>