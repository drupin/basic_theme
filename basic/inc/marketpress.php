<?php
function basic_listall_shops(){
	global $wpdb;
    $query = "SELECT blog_id FROM " . $wpdb->base_prefix . "blogs WHERE spam != '1' AND archived != '1' AND deleted != '1' AND public = '1' ORDER BY path";
    
    $blogs = $wpdb->get_results($query);
    ?>
<select name="shoplist" onchange="document.location.href=this.options[this.selectedIndex].value;"> 
	<option value="">Visit a shop</option>
	<?php
    foreach($blogs as $blog){
        $blog_details = get_blog_details($blog->blog_id);
?>
<option value="<?php echo $blog_details->siteurl; ?>"> <?php echo $blog_details->blogname; ?></option>
<?php
    }
?>
 </select>
<?php
}


/*
 * function basic_list_products
 * Displays a list of products according to preference. Optional values default to the values in Presentation Settings -> Product List
 *
 * @param bool $echo Optional, whether to echo or return
 * @param bool $paginate Optional, whether to paginate
 * @param int $page Optional, The page number to display in the product list if $paginate is set to true.
 * @param int $per_page Optional, How many products to display in the product list if $paginate is set to true.
 * @param string $order_by Optional, What field to order products by. Can be: title, date, ID, author, price, sales, rand
 * @param string $order Optional, Direction to order products by. Can be: DESC, ASC
 * @param string $category Optional, limit to a product category
 * @param string $tag Optional, limit to a product tag
 */
function basic_list_products( $echo = true, $paginate = '', $page = '', $per_page = '', $order_by = '', $order = '', $category = '', $tag = '' ) {
  global $wp_query, $mp;
  $settings = get_option('mp_settings');

  //setup taxonomy if applicable
  if ($category) {
    $taxonomy_query = '&product_category=' . sanitize_title($category);
  } else if ($tag) {
    $taxonomy_query = '&product_tag=' . sanitize_title($tag);
  } else if ($wp_query->query_vars['taxonomy'] == 'product_category' || $wp_query->query_vars['taxonomy'] == 'product_tag') {
    $taxonomy_query = '&' . $wp_query->query_vars['taxonomy'] . '=' . get_query_var($wp_query->query_vars['taxonomy']);
  }

  //setup pagination
  $paged = false;
  if ($paginate) {
    $paged = true;
  } else if ($paginate === '') {
    if ($settings['paginate'])
      $paged = true;
    else
      $paginate_query = '&nopaging=true';
  } else {
    $paginate_query = '&nopaging=true';
  }

  //get page details
  if ($paged) {
    //figure out perpage
    if (intval($per_page)) {
      $paginate_query = '&posts_per_page='.intval($per_page);
    } else {
      $paginate_query = '&posts_per_page='.$settings['per_page'];
		}

    //figure out page
    if ($wp_query->query_vars['paged'])
      $paginate_query .= '&paged='.intval($wp_query->query_vars['paged']);

    if (intval($page))
      $paginate_query .= '&paged='.intval($page);
    else if ($wp_query->query_vars['paged'])
      $paginate_query .= '&paged='.intval($wp_query->query_vars['paged']);
  }

  //get order by
  if (!$order_by) {
    if ($settings['order_by'] == 'price')
      $order_by_query = '&meta_key=mp_price_sort&orderby=meta_value_num';
    else if ($settings['order_by'] == 'sales')
      $order_by_query = '&meta_key=mp_sales_count&orderby=meta_value_num';
    else
      $order_by_query = '&orderby='.$settings['order_by'];
  } else {
  	if ('price' == $order_by)
  		$order_by_query = '&meta_key=mp_price_sort&orderby=meta_value_num';
    else
    	$order_by_query = '&orderby='.$order_by;
  }

  //get order direction
  if (!$order) {
    $order_query = '&order='.$settings['order'];
  } else {
    $order_query = '&order='.$order;
  }

  //The Query
  $custom_query = new WP_Query('post_type=product&post_status=publish' . $taxonomy_query . $paginate_query . $order_by_query . $order_query);

  //allows pagination links to work get_posts_nav_link()
  if ($wp_query->max_num_pages == 0 || $taxonomy_query)
    $wp_query->max_num_pages = $custom_query->max_num_pages;

  $content = '<div id="product_list">';

  if ($last = $custom_query->post_count) {
    $count = 1;
    foreach ($custom_query->posts as $post) {
    	
    if ($settings['list_view'] == 'grid')
	  $class = 'product grid';
	else $class='product list';
	
	if ($settings['list_view'] == 'grid')
		if(strlen($post->post_title)>30){
			$product_title = mb_substr($post->post_title,0,30,'UTF-8').'...';
		}
		else{
			$product_title = $post->post_title;
		}
	else $product_title = $post->post_title;

      $content .= '<div '.basic_product_class(false, $class, $post->ID).'>';

      $content .= '<h3 class="product_name"><a href="' . get_permalink( $post->ID ) . '">' . $product_title . '</a></h3>';

      $product_content = basic_product_image( false, 'list', $post->ID );
      if ($settings['show_excerpt'] == 1)
	  	if ($settings['list_view'] == 'list')
        $product_content .= $mp->product_excerpt($post->post_excerpt, $post->post_content, $post->ID);
      $content .= apply_filters( 'mp_product_list_content', $product_content, $post->ID );

      $content .= '<div class="product_meta">';
      //price
      $meta = basic_product_price(false, $post->ID);
      //button
      $meta .= basic_buy_button(false, 'list', $post->ID);
      $content .= apply_filters( 'mp_product_list_meta', $meta, $post->ID );
      $content .= '</div>';

      $content .= '</div>';
      
      $count++;
    }
  } else {
    $content .= '<div id="no_products">' . apply_filters( 'mp_product_list_none', __('No Products', 'basic') ) . '</div>';
  }

  $content .= '</div>';

 	if (  $wp_query->max_num_pages > 1 ) :

		$content .= '<ul class="pager" style="clear: both; float: none;">';
		$content .= '<li class="previous">'.get_previous_posts_link( '<i class="icon-chevron-left"></i> Προηγούμενο' ).'</li>';
		$content .= '<li class="next">'.get_next_posts_link( __( 'Επόμενο <i class="icon-chevron-right"></i>') ).'</li>';
		$content .= '</ul>';
	endif;

  if ($echo)
    echo $content;
  else
    return $content;
}


