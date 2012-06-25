<header id="banner" class="navbar navbar-fixed-top" role="banner">
	<?php basic_header_inside(); ?>
	<div class="navbar-inner">
		<div class="<?php echo WRAP_CLASSES; ?>">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo home_url(); ?>/"><?php bloginfo('name', 'basic'); ?></a>
			<nav id="nav-main" class="nav-collapse" role="navigation">
			<ul class="nav">
				<li class="menu-home"><a href="/"><?php _e('Home', 'basic'); ?></a></li>
				<li class="divider-vertical"></li>
				<li class="menu-store" >
					<?php global $blog_id; if ($blog_id == 1) { ?>
						<a style="color: #46a546;" href="/marketplace/"><?php _e('Products', 'basic'); ?></a>
					<?php } else { ?>
						<a style="color: #46a546;" href="/store/products"><?php _e('Products', 'basic'); ?></a>
					<?php } ?>
				</li>
				<li class="divider-vertical"></li>
				<?php global $wp_roles;
				foreach ( $wp_roles->role_names as $role => $name ) :
				if (current_user_can( $role ) && $role == 'administrator') { ?>
					<li class="menu-dropdown-storeadmin dropdown" data-dropdown="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i><?php _e('Store Administration', 'basic'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if ( class_exists( 'MarketpressFadminWidget' ) ) { ?>
							 <?php
								 $mp_frontend_settings = get_option( 'mp_frontend_settings' );
								 $mp_frontend_settings = unserialize($mp_frontend_settings);
								 $adminpage = $mp_frontend_settings['page_id'];
								 $permalink = get_permalink($adminpage);
							 ?>
							<li class="menu-product-new"><a href="<?php echo $permalink; ?>"><?php _e('Create Product', 'basic'); ?></a></li>
							<li class="menu-product-list">
								<a href="<?php echo $permalink;   ?>?ptype=allproduct"><?php _e('Products', 'basic'); ?>
									<?php $num_posts = wp_count_posts( 'product' );
									$num = number_format_i18n( $num_posts->publish );
									$count_output = '<span class="badge badge-success">' . $num . '</span>';
									echo $count_output;
									?>
								</a>
							</li>
							<li class="menu-store-orders">
								<a href="<?php echo $permalink;   ?>?ptype=orders"><?php _e('Orders', 'basic'); ?>
									<?php $num_posts = wp_count_posts('mp_order'); //get pending order count
									$count = $num_posts->order_received + $num_posts->order_paid;
									if ( $count > 0 )
										$count_output = '<span class="badge badge-important">' . $count . '</span>';
									else
										$count_output = '';
									echo $count_output;
									?>
								</a>
							</li>
							<li class="menu-store-settings"><a href="<?php echo $permalink;   ?>?ptype=settings"><?php _e('Store Settings', 'basic') ?></a></li>
							<?php } ?>
							<li class="menu-store-statistics"><a data-toggle="modal" href="#statisticsmodal"><?php _e('Store Statistics', 'basic'); ?></a></li>
							
							<li class="divider"></li>
							
							<li class="menu-store-affiliates"><a href="/affiliate"><?php _e('Affiliates Program', 'basic'); ?></a></li>
							<?php if ( class_exists( 'ProSites' ) ) { ?>
								<li class="menu-store-upgrade"><?php basic_upgrade_link(); ?></li>
							<?php } ?>
						</ul>
					</li>
				<?php } endforeach; ?>
				<?php if (!(current_user_can('level_0'))){ ?>
					<li class="menu-dropdown-profile dropdown" data-dropdown="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> <?php _e('Login/Register', 'basic'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="menu-login" style="width: 100%;">
								<form class="clearfix" action="<?php bloginfo('wpurl') ?>/wp-login.php" method="post">
									<h2>Member Login</h2>
									<label class="grey" for="log">Username:</label>
									<input class="field" type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="23" />
									<label class="grey" for="pwd">Password:</label>
									<input class="field" type="password" name="pwd" id="pwd" size="23" />
									<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me</label>
									<div class="clear"></div>
									<?php if (get_option('users_can_register')) : ?>
										<a href="http://magazi.org/register" class="btn">Εγγραφή</a>
									<?php else : ?><?php endif ?>
									<input type="submit" name="submit" value="Είσοδος" class="bt_login btn btn-primary" />
									<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
								</form>
								<form class="clearfix" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
									<h2>Ξεχάσατε τον κωδικό σας;</h2>
									<label class="grey" for="user_login">e-mail ή όνομα χρήστη:</label>
									<input class="field" type="text" name="user_login" id="user_login_FP" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="23" />        			
									<div class="clear"></div>
									<p>Θα σας αποσταλεί νέος κωδικός</p>
									<input type="submit" name="submit" value="Αποστολή νέου κωδικού" class="bt_register btn btn-small" />
									<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
								</form>
							</li>
						</ul>
					</li>
				<?php } else { ?>
					<li class="menu-dropdown-profile dropdown" data-dropdown="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i><?php _e('Profile', 'basic'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="menu-login">
								<table class="no-style profile">
									<tbody>
										<tr>
											<td colspan="2">
												Καλωσήρθατε, <?php global $current_user; get_currentuserinfo(); echo $current_user->user_login . "\n";?>
											</td>
										</tr>
										<tr>
											<td><a href="<?php echo bp_loggedin_user_domain() ?>profile"><?php bp_loggedin_user_avatar('type=full&width=117&height=117') ?></a></td>
											<td>
												<a class="btn btn-primary" href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>">View My Profile</a>
												<a class="btn btn-primary" href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>/edit">Edit My Profile</a>
												<a class="btn btn-primary" href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>/change-avatar">Change My Avatar</a>
											</td>
										</tr>
										<tr>
											<td colspan="2"><a class="btn btn-danger" href="<?php echo wp_logout_url(get_permalink()); ?>" rel="nofollow" title="<?php _e('Log out'); ?>"><?php _e('Log out'); ?></a></td>
										</tr>
									</tbody>
								</table>
							</li>
						</ul>
					</li>
				<?php }?>
			</ul>
			</nav>
			<?php global $blog_id; if ($blog_id == 1) { ?> <?php } else { ?>
			<?php if ( class_exists( 'MarketPress' ) ) {
			$settings = get_option('mp_settings');
			if (!$settings['disable_cart']) { ?>
			<a class="btn btn-primary" data-toggle="modal" href="#cartmodal" style="float: right;"><i class="icon-shopping-cart icon-white"></i> <?php _e('My Cart', 'basic'); ?></a>
			<div class="modal hide fade in" id="cartmodal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3><?php _e('My Cart', 'basic'); ?></h3>
				</div>
				<div class="modal-body">
    	  			<p><?php dynamic_sidebar('headercart'); ?></p>
	    	  	</div>
    	  		<div class="modal-footer">
      				<a href="#" class="btn" data-dismiss="modal"><?php _e('Cancel', 'basic'); ?></a>
      				<a href="/store/shopping-cart" class="btn btn-warning"><i class="icon-shopping-cart icon-white"></i><?php _e('Go to your cart', 'basic'); ?></a>
	      			<a href="/store/shopping-cart" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i><?php _e('Continue to Checkout', 'basic'); ?></a>
		      	</div>
			</div>
			<?php } ?>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
	<?php global $wp_roles;
	foreach ( $wp_roles->role_names as $role => $name ) :
	if (current_user_can( $role ) && $role == 'administrator') { ?>
			<div class="modal hide fade in" id="statisticsmodal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3><?php _e('Store Statistics', 'basic'); ?></h3>
				</div>
				<div class="modal-body">
				<?php global $wpdb, $mp;
				$year = date('Y');
				$month = date('m');
				$this_month = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");
	
				$year = date('Y', strtotime('-1 month'));
				$month = date('m', strtotime('-1 month'));
				$last_month = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	
				
				$all_months = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total'");
	
				//later get full stats and graph
				//$stats = $wpdb->get_results("SELECT DATE_FORMAT(p.post_date, '%Y-%m') as date, count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' GROUP BY YEAR(p.post_date), MONTH(p.post_date) ORDER BY date DESC");
				?>
				<table class="table"><tr><td>
					<table class="table table-striped table-bordered table-condensed">
					<thead><h4><?php printf(__('This month', 'basic'), date_i18n('M, Y')); ?></h4></thead>
						<tbody>
							<tr>
								<td class="<?php echo ($this_month->count >= $last_month->count) ? ' green' : ' red'; ?>"><?php echo number_format_i18n($this_month->count); ?></td>
								<td><?php _e('Orders', 'basic'); ?></td>
							</tr>	
							<tr>
								<td class="<?php echo ($this_month->total >= $last_month->total) ? ' green' : ' red'; ?>"><?php echo $mp->format_currency(false, $this_month->total); ?></td>
								<td><?php _e('Total Orders', 'basic'); ?></td>
							</tr>
							<tr>
								<td class="<?php echo ($this_month->average >= $last_month->average) ? ' green' : ' red'; ?>"><?php echo $mp->format_currency(false, $this_month->average); ?></td>
								<td><?php _e('Order Average', 'basic'); ?></td>
							</tr>
						</tbody>
					</table>
				</td><td>
					<table class="table table-striped table-bordered table-condensed">
					<thead><h4><?php printf(__('Last month', 'basic'), date_i18n('M, Y', strtotime('-1 month'))); ?></h4></thead>
						<tbody>
							<tr>
								<td><?php echo intval($last_month->count); ?></td>
								<td><?php _e('Orders', 'basic'); ?></td>
							</tr>	
							<tr>
								<td><?php echo $mp->format_currency(false, $last_month->total); ?></td>
								<td><?php _e('Total Orders', 'basic'); ?></td>
							</tr>
							<tr>
								<td><?php echo $mp->format_currency(false, $last_month->average); ?></td>
								<td><?php _e('Order Average', 'basic'); ?></td>
							</tr>
						</tbody>
					</table>
				</td></tr></table>
				<table class="table table-striped table-bordered table-condensed">
					<thead><tr><th><?php _e('Total', 'basic'); ?></th></tr></thead>
					<tr>
						<td><?php _e('Total Products', 'basic'); ?></td>
						<td>
							<?php $num_posts = wp_count_posts( 'product' );
							$num = number_format_i18n( $num_posts->publish );
							$count_output = '' . $num . '';
							echo $count_output;
							?>
						</td>
					</tr>
					</tr>
					<tr>
						<td><?php _e('New Orders', 'basic'); ?></td>
						<td class="red"><a class="red" href="/storeadmin/?ptype=orders&post_status=order_received">
							<?php $num_posts = wp_count_posts('mp_order');
							$count = '' . number_format_i18n($num_posts->order_received) . '';
							$count_output = '' . $count . '';
							echo $count_output;
							?>
						</a></td>
					</tr>
					<tr>
						<td><?php _e('Orders with status: Paid', 'basic'); ?></td>
						<td class="orange"><a class="oranfe" href="/storeadmin/?ptype=orders&post_status=order_paid">
							<?php $num_posts = wp_count_posts('mp_order');
							$count = '' . number_format_i18n($num_posts->order_paid) . '';
							$count_output = '' . $count . '';
							echo $count_output;
							?>
						</td>
					</tr>
					<tr>
						<td><?php _e('Orders with status: Sent', 'basic'); ?></td>
						<td class="green"><a class="green" href="/storeadmin/?ptype=orders&post_status=order_shipped">
							<?php $num_posts = wp_count_posts('mp_order');
							$count = '' . number_format_i18n($num_posts->order_shipped) . '';
							$count_output = '' . $count . '';
							echo $count_output;
							?>
						</td>
					</tr>
					<tr>
						<td><?php _e('Closed Orders', 'basic'); ?></td>
						<td class="green"><a class="green" href="/storeadmin/?ptype=orders&post_status=order_closed">
							<?php $num_posts = wp_count_posts('mp_order');
							$count = '' . number_format_i18n($num_posts->order_closed) . '';
							$count_output = '' . $count . '';
							echo $count_output;
							?>
						</td>
					</tr>
					<tr>
						<td><?php _e('Total Number of Orders', 'basic'); ?></td>
						<td class="blue"><?php echo intval($all_months->count); ?></td>
					</tr>	
					<tr>
						<td><?php _e('Orders Total', 'basic'); ?></td>
						<td class="blue"><?php echo $mp->format_currency(false, $all_months->total); ?></td>
					</tr>
					<tr>
						<td><?php _e('Average per Order', 'basic'); ?></td>
						<td class="blue"><?php echo $mp->format_currency(false, $all_months->average); ?></td>
					</tr>
				</table>
			</div>
    	  		<div class="modal-footer">
      				<a href="#" class="btn btn-primary" data-dismiss="modal"><?php _e('Close', 'basic'); ?></a>
		      	</div>
			</div>
	<?php } endforeach; ?>
</header>
