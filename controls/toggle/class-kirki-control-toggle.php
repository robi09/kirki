<?php
/**
 * Customizer Control: toggle.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Toggle control (modified checkbox).
 */
class Kirki_Control_Toggle extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-toggle';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * The kirki_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $kirki_config = 'global';

	/**
	 * The translation strings.
	 *
	 * @access protected
	 * @since 2.3.5
	 * @var array
	 */
	protected $l10n = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'kirki-toggle', trailingslashit( Kirki::$url ) . 'controls/toggle/toggle.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_style( 'kirki-toggle-css', trailingslashit( Kirki::$url ) . 'controls/toggle/toggle.css', null );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['output']      = $this->output;
		$this->json['value']       = $this->value();
		$this->json['choices']     = $this->choices;
		$this->json['link']        = $this->get_link();
		$this->json['id']          = $this->id;
		$this->json['l10n']        = $this->l10n;
		$this->json['kirkiConfig'] = $this->kirki_config;

		if ( 'user_meta' === $this->option_type ) {
			$this->json['value'] = get_user_meta( get_current_user_id(), $this->id, true );
		}

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label for="toggle_{{ data.id }}">
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<input {{{ data.inputAttrs }}} name="toggle_{{ data.id }}" id="toggle_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> hidden />
			<span class="switch"></span>
		</label>
		<?php
	}
}
