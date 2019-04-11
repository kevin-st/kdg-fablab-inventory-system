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
      add_action('add_meta_boxes', array('KdGFablab_IS_Admin', 'kdg_fablab_is_custom_fields_to_edit'));
      //add_action('save_post', array('KdGFablab_IS_Admin', 'kdg_fablab_is_save_custom_fields_data'), 10, 2 );
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
          <p>
            Om een nieuwe workshop toe te voegen, klik op <strong>Workshops</strong>.
          </p>
        </div>
        <?php
          // delete the transient, so it only gets displayed once
          delete_transient('kdg-fablab-is-admin-notice');
      }
    }

    public static function kdg_fablab_is_custom_fields_to_edit() {
      $prfx = "prfx_kdg_fablab_";

      if (defined('KDG_FABLAB_IS_PLUGIN_PREFIX')) {
        $prfx = KDG_FABLAB_IS_PLUGIN_PREFIX;
      }

      add_meta_box(
        ($prfx . 'workshop'),
        "Opkomende workshop(s)",
        array('KdGFablab_IS_Admin', 'kdg_fablab_is_show_custom_fields'),
        'machine',
        'side'
      );
    }

    public static function kdg_fablab_is_show_custom_fields($post) {
      wp_nonce_field(basename(__FILE__), 'kdg_fablab_is_nonce_field');

      $value = esc_attr(get_post_meta($post->ID, '_' . KDG_FABLAB_IS_PLUGIN_PREFIX . 'value_key', true));
      ?>
      <p>
        <label for="kdg-fablab-workshop"><?php _e("Voeg de naam van een workshop toe waarbij dit apparaat wordt gebruikt.", 'example' ); ?></label>
      </p>
      <p>
        <input class="widefat" type="text" name="kdg-fablab-workshop" id="kdg-fablab-workshop" value="<?php echo $value; ?>" size="30" />
      </p>
      <?php
    }
  }
