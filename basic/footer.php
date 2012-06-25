
  </div><!-- /#wrap -->

  <?php basic_footer_before(); ?>
  <footer id="content-info" class="<?php echo WRAP_CLASSES; ?>" role="contentinfo">
    <?php basic_footer_inside(); ?>
    <?php dynamic_sidebar('sidebar-footer'); ?>
    <p class="copy" style="float: left;"><small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>, μέλος του δικτύου καταστημάτων <a href="http://magazi.org">magazi.org</a></small></p>
    <div style="float: right;">Η σελίδα υποστηρίζει:
    	<img style="display: inline; margin-right: 1em;" name="HTML5" src="http://magazi.org/wp-content/themes/basic/img/icons/html5.png" />
    	<img style="display: inline; margin-right: 1em;" name="CSS3" src="http://magazi.org/wp-content/themes/basic/img/icons/css3.png" />
    	<img style="display: inline; margin-right: 1em;" name="Mobile Ready" src="http://magazi.org/wp-content/themes/basic/img/icons/iphone.png" />
    </div>
    	
  </footer>
  <?php basic_footer_after(); ?>

  <?php wp_footer(); ?>
  <?php basic_footer(); ?>

<?php if ($settings['list_view'] == 'grid') { ?>
<style>	div{background: #333;}</style>
<?php } ?>
</style>

</body>
</html>