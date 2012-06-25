<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
		<?php if ( class_exists( 'MarketPress' ) ) { ?>
			<div id="product-grid">
<!-- 				<ul class="parentcategories">
					<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						wp_list_categories('taxonomy=product_category&depth=0&show_count=0&title_li=&parent_of=' . $term->term_id);
					?>
				</ul> -->
				<ul class="subcategories">
					<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						wp_list_categories('taxonomy=product_category&depth=0&show_count=0&title_li=&child_of=' . $term->term_id);
					?>
				</ul>
				<?php basic_list_products();?>
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