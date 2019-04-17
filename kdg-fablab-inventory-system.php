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
  register_activation_hook(__FILE__, 'plugin_activation'); // execute on activation
  register_deactivation_hook(__FILE__, 'plugin_deactivation'); // execute on deactivation

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
    set_transient('kdg-fablab-is-admin-notice', true, 5);
  }

  /**
   * Actions to perform on plugin deactivation
   */
  function kdg_fablab_is_plugin_deactivation() {
    // code to be executed when plugin is deactivated
  }
