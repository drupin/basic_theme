<?php

// Return post entry meta information
function basic_entry_meta() {
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('Posted on %s at %s.', 'basic'), get_the_date(), get_the_time()) .'</time>';
  echo '<p class="byline author vcard">'. __('Written by', 'basic') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></p>';
}
