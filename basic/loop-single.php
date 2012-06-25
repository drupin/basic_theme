<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php basic_post_before(); ?>
    <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <?php basic_post_inside_before(); ?>
      <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php basic_entry_meta(); ?>
      </header>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
      <footer>
        <?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'basic'), 'after' => '</p></nav>')); ?>
        <?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(); ?></p><?php } ?>
      </footer>
      <?php comments_template(); ?>
      <?php basic_post_inside_after(); ?>
    </article>
  <?php basic_post_after(); ?>
<?php endwhile; /* End loop */ ?>