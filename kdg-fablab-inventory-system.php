<?php
  /**
   * @package KdG_Fablab_Inventory_System
   */
  /*
    Plugin Name: KdG Fablab Inventory System
    Description: Voeg machines toe, bewerk ze en verwijder ze in het KdG Fablab.
    Author: K3
    Version: 1.0.0
    Liscense: MIT
  */

  // make sure direct access to the plugin is blocked
  if (!defined('ABSPATH')) {
    die;
  }

  // define constants
  define('KDG_FABLAB_IS_VERSION', '1.0.0');
  define('KDG_FABLAB_IS_PLUGIN_DIR', plugin_dir_path(__FILE__));
  define('KDG_FABLAB_IS_PLUGIN_PREFIX', 'kdg_fablab_is_');

  // requirements
  require_once(KDG_FABLAB_IS_PLUGIN_DIR . 'class.kdg-fablab-is.php');

  // define hooks
  register_activation_hook(__FILE__, 'kdg_fablab_is_plugin_activation'); // execute on activation
  register_deactivation_hook(__FILE__, 'kdg_fablab_is_plugin_deactivation'); // execute on deactivation

  // execute KdGFablab_IS.init() when plugin is initialized
  add_action('init', array('KdGFablab_IS', 'init'));

  // when the current user is an admin
  if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    require_once(KDG_FABLAB_IS_PLUGIN_DIR . 'class.kdg-fablab-is-admin.php');

    // execute KdGFablab_Admin.init() when plugin is initialized
    add_action('init', array('KdGFablab_IS_Admin', 'init'));
  }

  // functions
  /**
   * Actions to perform on plugin activation
   */
  function kdg_fablab_is_plugin_activation() {
    // code to be executed when plugin is activated
    if (!current_user_can('activate_plugins')) {
      return;
    }

    kdg_fablab_is_update_settings();

    set_transient('kdg-fablab-is-admin-notice', true, 5);

    global $wpdb;

    if ($wpdb->get_row("SELECT post_name FROM $wpdb->posts WHERE post_name = 'toestellen'", 'ARRAY_A') === NULL) {
      set_transient("kdg-fablab-is-admin-notice-page-machines-made", true, 5);

      wp_insert_post([
        "post_title"    => "Toestellen",
        "post_status"   => "publish",
        "post_author"   => 1,
        "post_type"     => "page"
      ]);
    }

    if ($wpdb->get_row("SELECT post_name FROM $wpdb->posts WHERE post_name = 'workshops'", 'ARRAY_A') === NULL) {
      set_transient("kdg-fablab-is-admin-notice-page-workshops-made", true, 5);

      wp_insert_post([
        "post_title"    => "Workshops",
        "post_status"   => "publish",
        "post_author"   => 1,
        "post_type"     => "page"
      ]);
    }
  }

  /**
   * Actions to perform on plugin deactivation
   */
  function kdg_fablab_is_plugin_deactivation() {
    // code to be executed when plugin is deactivated
  }

  /**
   * Initialize and update settings for the inventory plugin
   */
  function kdg_fablab_is_update_settings() {
    update_option("kdg_fablab_is_posts_per_page", "4");
  }
