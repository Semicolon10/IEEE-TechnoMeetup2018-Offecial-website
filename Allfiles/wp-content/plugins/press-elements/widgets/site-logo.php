<?php
namespace PressElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Press Elements Site Logo
 *
 * Site logo element for elementor.
 *
 * @since 1.2.0
 */
class Press_Elements_Site_logo extends Widget_Base {

	public function get_name() {
		return 'site-logo';
	}

	public function get_title() {
		return __( 'Site Logo', 'press-elements' );
	}

	public function get_icon() {
		return 'fa fa-crosshairs';
	}

	public function get_categories() {
		return [ 'press-elements-site-elements' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Site Logo', 'press-elements' ),
			]
		);

		$this->add_control(
			'preview',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<center>' . get_custom_logo() . '</center>',
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
				'default' => 'div',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'press-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'press-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'press-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'press-elements' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'press-elements' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __( 'Link to', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'press-elements' ),
					'home' => __( 'Home URL', 'press-elements' ),
					'custom' => __( 'Custom URL', 'press-elements' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'press-elements' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'press-elements' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'default' => [
					'url' => '',
				],
				'show_label' => false,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Site Logo', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'space',
			[
				'label' => __( 'Size (%)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-site-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity (%)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-site-logo img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'angle',
			[
				'label' => __( 'Angle (deg)', 'press-elements' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 0,
				],
				'range' => [
					'deg' => [
						'max' => 360,
						'min' => -360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-site-logo img' => '-webkit-transform: rotate({{SIZE}}deg); -moz-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'press-elements' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __( 'Image Border', 'press-elements' ),
				'selector' => '{{WRAPPER}} .press-elements-site-logo img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'press-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .press-elements-site-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .press-elements-site-logo img',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = $custom_logo_id ? wp_get_attachment_image( $custom_logo_id , 'full' ) : '';
		$logo = has_custom_logo() ? $image : '';

		if ( empty( $logo ) )
			return;

		switch ( $settings['link_to'] ) {
			case 'custom' :
				if ( ! empty( $settings['link']['url'] ) ) {
					$link = esc_url( $settings['link']['url'] );
				} else {
					$link = false;
				}
				break;

			case 'home' :
				$link = esc_url( get_home_url() );
				break;

			case 'none' :
			default:
				$link = false;
				break;
		}
		$target = $settings['link']['is_external'] ? 'target="_blank"' : '';

		$animation_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';

		$html = sprintf( '<%1$s class="press-elements-site-logo %2$s">', $settings['html_tag'], $animation_class );
		if ( $link ) {
			$html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, $logo );
		} else {
			$html .= $logo;
		}
		$html .= sprintf( '</%s>', $settings['html_tag'] );

		echo $html;
	}

	protected function _content_template() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = $custom_logo_id ? wp_get_attachment_image( $custom_logo_id , 'full' ) : '';
		?>
		<#
			var logo = '<?php echo has_custom_logo() ? $image : ''; ?>';

			var link_url;
			switch( settings.link_to ) {
				case 'custom':
					link_url = settings.link.url;
					break;
				case 'home':
					link_url = '<?php echo esc_url( get_home_url() ); ?>';
					break;
				case 'none':
				default:
					link_url = false;
			}
			var target = settings.link.is_external ? 'target="_blank"' : '';

			var animation_class = '';
			if ( '' !== settings.hover_animation ) {
				animation_class = 'elementor-animation-' + settings.hover_animation;
			}

			var html = '<' + settings.html_tag + ' class="press-elements-site-logo ' + animation_class + '">';
			if ( link_url ) {
				html += '<a href="' + link_url + '" ' + target + '>' + logo + '</a>';
			} else {
				html += logo;
			}
			html += '</' + settings.html_tag + '>';

			print( html );

		#>
		<?php
	}

}
