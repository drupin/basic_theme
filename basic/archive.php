<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
        <div class="page-header">
          <h1>
            <?php
              $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
              if ($term) {
                echo $term->name;
              } elseif (is_post_type_archive()) {
                echo get_queried_object()->labels->name;
              } elseif (is_day()) {
                printf(__('Daily Archives: %s', 'basic'), get_the_date());
              } elseif (is_month()) {
                printf(__('Monthly Archives: %s', 'basic'), get_the_date('F Y'));
              } elseif (is_year()) {
                printf(__('Yearly Archives: %s', 'basic'), get_the_date('Y'));
              } elseif (is_author()) {
                global $post;
                $author_id = $post->post_author;
                printf(__('Author Archives: %s', 'basic'), get_the_author_meta('user_nicename', $author_id));
              } else {
                single_cat_title();
              }
            ?>
          </h1>
        </div>
        <?php basic_loop_before(); ?>
        <?php get_template_part('loop', 'category'); ?>
        <?php basic_loop_after(); ?>
      </div><!-- /#main -->
    <?php basic_main_after(); ?>
    <?php basic_sidebar_before(); ?>
      <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
      <?php basic_sidebar_inside_before(); ?>
        <?php get_sidebar(); ?>
      <?php basic_sidebar_inside_after(); ?>
      </aside><!-- /#sidebar -->
    <?php basic_sidebar_after(); ?>
    </div><!-- /#content -->
  <?php basic_content_after(); ?>
<?php get_footer(); ?>