/**
 * Display the classes for the product div.
 *
 * @param bool $echo Whether to echo class.
 * @param string|array $class One or more classes to add to the class list.
 * @param int $post_id The post_id for the product. Optional if in the loop
 */
function basic_product_class( $echo = true, $class = '', $post_id = null ) {
	// Separates classes with a single space, collates classes for post DIV
	$content = 'class="' . join( ' ', basic_get_product_class( $class, $post_id ) ) . '"';

	if ($echo)
    echo $content;
  else
    return $content;
}


/**
 * Retrieve the list of classes for the product as an array.
 *
 * The class names are add are many. If the post is a sticky, then the 'sticky'
 * class name. The class 'hentry' is always added to each post. For each
 * category, the class will be added with 'category-' with category slug is
 * added. The tags are the same way as the categories with 'tag-' before the tag
 * slug. All classes are passed through the filter, 'post_class' with the list
 * of classes, followed by $class parameter value, with the post ID as the last
 * parameter.
 *
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param int $post_id The post_id for the product. Optional if in the loop
 * @return array Array of classes.
 */
function basic_get_product_class( $class = '', $post_id = null ) {
  global $id;
  $post_id = ( NULL === $post_id ) ? $id : $post_id;

	$post = get_post($post_id);

	$classes = array();

	if ( empty($post) )
		return $classes;

	$classes[] = 'product-' . $post->ID;
	$classes[] = $post->post_type;

	// sticky for Sticky Posts
	if ( is_sticky($post->ID))
		$classes[] = 'sticky';

	// hentry for hAtom compliace
	$classes[] = 'hentry';

	// Categories
	$categories = get_the_terms($post->ID, "product_category");
	foreach ( (array) $categories as $cat ) {
		if ( empty($cat->slug ) )
			continue;
		$classes[] = 'category-' . sanitize_html_class($cat->slug, $cat->cat_ID);
	}

	// Tags
	$tags = get_the_terms($post->ID, "product_tag");
	foreach ( (array) $tags as $tag ) {
		if ( empty($tag->slug ) )
			continue;
		$classes[] = 'tag-' . sanitize_html_class($tag->slug, $tag->term_id);
	}

	if ( !empty($class) ) {
		if ( !is_array( $class ) )
			$class = preg_split('#\s+#', $class);
		$classes = array_merge($classes, $class);
	}

	$classes = array_map('esc_attr', $classes);

	return $classes;
}


/*
 * Displays the product featured image
 *
 * @param bool $echo Optional, whether to echo
 * @param string $context Options are list, single, or widget
 * @param int $post_id The post_id for the product. Optional if in the loop
 * @param int $size An optional width/height for the image if contect is widget
 */
function basic_product_image( $echo = true, $context = 'list', $post_id = NULL, $size = NULL ) {
  global $id;
  $post_id = ( NULL === $post_id ) ? $id : $post_id;
  // Added WPML
  $post_id = apply_filters('mp_product_image_id', $post_id);

  $post = get_post($post_id);

  $settings = get_option('mp_settings');
  $post_thumbnail_id = get_post_thumbnail_id( $post_id );

  if ($context == 'list') {
    //quit if no thumbnails on listings
    if (!$settings['show_thumbnail'])
      return '';

    //size
    $size = array(160, 120);

    //link
    $link = get_permalink($post_id);

    $title = esc_attr($post->post_title);

  } else if ($context == 'single') {
    //size
    if ($settings['product_img_size'] == 'custom')
      $size = array($settings['product_img_width'], $settings['product_img_height']);
    else
      $size = $settings['product_img_size'];

    //link
    $temp = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
    $link = $temp[0];

    $title = __('View Larger Image &raquo;', 'mp');
    $class = ' class="mp_product_image_link mp_lightbox" rel="lightbox"';

  } else if ($context == 'widget') {
    //size
    if (intval($size))
      $size = array(intval($size), intval($size));
    else
      $size = array(50, 50);

    //link
    $link = get_permalink($post_id);

    $title = esc_attr($post->post_title);

  }

  $image = get_the_post_thumbnail($post_id, $size, array('class' => 'alignleft product_image_'.$context, 'title' => $title));

  //add the link
  if ($link)
    $image = '<div class="image-wrapper"><a id="product_image-' . $post_id . '"' . $class . ' href="' . $link . '">' . $image . '</a></div>';

  if ($echo)
    echo $image;
  else
    return $image;
}


/*
 * Displays the product price (and sale price)
 *
 * @param bool $echo Optional, whether to echo
 * @param int $post_id The post_id for the product. Optional if in the loop
 * @param sting $label A label to prepend to the price. Defaults to "Price: "
 */
