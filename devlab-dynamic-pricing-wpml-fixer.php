<?php
/**
 * Plugin Name: Devlab Woocommerce Dynamic Pricing - WPML fixer
 * Plugin URI: https://github.com/fortee/devlab-dynamic-pricing-wpml-fixer
 *
 * Description: Enables a workaround for the problem with  Woocommerce Dynamic Pricing + WPML,
 * where you can't add Category discounts for each of your languages as Dynamic Pricing will overwrite previous language settings
 *
 * Version: 0.0.1
 * Author: István Csányi
 * Author URI: https://devlab.hu
 * Requires at least: 4.4
 * Tested up to: 4.8
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: devlab-dynamic-pricing-wpml-fixer
 *
 * @package devlab-dynamic-pricing-wpml-fixer
 * @author István Csányi
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Devlab_Woocommerce_Dynamic_Pricing_WPML_Fixer')) :

    class Devlab_Woocommerce_Dynamic_Pricing_WPML_Fixer
    {
        function __construct()
        {
            add_action('current_screen', array($this, 'remove_wpml_term_filters'));
        }

        public function remove_wpml_term_filters()
        {
            $screen = get_current_screen();

            if ($screen->id == 'woocommerce_page_wc_dynamic_pricing' && (isset($_GET['tab']) && $_GET['tab'] == 'category')) {
                global $sitepress;
                remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'));
                remove_filter('get_term', array($sitepress, 'get_term_adjust_id'));
                remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
            }

        }

    }

    new Devlab_Woocommerce_Dynamic_Pricing_WPML_Fixer();

endif;