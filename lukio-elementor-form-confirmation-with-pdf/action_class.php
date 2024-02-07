<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor form lukio confirmation email.
 *
 * Custom Elementor form action which add confirmation email to the user.
 *
 * @since 1.0.0
 */
class Lukio_Email_Confirmation extends \ElementorPro\Modules\Forms\Actions\Email
{

    /**
     * Get action name.
     *
     * Retrieve Sendy action name.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function get_name()
    {
        return 'lukio_email_confirmation';
    }

    /**
     * Get action label.
     *
     * Retrieve Sendy action label.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function get_label()
    {
        return esc_html__('Email confirmation', 'lukio-elementor-form-confirmation-with-pdf');
    }

    /**
     * Register action controls.
     *
     * Add input fields to allow the user to customize the action settings.
     *
     * @since 1.0.0
     * @access public
     * @param \Elementor\Widget_Base $widget
     */
    public function register_settings_section($widget)
    {

        $widget->start_controls_section(
            'section_lukio_email_confirmation',
            [
                'label' => $this->get_label(),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $widget->add_control(
            'lukio_email_confirmation_user_email_field',
            [
                'label' => esc_html__('User emile field id', 'lukio-elementor-form-confirmation-with-pdf'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('User field ID from the field Advanced tab.', 'lukio-elementor-form-confirmation-with-pdf'),
            ]
        );

        $widget->add_control(
            'lukio_email_confirmation_email_subject',
            [
                'label' => esc_html__('Email subject', 'lukio-elementor-form-confirmation-with-pdf'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $widget->add_control(
            'lukio_email_confirmation_textarea',
            [
                'label' => esc_html__('Email body', 'lukio-elementor-form-confirmation-with-pdf'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'description' => esc_html__('Text to be in the body of the confirmation email the user receive.', 'lukio-elementor-form-confirmation-with-pdf'),
            ]
        );

        $widget->add_control(
            'lukio_email_confirmation_direction',
            [
                'label' => esc_html__('Email RTL direction', 'lukio-elementor-form-confirmation-with-pdf'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('True to send email with RTL text', 'lukio-elementor-form-confirmation-with-pdf'),
            ]
        );

        $widget->add_control(
            'lukio_email_confirmation_file',
            [
                'label' => esc_html__('Attachment file', 'lukio-elementor-form-confirmation-with-pdf'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['application/pdf'],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Run action.
     *
     * Runs the Sendy action after form submission.
     *
     * @since 1.0.0
     * @access public
     * @param \ElementorPro\Modules\Forms\Classes\Form_Record  $record
     * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
     */
    public function run($record, $ajax_handler)
    {

        $settings = $record->get('form_settings');
        $user_email = $record->get('fields')[$settings['lukio_email_confirmation_user_email_field']]['value'];
        $file = $settings['lukio_email_confirmation_file'];
        $attachment = get_attached_file($file['id']);
        wp_mail(
            $user_email,
            $settings['lukio_email_confirmation_email_subject'],
            '<div style="direction:' . ($settings['lukio_email_confirmation_direction'] == 'yes' ? 'rtl' : 'ltr') . ' ;">' . wpautop($settings['lukio_email_confirmation_textarea']) . '</div>',
            array('Content-Type: text/html; charset=UTF-8'),
            $attachment
        );
    }

    /**
     * On export.
     *
     * Clears Sendy form settings/fields when exporting.
     *
     * @since 1.0.0
     * @access public
     * @param array $element
     */
    public function on_export($element)
    {
        unset(
            $element['lukio_email_confirmation_textarea'],
            $element['lukio_email_confirmation_file'],
            $element['lukio_email_confirmation_user_email_field'],
            $element['lukio_email_confirmation_email_subject'],
            $element['lukio_email_confirmation_direction'],
        );

        return $element;
    }
}
