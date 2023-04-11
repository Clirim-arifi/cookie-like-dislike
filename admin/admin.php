<?php

/**
 * Admin Functionality
 */

// Add admin menu
function cookie_like_dislike_add_menu()
{
  add_menu_page(
    'Cookie Like Dislike Settings',
    'Like / Dislike',
    'manage_options',
    'cookie-like-dislike-settings',
    'cookie_like_dislike_settings_page',
    'dashicons-heart'
  );
}
add_action('admin_menu', 'cookie_like_dislike_add_menu');

// Create settings page
function cookie_like_dislike_settings_page()
{
  $current_option = get_option('cookie_like_dislike_option');
  $message = '';
  if (isset($_POST['cookie_like_dislike_option']) && !empty($_POST['cookie_like_dislike_option'])) {
    $current_option = $_POST['cookie_like_dislike_option'];
    update_option('cookie_like_dislike_option', $current_option);
    $message = '<div id="message" class="updated notice notice-success is-dismissible"><p>Settings saved.</p></div>';
  } ?>
  <div class="wrap-all-backend" style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-right: 20px;">
    <div class="wrap">
      <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
      <?php echo $message; ?>
      <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=cookie-like-dislike-settings')); ?>">
        <?php wp_nonce_field('cookie_like_dislike_settings', 'cookie_like_dislike_settings_nonce'); ?>
        <table class="form-table">
          <tr>
            <th scope="row"><label for="cookie-like-dislike-option">Position</label></th>
            <td>
              <select name="cookie_like_dislike_option" id="cookie-like-dislike-option">
                <option value="shortcode" <?php selected($current_option, 'shortcode', true); ?>>Shortcode</option>
                <option value="before" <?php selected($current_option, 'before', true); ?>>Before content</option>
                <option value="after" <?php selected($current_option, 'after', true); ?>>After content</option>
              </select>
            </td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>

    <div class="author-info" style="border-left: 1px solid black; background: #fff; padding: 20px;">
      <h4>Author: <a href="https://linkedin.com/in/clirimarifi">Çlirim Arifi</a></h4>
      <p>Shortcode:</p>
      <p>[cookie_like_dislike_shortcode]</p>
    </div>
  </div>
<?php }

// Register settings
function cookie_like_dislike_register_settings()
{
  if (isset($_POST['cookie_like_dislike_option']) && !empty($_POST['cookie_like_dislike_option'])) {
    register_setting('cookie_like_dislike_settings', 'cookie_like_dislike_option');
  }
}

