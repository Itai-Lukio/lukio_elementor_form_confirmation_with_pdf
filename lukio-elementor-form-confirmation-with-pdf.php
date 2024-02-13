<?php

/**
 * Plugin Name: Lukio Elementor Forms Confirmation Email With PDF
 * Description: Custom addon which adds new confirmation email sent to the inputed email with media fiels.
 * Plugin URI:  https://lukio.pro/
 * Version:     1.0.0
 * Author:      Itai Dotan @lukio
 * Author URI:  https://lukio.pro/
 * Text Domain: lukio-elementor-form-confirmation-with-pdf
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Add new confirmation email.
 *
 * @since 1.0.0
 * @param ElementorPro\Modules\Forms\Registrars\Form_Actions_Registrar $form_actions_registrar
 * @return void
 */
function add_lukio_form_confirmation_action($form_actions_registrar)
{
    include_once(__DIR__ .  '/form-confirmation.class.php');
    $form_actions_registrar->register(new Lukio_Email_Confirmation());
}
add_action('elementor_pro/forms/actions/register', 'add_lukio_form_confirmation_action');
