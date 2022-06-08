<?php

/**
 * Woo Product Page Wa Button
 *
 * @package       WOOPRODUCT
 * @author        Salvatore Forino
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Woo Product Page Wa Button
 * Plugin URI:    https://github.com/salvymc
 * Description:   Add whatsapp button on the product page
 * Version:       1.0.0
 * Author:        Salvatore Forino
 * Author URI:    https://github.com/salvymc
 * Text Domain:   woo-product-page-wa-button
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

//Aggiunge il link alle impostazioni nella lista plugin di wordpress
function plugin_add_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=woo-product-page-wa-button">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'plugin_add_settings_link');

// Imposta pagina nel menu 
// Dichiara pagina impostazioni
function dbi_add_settings_page()
{
    add_options_page('Woo Product Page Wa Button', 'Wa Button', 'manage_options', 'woo-product-page-wa-button', 'dbi_render_plugin_settings_page');
}
add_action('admin_menu', 'dbi_add_settings_page');

//Visualizza form e segnaposti
function dbi_render_plugin_settings_page()
{
?>
    <h2>Woo Product Page Wa Button</h2>
    <form action="options.php" method="post">
        <?php
        settings_fields('woo_product_page_wa_button_options');
        do_settings_sections('dbi_example_plugin'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" />
    </form>
<?php
}

function dbi_register_settings()
{
    register_setting('woo_product_page_wa_button_options', 'woo_product_page_wa_button_options');
    add_settings_section('api_settings', 'Settings', 'dbi_plugin_section_text', 'dbi_example_plugin');

    add_settings_field('woo_product_page_wa_button_number', 'Phone', 'woo_product_page_wa_button_number', 'dbi_example_plugin', 'api_settings');
}

add_action('admin_init', 'dbi_register_settings');

function dbi_plugin_section_text()
{
    echo '<p>Enter the phone number with the area code Es: 391234567891</p>';
}

function woo_product_page_wa_button_number()
{
    $options = get_option('woo_product_page_wa_button_options');
    echo "<input id='woo_product_page_wa_button_number' name='woo_product_page_wa_button_options[wa_number]' type='text' value='" . esc_attr($options['wa_number']) . "' />";
}

add_action('woocommerce_after_add_to_cart_form', 'mish_before_add_to_cart_btn');

function mish_before_add_to_cart_btn()
{
    echo '<a href="https://wa.me/+' . get_option('woo_product_page_wa_button_options')['wa_number'] . '"> <button class="btn button"><span class="dashicons dashicons-whatsapp"></span> ORDINA SU WHATSAPP</button></a>';
}