function basic_product_price( $echo = true, $post_id = NULL, $label = true ) {
  global $id, $mp;
  $post_id = ( NULL === $post_id ) ? $id : $post_id;

  $label = ($label === true) ? __('', 'mp') : $label;

  $settings = get_option('mp_settings');
	$meta = get_post_custom($post_id);
  //unserialize
  foreach ($meta as $key => $val) {
	  $meta[$key] = maybe_unserialize($val[0]);
	  if (!is_array($meta[$key]) && $key != "mp_is_sale" && $key != "mp_track_inventory" && $key != "mp_product_link" && $key != "mp_file" && $key != "mp_price_sort")
	    $meta[$key] = array($meta[$key]);
	}

  if ((is_array($meta["mp_price"]) && count($meta["mp_price"]) >= 1) || !empty($meta["mp_file"])) {
    if ($meta["mp_is_sale"]) {
	    $price = '<span class="mp_special_price"><del class="mp_old_price">'.$mp->format_currency('', $meta["mp_price"][0]).'</del>';
	    $price .= '<span class="mp_current_price">'.$mp->format_currency('', $meta["mp_sale_price"][0]).'</span></span>';
	  } else {
	    $price = '<span class="mp_normal_price"><span class="mp_current_price">'.$mp->format_currency('', $meta["mp_price"][0]).'</span></span>';
	  }
	} else {
		return '';
	}

  $price = apply_filters( 'mp_product_price_tag', '<span class="mp_product_price">' . $label . $price . '</span>', $post_id, $label );

  if ($echo)
    echo $price;
  else
    return $price;
}


/*
 * Displays the buy or add to cart button
 *
 * @param bool $echo Optional, whether to echo
 * @param string $context Options are list or single
 * @param int $post_id The post_id for the product. Optional if in the loop
 */
function basic_buy_button( $echo = true, $context = 'list', $post_id = NULL ) {
  global $id, $mp;
  $post_id = ( NULL === $post_id ) ? $id : $post_id;

  $settings = get_option('mp_settings');
  $meta = get_post_custom($post_id);
  //unserialize
  foreach ($meta as $key => $val) {
	  $meta[$key] = maybe_unserialize($val[0]);
	  if (!is_array($meta[$key]) && $key != "mp_is_sale" && $key != "mp_track_inventory" && $key != "mp_product_link" && $key != "mp_file")
	    $meta[$key] = array($meta[$key]);
	}

  //check stock
  $no_inventory = array();
  $all_out = false;
  if ($meta['mp_track_inventory']) {
    $cart = $mp->get_cart_contents();
    if (is_array($cart[$post_id])) {
	    foreach ($cart[$post_id] as $variation => $data) {
	      if ($meta['mp_inventory'][$variation] <= $data['quantity'])
	        $no_inventory[] = $variation;
			}
			foreach ($meta['mp_inventory'] as $key => $stock) {
	      if (!in_array($key, $no_inventory) && $stock <= 0)
	        $no_inventory[] = $key;
			}
		}

		//find out of stock items that aren't in the cart
		foreach ($meta['mp_inventory'] as $key => $stock) {
      if (!in_array($key, $no_inventory) && $stock <= 0)
        $no_inventory[] = $key;
		}

		if (count($no_inventory) >= count($meta["mp_price"]))
		  $all_out = true;
  }

  //display an external link or form button
  if ($product_link = $meta['mp_product_link']) {

    $button = '<a class="mp_link_buynow btn btn-primary" href="' . esc_url($product_link) . '">' . __('Buy Now &raquo;', 'mp') . '</a>';

  } else if ($settings['disable_cart']) {
    
    $button = '';
    
  } else {

    $button = '<form class="mp_buy_form" method="post" action="' . basic_cart_link(false, true) . '">';

    if ($all_out) {
      $button .= '<span class="mp_no_stock">' . __('Out of Stock', 'mp') . '</span>';
    } else {

	    $button .= '<input type="hidden" name="product_id" value="' . $post_id . '" />';

			//create select list if more than one variation
		  if (is_array($meta["mp_price"]) && count($meta["mp_price"]) > 1 && empty($meta["mp_file"])) {
	      $variation_select = '<select class="mp_product_variations" name="variation">';
				foreach ($meta["mp_price"] as $key => $value) {
				  $disabled = (in_array($key, $no_inventory)) ? ' disabled="disabled"' : '';
				  $variation_select .= '<option value="' . $key . '"' . $disabled . '>' . esc_html($meta["mp_var_name"][$key]) . ' - ';
					if ($meta["mp_is_sale"] && $meta["mp_sale_price"][$key]) {
		        $variation_select .= $mp->format_currency('', $meta["mp_sale_price"][$key]);
		      } else {
		        $variation_select .= $mp->format_currency('', $value);
		      }
		      $variation_select .= "</option>\n";
		    }
	      $variation_select .= "</select>&nbsp;\n";
	 		} else {
	      $button .= '<input type="hidden" name="variation" value="0" />';
			}

	    if ($context == 'list') {
	      if ($variation_select) {
        	$button .= '<a class="mp_link_buynow btn btn-primary" href="' . get_permalink($post_id) . '">' . __('Choose Option &raquo;', 'mp') . '</a>';
	      } else if ($settings['list_button_type'] == 'addcart') {
	        $button .= '<input type="hidden" name="action" value="mp-update-cart" />';
	        $button .= '<input class="mp_button_addcart btn btn-primary" type="submit" name="addcart" value="' . __('Add To Cart &raquo;', 'mp') . '" />';
	      } else if ($settings['list_button_type'] == 'buynow') {
	        $button .= '<input class="mp_button_buynow btn btn-primary" type="submit" name="buynow" value="' . __('Buy Now &raquo;', 'mp') . '" />';
	      }
	    } else {

	      $button .= $variation_select;

	      //add quantity field if not downloadable
	      if ($settings['show_quantity'] && empty($meta["mp_file"])) {
	        $button .= '<span class="mp_quantity"><label>' . __('Quantity:', 'mp') . ' <input class="mp_quantity_field" type="text" size="1" name="quantity" value="1" /></label></span>&nbsp;';
	      }

	      if ($settings['product_button_type'] == 'addcart') {
	        $button .= '<input type="hidden" name="action" value="mp-update-cart" />';
	        $button .= '<input class="mp_button_addcart btn btn-primary" type="submit" name="addcart" value="' . __('Add To Cart &raquo;', 'mp') . '" />';
	      } else if ($settings['product_button_type'] == 'buynow') {
	        $button .= '<input class="mp_button_buynow btn btn-primary" type="submit" name="buynow" value="' . __('Buy Now &raquo;', 'mp') . '" />';
	      }
	    }

    }

    $button .= '</form>';
  }

  $button = apply_filters( 'mp_buy_button_tag', $button, $post_id, $context );

  if ($echo)
    echo $button;
  else
    return $button;
}


