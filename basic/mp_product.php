<?php get_header(); ?>
  <?php basic_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php basic_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?> product-single" role="main">
		<?php if ( current_user_can('manage_options') ){ ?>
			<?php if ( class_exists( 'MarketpressFadminWidget' ) ) { ?>
				<?php
				$mp_frontend_settings = get_option( 'mp_frontend_settings' );
				$mp_frontend_settings = unserialize($mp_frontend_settings);
				$adminpage = $mp_frontend_settings['page_id'];
				$permalink = get_permalink($adminpage);
				?>
				<div class="EditProductEntryButton" style="float: right;">
					<a class="label label-info" href="<?php echo $permalink; ?>?pid=<?php the_ID(); ?>">Επεξεργασία Προϊόντος</a>
				</div>
			<?php } ?>
		<?php } ?>
      	<?php basic_product(); ?>
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
