<?php
/**
 * Plugin Name: WP REST API Cache Remover
 * Description: Disable caching for WordPress REST API
 * Author: Ben Schattinger
 * Author URI: https://github.com/lights0123
 * Version: 1.0.0
 * Plugin URI: https://github.com/lights0123/wp-rest-api-cache
 * License: GPL2+
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_REST_Cache_Remover')) {

    class WP_REST_Cache_Remover
    {

        const VERSION = '1.0.0';

        public static function init()
        {
            self::hooks();
        }

        private static function hooks()
        {
            add_filter('rest_pre_dispatch', array(__CLASS__, 'pre_dispatch'), 10, 3);
        }

        public static function pre_dispatch($result, $server)
        {
            if (method_exists($server, 'send_headers')) {
                $server->send_headers(array('Cache-Control' => 'public, max-age=30'));
            }

            return $result;
        }
    }

    add_action('init', array('WP_REST_Cache_Remover', 'init'));

}
