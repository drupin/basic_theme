<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
		<?php if ( class_exists( 'MarketPress' ) ) { ?>
			<div id="product-grid">
				<ul class="subcategories">
					<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						wp_list_categories('taxonomy=product_category&depth=0&show_count=0&title_li=&child_of=' . $term->term_id);
					?>
				</ul>
				<?php
				if ( $slug = get_query_var('global_taxonomy') ) {
				      $args = array();
				      $args['echo'] = false;
				      $args['category'] = $slug;
				      //check for paging
				      if (get_query_var('paged'))
				        $args['page'] = intval(get_query_var('paged'));
				      $content = basic_list_global_products( $args );
				      $content .= get_posts_nav_link();
				    } else { //no category set, so show list
				      $content .= mp_global_categories_list( array( 'echo' => false ) );
				    }
					echo $content;
				?>
			</div>
		<?php } ?>
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