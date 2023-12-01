<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://bijankhazaei.ir
 * @since             0.0.1
 * @package           WPThreeJS
 *
 * @wordpress-plugin
 * Plugin Name:       WPThreeJS
 * Plugin URI:        https://bijankhazaei.ir
 * Description:       ThreeJS for WP.
 * Version:           0.0.1
 * Author:            Bijan Khazaei
 * Author URI:        https://bijankhazaei.ir
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-threejs
 * Domain Path:       /languages
 */

if (!defined('WPINC')) {
    die();
}

if (!class_exists('WPTJS')) :
    class WPTJS
    {
        /**
         * plugin version
         *
         * @var string
         */
        public string $version = '0.1.0';

        /**
         * Plugin settings
         *
         * @var array
         */
        public array $settings = [];

        public function __construct()
        {
            // do nothing
        }

        public function initialize()
        {
            $this->define('WPTJS', true);
            $this->define('WPTJS_PATH', plugin_dir_path(__FILE__));
            $this->define('WPTJS_BASENAME', plugin_basename(__FILE__));
            $this->define('WPTJS_VERSION', $this->version);

            $this->settings = [
                'name' => __('WP ThreeJs Plugin', 'wp-threejs'),
                'url' => plugin_dir_url(__FILE__),
                'file' => __FILE__,
                'version' => WPTJS_VERSION,
                'basename' => WPTJS_BASENAME
            ];

            require_once WPTJS_PATH . 'includes/utility-functions.php';

            wtj_include('includes/class-wtj-admin.php');
            wtj_include('includes/class-wtj-shortcode.php');

            add_action('init', [$this, 'init']);
        }

        public function init()
        {
            if (!did_action('plugins_loaded')) {
                return;
            }
        }

        /**
         *  Defines a constant if doesnt already exist.
         *
         * @param $name
         * @param bool $value
         * @return void
         */
        public function define($name, bool $value = true)
        {
            if (!defined($name)) {
                define($name, $value);
            }
        }

        /**
         * Returns true if a setting exists for this name.
         *
         * @param string $name The setting name.
         * @return  boolean
         *
         */
        public function has_setting(string $name): bool
        {
            return isset($this->settings[$name]);
        }

        /**
         * Returns a setting or null if doesn't exist.
         *
         * @param string $name The setting name.
         * @return  mixed
         */
        public function get_setting(string $name)
        {
            return $this->settings[$name] ?? null;
        }

        /**
         * Method for deactivate plugin
         * @return void
         */
        public static function deactivate()
        {
            // actions for deactivation plugin
        }

        /**
         * Method for activate plugin
         * @return void
         */
        public static function activate()
        {
            // actions for deactivation plugin
        }
    }

    /**
     * The main function responsible for returning WPTJS Instance.
     *
     * @return  ACF
     */
    function wtj(): ACF
    {
        global $wtj;

        // Instantiate only once.
        if (!isset($wtj)) {
            $wtj = new WPTJS();
            $wtj->initialize();
        }
        return $wtj;
    }

    // Instantiate.
    wtj();

endif;

