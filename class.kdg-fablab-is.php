<?php
  class KdGFablab_IS {
    private static $initiated = false;

    /**
     * Initialize the plugin
     */
     public static function init() {
       if (!self::$initiated) {
         self::init_hooks();
         self::register_custom_post_types();
       }
     }

     /**
      * Initialize WordPress hooks
      */
    private static function init_hooks() {
      self::$initiated = true;

      add_filter('pre_get_posts', array('KdGFablab_IS', 'query_post_type'));
    }

    public static function query_post_type($query) {
      if (is_category()) {
        $post_type = get_query_var('post_type');

        if ($post_type) {
          $post_type = $post_type;
        } else {
          $post_type = [
            'nav_menu_item',
            'post',
            'toestellen'
          ];
        }

        $query->set('post_type', $post_type);
        return $query;
      }
    }

    /**
     * Enable custom post types for this plugin.
     */
    private static function register_custom_post_types() {
      // machine post type
      register_post_type('machine',
        [
          'description' => 'Een toestel wordt gebruikt in het KdG Fablab',
          'labels' => [
            'add_new' => 'Nieuw toestel',
            'add_new_item' => 'Nieuw toestel toevoegen',
            'all_items' => 'Alle toestellen',
            'edit_item' => 'Toestel bijwerken',
            'name' => 'Toestellen',
            'singular_name' => 'Toestel'
          ],
          'has_archive' => true,
          'menu_icon' => 'dashicons-admin-generic',
          'public' => true,
          'query_var' => true,
          'supports' => [ 'title', 'editor', 'excerpt', 'custom-fields' ],
          'rewrite' => ['slug' => 'toestellen'],
          'taxonomies' => [
            'category'
          ]
        ]);

      // workshop post type
      register_post_type('workshop',
        [
          'description' => 'Een toestel wordt gebruikt in het KdG Fablab',
          'labels' => [
            'add_new' => 'Nieuwe workshop',
            'add_new_item' => 'Nieuwe workshop toevoegen',
            'all_items' => 'Alle workshops',
            'edit_item' => 'Workshop bijwerken',
            'name' => 'Workshops',
            'singular_name' => 'Workshop'
          ],
          'has_archive' => true,
          'menu_icon' => 'dashicons-calendar',
          'public' => true,
          'query_var' => true,
          'supports' => [ 'title', 'editor', 'excerpt', 'custom-fields' ],
          'rewrite' => ['slug' => 'workshops'],
          'taxonomies' => [
            'category'
          ]
        ]);
    }
  }