/**
 * Echos the current shopping cart link. If global cart is on reflects global location
 * @param bool $echo Optional, whether to echo. Defaults to true
 * @param bool $url Optional, whether to return a link or url. Defaults to show link.
 * @param string $link_text Optional, text to show in link.
 */
function basic_cart_link($echo = true, $url = false, $link_text = '') {
	global $mp, $mp_wpmu;

	if ( $mp->global_cart && is_object($mp_wpmu) && !$mp_wpmu->is_main_site() && function_exists('mp_main_site_id') ) {
		switch_to_blog(mp_main_site_id());
		$settings = get_option('mp_settings');
		$link = home_url( $settings['slugs']['store'] . '/' . $settings['slugs']['cart'] . '/' );
		restore_current_blog();
	} else {
    $settings = get_option('mp_settings');
		$link = home_url( $settings['slugs']['store'] . '/' . $settings['slugs']['cart'] . '/' );
	}

  if (!$url) {
    $text = ($link_text) ? $link_text : __('Shopping Cart', 'mp');
    $link = '<a href="' . $link . '" class="mp_cart_link">' . $text . '</a>';
  }

  $link = apply_filters( 'basic_cart_link', $link, $echo, $url, $link_text );

  if ($echo)
    echo $link;
  else
    return $link;
}


register_widget('Basic_Product_List');
//Product listing widget
class Basic_Product_List extends WP_Widget {

	function Basic_Product_List() {
		$widget_ops = array('classname' => 'basic_product_list_widget', 'description' => __('Shows a customizable list of products from your MarketPress store.', 'basic') );
		$this->WP_Widget('basic_product_list_widget', __('Basic Product List', 'basic'), $widget_ops);
	}

	function widget($args, $instance) {
    global $mp;
		$settings = get_option('mp_settings');
		
		if ($instance['only_store_pages'] && !mp_is_shop_page())
			return;
		
		extract( $args );

		echo $before_widget;
	  $title = $instance['title'];
		if ( !empty( $title ) ) { echo $before_title . apply_filters('widget_title', $title) . $after_title; };

    if ( !empty($instance['custom_text']) )
      echo '<div id="custom_text">' . $instance['custom_text'] . '</div>';

    /* setup our custom query */

    //setup taxonomy if applicable
    if ($instance['taxonomy_type'] == 'category') {
      $taxonomy_query = '&product_category=' . $instance['taxonomy'];
    } else if ($instance['taxonomy_type'] == 'tag') {
      $taxonomy_query = '&product_tag=' . $instance['taxonomy'];
    }

    //figure out perpage
    if (isset($instance['num_products']) && intval($instance['num_products']) > 0) {
      $paginate_query = '&posts_per_page='.intval($instance['num_products']).'&paged=1';
    } else {
      $paginate_query = '&posts_per_page=10&paged=1';
    }

    //get order by
    if ($instance['order_by']) {
      if ($instance['order_by'] == 'price')
        $order_by_query = '&meta_key=mp_price&orderby=mp_price';
      else if ($instance['order_by'] == 'sales')
        $order_by_query = '&meta_key=mp_sales_count&orderby=mp_sales_count';
      else
        $order_by_query = '&orderby='.$instance['order_by'];
    } else {
      $order_by_query = '&orderby=title';
    }

    //get order direction
    if ($instance['order']) {
      $order_query = '&order='.$instance['order'];
    } else {
      $order_query = '&orderby=DESC';
    }

    //The Query
    $custom_query = new WP_Query('post_type=product' . $taxonomy_query . $paginate_query . $order_by_query . $order_query);

    //do we have products?
    if (count($custom_query->posts)) {
      echo '<ul id="product_list">';
      foreach ($custom_query->posts as $post) {

        echo '<li '.mp_product_class(false, 'product', $post->ID).'>';
        echo '<h3 class="product_name"><a href="' . get_permalink( $post->ID ) . '">' . esc_attr($post->post_title) . '</a></h3>';
        if ($instance['show_thumbnail'])
          mp_product_image( true, 'widget', $post->ID, $instance['size'] );

        if ($instance['show_excerpt'])
          echo '<div class="product_content">' . $mp->product_excerpt($post->post_excerpt, $post->post_content, $post->ID) . '</div>';

        if ($instance['show_price'] || $instance['show_button']) {
          echo '<div class="product_meta">';

          if ($instance['show_price'])
            echo mp_product_price(false, $post->ID, '');

          if ($instance['show_button'])
            echo basic_buy_button(false, 'list', $post->ID);

          echo '</div>';
        }
        $content .= '</li>';
      }
      echo '</ul>';
    } else {
      ?>
      <div class="widget-error">
  			<?php _e('No Products', 'mp') ?>
  		</div>
  		<?php
    }

    echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = stripslashes( wp_filter_nohtml_kses( $new_instance['title'] ) );
		$instance['custom_text'] = stripslashes( wp_filter_kses( $new_instance['custom_text'] ) );

		$instance['num_products'] = intval($new_instance['num_products']);
		$instance['order_by'] = $new_instance['order_by'];
		$instance['order'] = $new_instance['order'];
		$instance['taxonomy_type'] = $new_instance['taxonomy_type'];
    $instance['taxonomy'] = ($new_instance['taxonomy_type']) ? sanitize_title($new_instance['taxonomy']) : '';

    $instance['show_thumbnail'] = !empty($new_instance['show_thumbnail']) ? 1 : 0;
    $instance['size'] = !empty($new_instance['size']) ? intval($new_instance['size']) : 160;
    $instance['show_excerpt'] = !empty($new_instance['show_excerpt']) ? 1 : 0;
    $instance['show_price'] = !empty($new_instance['show_price']) ? 1 : 0;
    $instance['show_button'] = !empty($new_instance['show_button']) ? 1 : 0;
		
		$instance['only_store_pages'] = !empty($new_instance['only_store_pages']) ? 1 : 0;
		
		return $instance;
	}