// Generate HTML code
function cookie_like_dislike_generate_html()
{
  if (is_single()) {
    $post_id = get_the_ID();
    $likes = intval(get_post_meta($post_id, 'likes', true));
    $dislikes = intval(get_post_meta($post_id, 'dislikes', true));
    $html = '
    <form class="cookie-like-dislike">
    ' . wp_nonce_field('cookie-like-dislike-nonce', 'cookie-like-dislike-nonce', true, false) . '
      <div class="like-dislike">
        <a href="javascript:void(0);" class="like" data-post-id="' . $post_id . '">
          <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3.65625 8.125H0.84375C0.351562 8.125 0 8.51172 0 8.96875V17.4062C0 17.8984 0.351562 18.25 0.84375 18.25H3.65625C4.11328 18.25 4.5 17.8984 4.5 17.4062V8.96875C4.5 8.51172 4.11328 8.125 3.65625 8.125ZM2.25 16.8438C1.75781 16.8438 1.40625 16.4922 1.40625 16C1.40625 15.543 1.75781 15.1562 2.25 15.1562C2.70703 15.1562 3.09375 15.543 3.09375 16C3.09375 16.4922 2.70703 16.8438 2.25 16.8438ZM13.5 3.13281C13.5 0.53125 11.8125 0.25 10.9688 0.25C10.2305 0.25 9.91406 1.65625 9.77344 2.28906C9.5625 3.0625 9.38672 3.83594 8.85938 4.36328C7.73438 5.52344 7.13672 6.96484 5.73047 8.33594C5.66016 8.44141 5.625 8.54688 5.625 8.65234V16.1758C5.625 16.3867 5.80078 16.5625 6.01172 16.5977C6.57422 16.5977 7.3125 16.9141 7.875 17.1602C9 17.6523 10.3711 18.25 12.0586 18.25H12.1641C13.6758 18.25 15.4688 18.25 16.1719 17.2305C16.4883 16.8086 16.5586 16.2812 16.3828 15.6484C16.9805 15.0508 17.2617 13.9258 16.9805 13.0117C17.5781 12.2031 17.6484 11.043 17.2969 10.2344C17.7188 9.8125 18 9.14453 17.9648 8.51172C17.9648 7.42188 17.0508 6.4375 15.8906 6.4375H12.3047C12.5859 5.45312 13.5 4.60938 13.5 3.13281Z" fill="#3F1D70" />
          </svg>
          <span class="likes-count">' . $likes . '</span>
        </a>
        <a href="javascript:void(0);" class="dislike" data-post-id="' . $post_id . '">
          <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.3438 10.875L17.1563 10.875C17.6484 10.875 18 10.4883 18 10.0312L18 1.59375C18 1.10156 17.6484 0.75 17.1563 0.75L14.3438 0.75C13.8867 0.75 13.5 1.10156 13.5 1.59375L13.5 10.0312C13.5 10.4883 13.8867 10.875 14.3438 10.875ZM15.75 2.15625C16.2422 2.15625 16.5938 2.50781 16.5938 3C16.5938 3.45703 16.2422 3.84375 15.75 3.84375C15.293 3.84375 14.9063 3.45703 14.9063 3C14.9063 2.50781 15.293 2.15625 15.75 2.15625ZM4.5 15.8672C4.5 18.4687 6.1875 18.75 7.03125 18.75C7.76953 18.75 8.08594 17.3437 8.22656 16.7109C8.4375 15.9375 8.61328 15.1641 9.14063 14.6367C10.2656 13.4766 10.8633 12.0352 12.2695 10.6641C12.3398 10.5586 12.375 10.4531 12.375 10.3477L12.375 2.82422C12.375 2.61328 12.1992 2.4375 11.9883 2.40234C11.4258 2.40234 10.6875 2.08594 10.125 1.83984C9 1.34766 7.62891 0.749999 5.94141 0.749999L5.83594 0.749999C4.32422 0.749999 2.53125 0.749999 1.82813 1.76953C1.51172 2.1914 1.44141 2.71875 1.61719 3.35156C1.01953 3.94922 0.738282 5.07422 1.01953 5.98828C0.421876 6.79687 0.351563 7.95703 0.703126 8.76562C0.281251 9.1875 7.9944e-07 9.85547 0.035157 10.4883C0.0351569 11.5781 0.949219 12.5625 2.10938 12.5625L5.69531 12.5625C5.41406 13.5469 4.5 14.3906 4.5 15.8672Z" fill="#3F1D70" />
          </svg>
          <span class="dislikes-count remove_dislike_' . $post_id . '">' . $dislikes . '</span>
        </a>
      </div>
    </form>';
    return $html;
  } else {
    return '';
  }
}

// Add shortcode
function cookie_like_dislike_shortcode()
{
  $current_option = get_option('cookie_like_dislike_option');
  if ($current_option == 'shortcode') {
    $html = cookie_like_dislike_generate_html();
    return $html;
  }
}
add_shortcode('cookie_like_dislike_shortcode', 'cookie_like_dislike_shortcode');

// Add HTML code before/after content or generate shortcode
function cookie_like_dislike_add_html($content)
{
  $current_option = get_option('cookie_like_dislike_option');
  if ($current_option == 'shortcode') {
    $shortcode = '[cookie_like_dislike_shortcode]';
    $content = str_replace($shortcode, cookie_like_dislike_generate_html(), $content);
  } elseif ($current_option == 'before') {
    $content = cookie_like_dislike_generate_html() . $content;
  } elseif ($current_option == 'after') {
    $content = $content . cookie_like_dislike_generate_html();
  }
  return $content;
}
add_filter('the_content', 'cookie_like_dislike_add_html');
