<?php

// header.php
function basic_head() { do_action('basic_head'); }
function basic_wrap_before() { do_action('basic_wrap_before'); }
function basic_header_before() { do_action('basic_header_before'); }
function basic_header_inside() { do_action('basic_header_inside'); }
function basic_header_after() { do_action('basic_header_after'); }

// 404.php, archive.php, front-page.php, index.php, loop-page.php, loop-single.php,
// loop.php, page-custom.php, page-full.php, page.php, search.php, single.php
function basic_content_before() { do_action('basic_content_before'); }
function basic_content_after() { do_action('basic_content_after'); }
function basic_main_before() { do_action('basic_main_before'); }
function basic_main_after() { do_action('basic_main_after'); }
function basic_post_before() { do_action('basic_post_before'); }
function basic_post_after() { do_action('basic_post_after'); }
function basic_post_inside_before() { do_action('basic_post_inside_before'); }
function basic_post_inside_after() { do_action('basic_post_inside_after'); }
function basic_loop_before() { do_action('basic_loop_before'); }
function basic_loop_after() { do_action('basic_loop_after'); }
function basic_sidebar_before() { do_action('basic_sidebar_before'); }
function basic_sidebar_inside_before() { do_action('basic_sidebar_inside_before'); }
function basic_sidebar_inside_after() { do_action('basic_sidebar_inside_after'); }
function basic_sidebar_after() { do_action('basic_sidebar_after'); }

// footer.php
function basic_footer_before() { do_action('basic_footer_before'); }
function basic_footer_inside() { do_action('basic_footer_inside'); }
function basic_footer_after() { do_action('basic_footer_after'); }
function basic_footer() { do_action('basic_footer'); }