	function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => __('Our Products', 'mp'), 'custom_text' => '', 'num_products' => 10, 'order_by' => 'title', 'order' => 'DESC', 'show_thumbnail' => 1, 'size' => 50, 'only_store_pages' => 0 ) );
		$title = $instance['title'];
		$custom_text = $instance['custom_text'];

		$num_products = intval($instance['num_products']);
		$order_by = $instance['order_by'];
		$order = $instance['order'];
    $taxonomy_type = $instance['taxonomy_type'];
    $taxonomy = $instance['taxonomy'];

		$show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : false;
		$size = !empty($instance['size']) ? intval($instance['size']) : 160;
		$show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
		$show_price = isset( $instance['show_price'] ) ? (bool) $instance['show_price'] : false;
		$show_button = isset( $instance['show_button'] ) ? (bool) $instance['show_button'] : false;
		
		$only_store_pages = isset( $instance['only_store_pages'] ) ? (bool) $instance['only_store_pages'] : false;
  ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mp') ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('custom_text'); ?>"><?php _e('Custom Text:', 'mp') ?><br />
    <textarea class="widefat" id="<?php echo $this->get_field_id('custom_text'); ?>" name="<?php echo $this->get_field_name('custom_text'); ?>"><?php echo esc_attr($custom_text); ?></textarea></label>
    </p>

    <h3><?php _e('List Settings', 'mp'); ?></h3>
    <p>
    <label for="<?php echo $this->get_field_id('num_products'); ?>"><?php _e('Number of Products:', 'mp') ?> <input id="<?php echo $this->get_field_id('num_products'); ?>" name="<?php echo $this->get_field_name('num_products'); ?>" type="text" size="3" value="<?php echo $num_products; ?>" /></label><br />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order Products By:', 'mp') ?></label><br />
    <select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
      <option value="title"<?php selected($order_by, 'title') ?>><?php _e('Product Name', 'mp') ?></option>
      <option value="date"<?php selected($order_by, 'date') ?>><?php _e('Publish Date', 'mp') ?></option>
<!--       <option value="ID"<?php selected($order_by, 'ID') ?>><?php _e('Product ID', 'mp') ?></option> -->
<!--       <option value="author"<?php selected($order_by, 'author') ?>><?php _e('Product Author', 'mp') ?></option> -->
      <option value="sales"<?php selected($order_by, 'sales') ?>><?php _e('Number of Sales', 'mp') ?></option>
      <option value="price"<?php selected($order_by, 'price') ?>><?php _e('Product Price', 'mp') ?></option>
      <option value="rand"<?php selected($order_by, 'rand') ?>><?php _e('Random', 'mp') ?></option>
    </select><br />
    <label><input value="DESC" name="<?php echo $this->get_field_name('order'); ?>" type="radio"<?php checked($order, 'DESC') ?> /> <?php _e('Descending', 'mp') ?></label>
    <label><input value="ASC" name="<?php echo $this->get_field_name('order'); ?>" type="radio"<?php checked($order, 'ASC') ?> /> <?php _e('Ascending', 'mp') ?></label>
    </p>
<!--     <p>
    <label><?php _e('Taxonomy Filter:', 'mp') ?></label><br />
    <select id="<?php echo $this->get_field_id('taxonomy_type'); ?>" name="<?php echo $this->get_field_name('taxonomy_type'); ?>">
      <option value=""<?php selected($taxonomy_type, '') ?>><?php _e('No Filter', 'mp') ?></option>
      <option value="category"<?php selected($taxonomy_type, 'category') ?>><?php _e('Category', 'mp') ?></option>
      <option value="tag"<?php selected($taxonomy_type, 'tag') ?>><?php _e('Tag', 'mp') ?></option>
    </select>
    <input id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="text" size="17" value="<?php echo $taxonomy; ?>" title="<?php _e('Enter the Slug', 'mp'); ?>" />
    </p> -->

    <h3><?php _e('Display Settings', 'mp'); ?></h3>
    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>"<?php checked( $show_thumbnail ); ?> />
		<label for="<?php echo $this->get_field_id('show_thumbnail'); ?>"><?php _e( 'Show Thumbnail', 'mp' ); ?></label><br />
