<?php
  class KdGFablab_IS_Admin {
    private static $initiated = false;

    public static function init() {
      if (!self::$initiated) {
        self::init_hooks();
      }
    }

    private static function init_hooks() {
      self::$initiated = true;


      add_action('admin_notices', array('KdGFablab_IS_Admin', 'kdg_fablab_is_admin_notice'));
      //add_action('add_meta_boxes', array('KdGFablab_IS_Admin', 'kdg_fablab_is_custom_fields_to_edit'));
    }

    /**
     * Inform the admin on how to add new machines
     */
    public static function kdg_fablab_is_admin_notice() {
      if (get_transient('kdg-fablab-is-admin-notice')) {
        ?>
        <div class="updated notice-is-dismissible">
          <p>
            Om nieuwe toestellen toe te voegen, klik op <strong>Toestellen</strong> in het menu.
          </p>
        </div>
        <?php
          // delete the transient, so it only gets displayed once
          delete_transient('kdg-fablab-is-admin-notice');
      }
    }

    public static function kdg_fablab_is_custom_fields_to_edit() {
      //add_meta_box('test_field', "Custom test field", array('KdGFablab_IS_Admin', 'kdg_fablab_is_show_custom_fields'), 'machine', 'side', 'high');
    }

    public static function kdg_fablab_is_show_custom_fields($post) {
      /*wp_nonce_field(array('KdGFablab_IS_Admin', 'kdg_fablab_test_meta_box_nonce'));
      $value = get_post_meta($post->ID, '_test_field_value_key', true);

      echo '<label for="kdg_fablab_is_test_field">Test field adress</label>';
      echo '<input
              type="email"
              id="kdg_fablab_is_test_field"
              name="kdg_fablab_is_test_field"
              value="' . esc_attr($value) . '"
              size="25" />';*/
    }
  }
