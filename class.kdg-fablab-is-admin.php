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

      add_action("admin_init", array("KdGFablab_IS_Admin", "kdg_fablab_is_admin_register_fablab_settings"));
      add_action("admin_menu", array("KdGFablab_IS_Admin", "kdg_fablab_is_admin_settings_menu"));
      add_action('admin_notices', array('KdGFablab_IS_Admin', 'kdg_fablab_is_admin_notice'));
      add_action("manage_workshop_posts_custom_column", array("KdGFablab_IS_Admin", "kdg_fablab_is_manage_admin_columns_data"), 10, 2);

      add_filter('manage_workshop_posts_columns', array("KdGFablab_IS_Admin", "kdg_fablab_is_manage_admin_columns"));
    }

    /**
     * Register settings for Inventory plugin
     */
    public static function kdg_fablab_is_admin_register_fablab_settings() {
      register_setting("kdg_fablab_is_option-group", "kdg_fablab_is_posts_per_page");
    }

    /**
     * Add a settings menu to the default settings menu from WordPress
     */
    public static function kdg_fablab_is_admin_settings_menu() {
      add_options_page(
        "KdG Fablab Inventaris Instellingen",
        "Fablab Inventaris",
        "manage_options",
        "kdg-fablab-inventaris",
        ["KdGFablab_IS_Admin", "kdg_fablab_is_admin_display_settings_page"]
      );
    }

    /**
     * Display content for the settings page of this plugin
     */
    public static function kdg_fablab_is_admin_display_settings_page() {
      if (!current_user_can("manage_options")) {
        wp_die("You do not have sufficient permissions to access this page.");
      }
    ?>
    <div class="wrap">
      <h2>KdG Fablab Inventaris Instellingen</h2>
      <form method="post" action="options.php">
        <?php
          settings_fields("kdg_fablab_is_option-group");
          do_settings_fields("kdg_fablab_is_option-group", "");
        ?>
        <table class="form-table">
          <tbody>
            <tr>
              <th scope="row">
                <label for="kdg_fablab_is_posts_per_page">Inventaris pagina's tonen maximaal</label>
              </th>
              <td>
                <input name="kdg_fablab_is_posts_per_page" type="number" min="1" max="10" step="1" value="<?php echo get_option("kdg_fablab_is_posts_per_page"); ?>" /> berichten
              </td>
            </tr>
          </tbody>
        </table>
        <?php
          submit_button();
        ?>
      </form>
    </div>
    <?php
    }

    /**
     * Add admin columns to workshops overview (admin)
     */
    public static function kdg_fablab_is_manage_admin_columns() {
      $columns['title'] = "Titel";
      $columns['taxonomy-kdg_fablab_is_type'] = "Type";

      $columns['workshop-date'] = "Datum";
      $columns["workshop-start"] = "Startuur";
      $columns['workshop-end'] = "Einduur";

      return $columns;
    }

    /**
     * Fetch data for each custom column in reservation overview (admin)
     */
    public static function kdg_fablab_is_manage_admin_columns_data($column, $post_id) {
      switch($column) {
        case "workshop-date":
          echo get_field("workshop_datum", $post_id, true);
          break;

        case "workshop-start":
          echo get_field("start_tijd", $post_id, true);
          break;

        case "workshop-end":
          echo get_field("eind_tijd", $post_id, true);
          break;

        default:
          break;
      }
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

      if (get_transient('kdg-fablab-is-admin-notice-page-machines-made')) {
      ?>
        <div class="updated notice-is-dismissible">
          <p>
            Toestelpagina aangemaakt!
          </p>
          <p>
            Om deze pagina toe te voegen aan het menu, ga naar: Weegave > Menu's.
          </p>
        </div>
      <?php
        // delete the transient, so it only gets displayed once
        delete_transient('kdg-fablab-is-admin-notice-page-machines-made');
      }

      if (get_transient('kdg-fablab-is-admin-notice-page-workshops-made')) {
      ?>
        <div class="updated notice-is-dismissible">
          <p>
            Workshoppagina aangemaakt!
          </p>
          <p>
            Om deze pagina toe te voegen aan het menu, ga naar: Weegave > Menu's.
          </p>
        </div>
      <?php
        // delete the transient, so it only gets displayed once
        delete_transient('kdg-fablab-is-admin-notice-page-workshops-made');
      }
    }
  }