<!-- 		<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Thumbnail Size:', 'mp') ?> <input id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" size="3" value="<?php echo $size; ?>" /></label></p> -->

    <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>"<?php checked( $show_excerpt ); ?> />
    <label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e( 'Show Excerpt', 'mp' ); ?></label><br />
    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_price'); ?>" name="<?php echo $this->get_field_name('show_price'); ?>"<?php checked( $show_price ); ?> />
		<label for="<?php echo $this->get_field_id('show_price'); ?>"><?php _e( 'Show Price', 'mp' ); ?></label><br />
    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_button'); ?>" name="<?php echo $this->get_field_name('show_button'); ?>"<?php checked( $show_button ); ?> />
		<label for="<?php echo $this->get_field_id('show_button'); ?>"><?php _e( 'Show Buy Button', 'mp' ); ?></label></p>
		
<!-- 		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('only_store_pages'); ?>" name="<?php echo $this->get_field_name('only_store_pages'); ?>"<?php checked( $only_store_pages ); ?> />
		<label for="<?php echo $this->get_field_id('only_store_pages'); ?>"><?php _e( 'Only show on store pages', 'mp' ); ?></label></p> -->
	<?php
	}
}

function basic_list_global_products($args = '') {
  global $wpdb, $mp;

  $defaults = array(
		'echo' => true,
    'paginate' => true,
		'page' => 0,
    'per_page' => 20,
		'order_by' => 'date',
    'order' => 'DESC',
		'category' => '',
    'tag' => '',
		'show_thumbnail' => true,
		'thumbnail_size' => 150,
		'context' => 'list',
		'show_price' => true,
		'text' => 'excerpt',
		'as_list' => false
	);

  $r = wp_parse_args( $args, $defaults );
  extract( $r );

  //setup taxonomy if applicable
  if ($category) {
    $category = $wpdb->escape( sanitize_title( $category ) );
    $query = "SELECT blog_id, p.post_id, post_permalink, post_title, post_content FROM {$wpdb->base_prefix}mp_products p INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_category' AND t.slug = '$category'";
  } else if ($tag) {
    $tag = $wpdb->escape( sanitize_title( $tag ) );
    $query = "SELECT blog_id, p.post_id, post_permalink, post_title, post_content FROM {$wpdb->base_prefix}mp_products p INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_tag' AND t.slug = '$tag'";
  } else {
    $query = "SELECT blog_id, p.post_id, post_permalink, post_title, post_content FROM {$wpdb->base_prefix}mp_products p WHERE p.blog_public = 1";
  }

  //get order by
  switch ($order_by) {

    case 'title':
      $query .= " ORDER BY p.post_title";
      break;

    case 'price':
      $query .= " ORDER BY p.price";
      break;

    case 'sales':
      $query .= " ORDER BY p.sales_count";
      break;

    case 'rand':
      $query .= " ORDER BY RAND()";
      break;

    case 'date':
    default:
      $query .= " ORDER BY p.post_date";
      break;
  }

  //get order direction
  if ($order == 'ASC') {
    $query .= " ASC";
  } else {
    $query .= " DESC";
  }

  //get page details
  if ($paginate)
    $query .= " LIMIT " . intval($page) . ", " . intval($per_page);

  //The Query
  $results = $wpdb->get_results( $query );

   $content = '<div id="product_list" class="global">';

  if ($results) {
	$count = 1;
	$counter = 0;
    foreach ($results as $product) {
    	
	  $content .= '<div class="product grid thumbnail">';

      global $current_blog;
      switch_to_blog($product->blog_id);

      //grab permalink
      $permalink = get_permalink( $product->post_id );

      //grab thumbnail
      if ($show_thumbnail)
        $thumbnail = basic_product_image( false, $context, $product->post_id, $thumbnail_size );
        
      //price
      if ($show_price) {
        if ($context == 'widget')
          $price = basic_product_price(false, $product->post_id, ''); //no price label in widgets
        else
          $price = basic_product_price(false, $product->post_id, '');
      }
      
      restore_current_blog();

		if(strlen($product->post_title)>35){
			$product_title = mb_substr($product->post_title,0,35,'UTF-8').'...';
		}
		else{
			$product_title = $product->post_title;
		}

	  $content .= '<h3 class="product_name"><a href="' . $permalink . '">' . $product_title . '</a></h3>';
      $content .= $thumbnail;
      $content .= '<div class="product_meta">';
      //price
      $content .= $price;
      //button
      $content .= '<a class="link_buynow btn btn-primary" href="' . $permalink . '">' .  __('Buy Now &raquo;', 'mp') . '</a>';
      $content .= '</div>';

        $content .= '</div>';
     	 $count++;
		  $counter++;
    }
  }


    $content .= '</div>';
 	if (  $wp_query->max_num_pages > 1 ) :

		$content .= '<ul class="pager" style="clear: both; float: none;">';
		$content .= '<li class="previous">'.get_previous_posts_link( '<i class="icon-chevron-left"></i> Προηγούμενο' ).'</li>';
		$content .= '<li class="next">'.get_next_posts_link( __( 'Επόμενο <i class="icon-chevron-right"></i>') ).'</li>';
		$content .= '</ul>';
	endif;

  if ($echo)
    echo $content;
  else
    return $content;
}


