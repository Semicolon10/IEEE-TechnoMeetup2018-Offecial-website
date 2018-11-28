<?php
namespace PressElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Text Typing Effect
 *
 * Elementor widget for text typing effect.
 *
 * @since 1.7.0
 */
class Press_Elements_Typing_Effect extends Widget_Base {

	public function get_name() {
		return 'typing-effect';
	}

	public function get_title() {
		return __( 'Typing Effect', 'press-elements' );
	}

	public function get_icon() {
		return 'fa fa-font';
	}

	public function get_categories() {
		return [ 'press-elements-effects' ];
	}

	public function get_script_depends() {
		return [ 'typedjs', 'typing-effect' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'press-elements' ),
			]
		);

		$this->add_control(
			'prefix_text',
			[
				'label' => __( 'Prefix Text', 'press-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
			]
		);

		$this->add_control(
			'suffix_text',
			[
				'label' => __( 'Suffix Text', 'press-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
			]
		);

		$this->add_control(
			'typed_text',
			[
				'label' => __( 'Text', 'press-elements' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'string' => __( 'Type out sentences', 'press-elements' ),
					],
					[
						'string' => __( 'and then delete them', 'press-elements' ),
					],
					[
						'string' => __( 'with a beautiful animation', 'press-elements' ),
					],
				],
				'fields' => [
					[
						'name' => 'string',
						'label' => __( 'Text', 'press-elements' ),
						'type' => Controls_Manager::TEXT,
					],
				],
				'title_field' => '{{{ string }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			[
				'label' => __( 'Settings', 'press-elements' ),
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => __( 'HTML Tag', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'p',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'p',
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Speed (ms)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'ms',
				],
			]
		);

		$this->add_control(
			'back_speed',
			[
				'label' => __( 'Back-spacing Speed (ms)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'ms',
				],
			]
		);

		$this->add_control(
			'start_delay',
			[
				'label' => __( 'Time before typing starts (ms)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'ms',
				],
			]
		);

		$this->add_control(
			'back_delay',
			[
				'label' => __( 'Time before back-spacing (ms)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 2000,
					'unit' => 'ms',
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => __( 'True', 'press-elements' ),
					'0' => __( 'False', 'press-elements' ),
				],
				'default' => '1',
			]
		);

		$this->add_control(
			'show_cursor',
			[
				'label' => __( 'Show Cursor', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => __( 'True', 'press-elements' ),
					'0' => __( 'False', 'press-elements' ),
				],
				'default' => '1',
			]
		);

		$this->add_control(
			'cursor_char',
			[
				'label' => __( 'Cursor Char', 'press-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => '|',
				'condition' => [
					'show_cursor' => '1'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_prefix',
			[
				'label' => __( 'Style Prefix', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color_prefix',
			[
				'label' => __( 'Text Color', 'press-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-typing-effect .typing-effect-prefix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_prefix',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typing-effect-prefix',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow_prefix',
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typing-effect-prefix',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_suffix',
			[
				'label' => __( 'Style Suffix', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color_suffix',
			[
				'label' => __( 'Text Color', 'press-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-typing-effect .typing-effect-suffix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_suffix',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typing-effect-suffix',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow_suffix',
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typing-effect-suffix',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_strings',
			[
				'label' => __( 'Style Strings', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'press-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-typing-effect .typing-effect-strings' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typing-effect-strings',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typing-effect-strings',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_cursor',
			[
				'label' => __( 'Style Cursor', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cursor' => '1'
				],
			]
		);

		$this->add_control(
			'color_cursor',
			[
				'label' => __( 'Cursor Color', 'press-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-typing-effect .typed-cursor' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_cursor' => '1'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_cursor',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typed-cursor',
				'condition' => [
					'show_cursor' => '1'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow_cursor',
				'selector' => '{{WRAPPER}} .press-elements-typing-effect .typed-cursor',
				'condition' => [
					'show_cursor' => '1'
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		printf( '<%s class="press-elements-typing-effect">', $settings['html_tag'] );
			?>
			<span class="typing-effect-prefix"><?php echo $settings['prefix_text']; ?></span>
			<span class="typing-effect-strings"
				data-strings='<?php echo json_encode( wp_list_pluck( $settings['typed_text'], 'string' ) ); ?>'
				data-speed="<?php echo esc_attr( $settings['speed']['size'] ); ?>"
				data-back-speed="<?php echo esc_attr( $settings['back_speed']['size'] ); ?>"
				data-start-delay="<?php echo esc_attr( $settings['start_delay']['size'] ); ?>"
				data-back-delay="<?php echo esc_attr( $settings['back_delay']['size'] ); ?>"
				data-loop="<?php echo esc_attr( $settings['loop'] ); ?>"
				data-show-cursor="<?php echo esc_attr( $settings['show_cursor'] ); ?>"
				data-cursor-char="<?php echo esc_attr( $settings['cursor_char'] ); ?>"
			></span>
			<span class="typing-effect-suffix"><?php echo $settings['suffix_text']; ?></span>
			<?php
		printf( '</%s>', $settings['html_tag'] );

	}

	protected function _content_template() {
	}

}
