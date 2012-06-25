<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
		<?php if ( class_exists( 'MarketPress' ) ) { ?>
			<div id="product-grid">
				<?php
				$args = array (
					'text' => 'none',
					'per_page' => 20,
				);
				//check for paging
				if (get_query_var('paged'))
				$args['page'] = intval(get_query_var('paged'));
				basic_list_global_products( $args );
				?>
			</div>
			<div id="market-page-links">
				<?php basic_global_products_nav_link( $args ); ?>
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