/*
 * function mp_product
 * Displays a single product according to preference
 * 
 * @param bool $echo Optional, whether to echo or return
 * @param int $product_id the ID of the product to display
 * @param bool $title Whether to display the title
 * @param bool/string $content Whether and what type of content to display. Options are false, 'full', or 'excerpt'. Default 'full'
 * @param bool/string $image Whether and what context of image size to display. Options are false, 'single', or 'list'. Default 'single'
 * @param bool $meta Whether to display the product meta
 */
function basic_product($echo = true, $product_id, $title = true, $content = 'full', $image = 'single', $meta = true) {
  global $mp;
  $post = get_post($product_id);

  $content = '<div '.basic_product_class(false, 'mp_product', $post->ID).'>';
  if ($title)
    $content .= '<h3 class="product_name"><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a></h3>';
  
  if ($content) {
    $content .= '<div class="product_content">';
    if ($image)
      $content .= basic_product_image( false, $image, $post->ID );
    if ($content == 'excerpt')
      $content .= $mp->product_excerpt($post->post_excerpt, $post->post_content, $post->ID);
    else
      $content .= apply_filters('the_content', $post->post_content);
    $content .= '</div>';
  }
  
  if ($meta) {
    $content .= '<div class="product_meta">';
    //price
    $content .= basic_product_price(false, $post->ID);
    //button
    $content .= basic_buy_button(false, 'single', $post->ID);
    $content .= '</div>';
  }
  $content .= '</div>';
      
  if ($echo)
    echo $content;
  else
    return $content;
}



function basic_global_categories_list( $args = '' ) {
  global $wpdb;
  $settings = get_site_option( 'mp_network_settings' );
  
  $defaults = array(
		'echo' => 1,
    'limit' => 50,
		'order_by' => 'count',
    'order' => 'DESC',
		'show_count' => 0,
		'include' => 'categories'
	);

  $r = wp_parse_args( $args, $defaults );
  extract( $r );

  $order_by = ($order_by == 'name') ? $order_by : 'count';
  $order = ($order == 'ASC') ? $order : 'DESC';
  $limit = intval($limit);

  //include categories as well
  if ($include == 'tags')
    $where = " WHERE t.type = 'product_tag'";
  else if ($include == 'categories')
    $where = " WHERE t.type = 'product_category'";

  $tags = $wpdb->get_results( "SELECT name, slug, type, count(post_id) as count FROM {$wpdb->base_prefix}mp_terms t LEFT JOIN {$wpdb->base_prefix}mp_term_relationships r ON t.term_id = r.term_id$where GROUP BY t.term_id ORDER BY $order_by $order LIMIT $limit", ARRAY_A );

	if ( !$tags )
		return;

  //sort by name
  foreach ($tags as $tag) {
    //skip empty tags
    if ( $tag['count'] == 0 )
      continue;

    if ($tag['type'] == 'product_category')
      $link = get_home_url( mp_main_site_id(), $settings['slugs']['marketplace'] . '/' . $settings['slugs']['categories'] . '/' . $tag['slug'] . '/' );
    else if ($tag['type'] == 'product_tag')
      $link = get_home_url( mp_main_site_id(), $settings['slugs']['marketplace'] . '/' . $settings['slugs']['tags'] . '/' . $tag['slug'] . '/' );

    $list .= '<li><a href="' . $link . '" title="' . sprintf(__( '%d Products', 'mp' ), $tag['count']) . '">' . esc_attr( $tag['name'] );
    if ($show_count)
      $list .= ' - ' . $tag['count'];
    $list .= "</a></li>\n";
  }


	if ( $echo )
		echo '<ul id="mp_category_list">' . $list . '</ul>';

	return '<ul id="mp_category_list">' . $list . '</ul>';
}


/**
 * Display or retrieve the HTML list of categories.
 *
 * The list of arguments is below:
 *     'show_option_all' (string) - Text to display for showing all categories.
 *     'orderby' (string) default is 'ID' - What column to use for ordering the
 * categories.
 *     'order' (string) default is 'ASC' - What direction to order categories.
 *     'show_count' (bool|int) default is 0 - Whether to show how many posts are
 * in the category.
 *     'hide_empty' (bool|int) default is 1 - Whether to hide categories that
 * don't have any posts attached to them.
 *     'use_desc_for_title' (bool|int) default is 1 - Whether to use the
 * description instead of the category title.
 *     'feed' - See {@link get_categories()}.
 *     'feed_type' - See {@link get_categories()}.
 *     'feed_image' - See {@link get_categories()}.
 *     'child_of' (int) default is 0 - See {@link get_categories()}.
 *     'exclude' (string) - See {@link get_categories()}.
 *     'exclude_tree' (string) - See {@link get_categories()}.
 *     'echo' (bool|int) default is 1 - Whether to display or retrieve content.
 *     'current_category' (int) - See {@link get_categories()}.
 *     'hierarchical' (bool) - See {@link get_categories()}.
 *     'title_li' (string) - See {@link get_categories()}.
 *     'depth' (int) - The max depth.
 *
 * @since 2.1.0
 *
 * @param string|array $args Optional. Override default arguments.
 * @return string HTML content only if 'echo' argument is 0.
 */
