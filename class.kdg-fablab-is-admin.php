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
  }
