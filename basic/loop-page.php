<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php basic_post_before(); ?>
    <?php basic_post_inside_before(); ?>
      <div class="page-header">
      	<h1><?php the_title(); ?></h1>
      </div>
      <?php the_content(); ?>
      <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
    <?php basic_post_inside_after(); ?>
  <?php basic_post_after(); ?>
<?php endwhile; /* End loop */ ?>