function basic_wp_list_categories( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'show_option_none' => __('No categories'),
		'orderby' => 'name', 'order' => 'ASC',
		'style' => 'list',
		'show_count' => 0, 'hide_empty' => 1,
		'use_desc_for_title' => 1, 'child_of' => 0,
		'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '',
		'exclude_tree' => '', 'current_category' => 0,
		'hierarchical' => true, 'title_li' => __( 'Categories' ),
		'echo' => 1, 'depth' => 0,
		'taxonomy' => 'category'
	);

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
		$r['pad_counts'] = true;

	if ( true == $r['hierarchical'] ) {
		$r['exclude_tree'] = $r['exclude'];
		$r['exclude'] = '';
	}

	if ( !isset( $r['class'] ) )
		$r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

	extract( $r );

	if ( !taxonomy_exists($taxonomy) )
		return false;

	$categories = get_categories( $r );

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="' . esc_attr( $class ) . '">' . $title_li . '<ul>';

	if ( empty( $categories ) ) {
		if ( ! empty( $show_option_none ) ) {
			if ( 'list' == $style )
				$output .= '<li>' . $show_option_none . '</li>';
			else
				$output .= $show_option_none;
		}
	} else {
		if ( ! empty( $show_option_all ) ) {
			$posts_page = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
			$posts_page = esc_url( $posts_page );
			if ( 'list' == $style )
				$output .= "<li><a href='$posts_page'>$show_option_all</a></li>";
			else
				$output .= "<a href='$posts_page'>$show_option_all</a>";
		}

		if ( empty( $r['current_category'] ) && ( is_category() || is_tax() || is_tag() ) ) {
			$current_term_object = get_queried_object();
			if ( $r['taxonomy'] == $current_term_object->taxonomy )
				$r['current_category'] = get_queried_object_id();
		}

		if ( $hierarchical )
			$depth = $r['depth'];
		else
			$depth = -1; // Flat.

		$output .= walk_category_tree( $categories, $depth, $r );
	}

	if ( $title_li && 'list' == $style )
		$output .= '</ul></li>';

	$output = apply_filters( 'wp_list_categories', $output, $args );

	if ( $echo )
		echo $output;
	else
		return $output;
}

/*
 * function mp_global_products_nav_link
 * 
 * The list of arguments is below:
 *    bool echo Optional, whether to echo or return
 *    int page Optional, The page number to display in the product list if $paginate is set to true. Default: 0
 *    int per_page Optional, How many products to display in the product list if $paginate is set to true. Default: 20
 *    string category Optional, limit to a product category, use slug
 *    string tag Optional, limit to a product tag, use slug
 *
 * @param string|array $args Optional. Override default arguments.
 */
function basic_global_products_nav_link( $args = '' ) {
  global $wpdb, $mp;
	
  $defaults = array(
		'echo' => true,
		'page' => false, 
    'per_page' => 20,
		'category' => '',
    'tag' => '',
		'sep' => ' &#8212; ',
		'prelabel' => __('&laquo; Previous', 'mp'),
		'nxtlabel' => __('Next &raquo;', 'mp')
	);

  $r = wp_parse_args( $args, $defaults );
  extract( $r );

  //setup taxonomy if applicable
  if ($category) {
    $category = $wpdb->escape( sanitize_title( $category ) );
    $query = "SELECT COUNT(*) FROM {$wpdb->base_prefix}mp_products p INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_category' AND t.slug = '$category'";
  } else if ($tag) {
    $tag = $wpdb->escape( sanitize_title( $tag ) );
    $query = "SELECT COUNT(*) FROM {$wpdb->base_prefix}mp_products p INNER JOIN {$wpdb->base_prefix}mp_term_relationships r ON p.id = r.post_id INNER JOIN {$wpdb->base_prefix}mp_terms t ON r.term_id = t.term_id WHERE p.blog_public = 1 AND t.type = 'product_tag' AND t.slug = '$tag'";
  } else {
    $query = "SELECT COUNT(*) FROM {$wpdb->base_prefix}mp_products p WHERE p.blog_public = 1";
  }

  //The Query
  $total = $wpdb->get_var( $query );
	
	//setup last page
	$max_pages = ceil($total / $per_page);
	if ($max_pages < 1)
		$max_pages = 1;
	
	//setup current page
	if ($page !== false) {
		$paged = $page; //pages start at 1 for our uses
	} else {
		$paged = intval(get_query_var('paged'));
	}
	if ($paged < 1)
		$paged = 1;
	
	//if only one page skip
	if ($paged > $max_pages)
		return '';
	
	//only have sep if there's both prev and next results
	if ($paged < 2 || $paged >= $max_pages) {
		$sep = '';
	}
	
	$return = '';
	
	if ( $max_pages > 1 ) {
		//previous
		if ( $paged > 1 ) {
			$attr = apply_filters( 'previous_posts_link_attributes', '' );
			$prevpage = intval($paged) - 1;
			if ( $prevpage < 1 )
				$prevpage = 1;
			$return .= '<li class="previous"><a href="' . get_pagenum_link($prevpage) . "\" $attr>".'<i class="icon-chevron-left"></i> Προηγούμενο</a></li>';
		}
		
		$nextpage = intval($paged) + 1;
		if ( $nextpage <= $max_pages ) {
			$attr = apply_filters( 'next_posts_link_attributes', '' );
			$nextpage = intval($paged) + 1;
			$return .= '<li class="next"><a href="' . get_pagenum_link($nextpage) . "\" $attr>" . 'Επόμενο <i class="icon-chevron-right"></i></a></li>';
		}
		
	}
	
	$return = '<ul class="pager">' . $return . '</ul>';
	
	if ($echo)
		echo $return;
	else
		return $return;
}
