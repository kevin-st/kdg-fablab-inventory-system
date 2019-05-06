<?php
  class KdGFablab_IS {
    private static $_initiated = false;

    /**
     * Initialize the plugin
     */
     public static function init() {
       if (!self::$_initiated) {
         self::init_hooks();
         self::kdg_fablab_is_register_custom_post_types();
         self::kdg_fablab_is_register_custom_taxonomies();
       }
     }

     /**
      * Initialize WordPress hooks
      */
    private static function init_hooks() {
      self::$_initiated = true;

      add_filter("pre_get_posts", array("KdGFablab_IS", "kdg_fablab_is_query_post_type"));
    }

    public static function kdg_fablab_is_query_post_type($query) {
      if ($query->is_main_query() && !is_admin() && (is_post_type_archive('machine') || is_post_type_archive('workshop'))) {
  	    $query->set('posts_per_page', get_option("kdg_fablab_is_posts_per_page"));
  	  }
    }

    /**
     * Enable custom post types for this plugin.
     */
    private static function kdg_fablab_is_register_custom_post_types() {
      // machine post type
      register_post_type("machine",
        [
          "description" => "Een toestel wordt gebruikt in het KdG Fablab",
          "labels" => [
            "add_new"       => __("Nieuw toestel"),
            "add_new_item"  => __("Nieuw toestel toevoegen"),
            "all_items"     => __("Alle toestellen"),
            "edit_item"     => __("Toestel bijwerken"),
            "name"          => __("Toestellen"),
            "search_items"      => __("Toestel zoeken"),
            "singular_name" => __("Toestel")
          ],
          "has_archive" => true,
          "menu_icon" => "dashicons-admin-generic",
          "public" => true,
          "query_var" => true,
          "supports" => [ "title", "editor", "excerpt", "thumbnail" ],
          "rewrite" => ["slug" => "toestellen"]
        ]);

      // workshop post type
      register_post_type("workshop",
        [
          "description" => "Een toestel wordt gebruikt in het KdG Fablab",
          "labels" => [
            "add_new"       => __("Nieuwe workshop"),
            "add_new_item"  => __("Nieuwe workshop toevoegen"),
            "all_items"     => __("Alle workshops"),
            "edit_item"     => __("Workshop bijwerken"),
            "name"          => __("Workshops"),
            "search_items"      => __("Workshop zoeken"),
            "singular_name" => __("Workshop")
          ],
          "has_archive" => true,
          "menu_icon" => "dashicons-calendar",
          "public" => true,
          "query_var" => true,
          "supports" => [ "title", "editor", "excerpt", "thumbnail" ],
          "rewrite" => ["slug" => "workshops"]
        ]);

      flush_rewrite_rules();
    }

    /**
     * Enable custom taxonomies for this plugin.
     */
    private static function kdg_fablab_is_register_custom_taxonomies() {
      // machine/workshop taxonomy
      register_taxonomy("kdg_fablab_is_type", [ "machine", "workshop" ], [
        "hierarchical" => true,
        "labels" => [
          "name"              => __("Type"),
          "singular_name"     => __("Type"),
          "search_items"      => __("Doorzoek types"),
          "all_items"         => __("Alle types"),
          "parent_item"       => __("Hoofdtype"),
          "parent_item_colon" => __("Hoofdtype"),
          "edit_item"         => __("Type bijwerken"),
          "update_item"       => __("Type updaten"),
          "add_new_item"      => __("Voeg nieuw type toe"),
          "new_item_name"     => __("Nieuw type"),
          "menu_name"         => __("Types"),
          "not_found"         => __("Geen types gevonden.")
        ],
        "public" => true,
        "rewrite" => [ "slug" => "types" ],
        "show_admin_column" => true
      ]);

      register_taxonomy_for_object_type("kdg_fablab_is_type", "machine");
      register_taxonomy_for_object_type("kdg_fablab_is_type", "workshop");
    }
  }
