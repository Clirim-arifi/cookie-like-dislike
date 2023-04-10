<?php
/*
Plugin Name: Cookie Like Dislike
Description: A plugin to add like and dislike functionality to posts
Version: 1.0
Author: Çlirim Arifi
Author URI: https://linkedin.com/in/clirimarifi
*/

/**
 * Admin Functionality
 */
require plugin_dir_path(__FILE__) . 'admin/admin.php';

function update_like_dislike_counts()
{
  check_ajax_referer('like-dislike-nonce', 'nonce');
  $post_id = intval($_POST['post_id']);
  $type = sanitize_text_field($_POST['type']);
  $likes = intval(get_post_meta($post_id, 'likes', true));
  $dislikes = intval(get_post_meta($post_id, 'dislikes', true));
  if ($type === 'like') {
    update_post_meta($post_id, 'likes', $likes + 1);
  } elseif ($type === 'dislike') {
    update_post_meta($post_id, 'dislikes', $dislikes + 1);
  } elseif ($type === 'remove_dislike') {
    update_post_meta($post_id, 'dislikes', $dislikes - 1);
  } elseif ($type === 'remove_like') {
    update_post_meta($post_id, 'likes', $likes - 1);
  }
  wp_send_json(array(
    'likes' => $likes,
    'dislikes' => $dislikes,
  ));
}
add_action('wp_ajax_update_like_dislike_counts', 'update_like_dislike_counts');
add_action('wp_ajax_nopriv_update_like_dislike_counts', 'update_like_dislike_counts');

function my_like_dislike_enqueue_scripts()
{
  if (is_single()) {
    wp_enqueue_script('cookies-script', 'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js', array(), '1.0.0', true, true);

    wp_enqueue_style('like-dislike-style', plugin_dir_url(__FILE__) . 'assets/css/index.css', array(), '1.0.0', 'all');

    wp_enqueue_script('like-dislike', plugin_dir_url(__FILE__) . 'assets/js/index.js', array('jquery'), '1.0.0', true);
    wp_localize_script('like-dislike', 'likeDislike', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('like-dislike-nonce'),
    ));
  }
}
add_action('wp_enqueue_scripts', 'my_like_dislike_enqueue_scripts');
