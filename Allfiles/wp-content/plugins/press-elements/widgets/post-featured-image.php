<?php
namespace PressElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Press Elements Post Featured Image
 *
 * Single post/page featured image element for elementor.
 *
 * @since 1.0.0
 * @since 1.6.0 Not longer a Pro widget
 */
class Press_Elements_Post_Featured_Image extends Widget_Base {

	public function get_name() {
		return 'post-featured-image';
	}

	public function get_title() {
		$post_type_object = get_post_type_object( get_post_type() );

		return sprintf(
			/* translators: %s: Post type singular name (e.g. Post or Page) */
			__( '%s Featured Image', 'press-elements' ),
			$post_type_object->labels->singular_name
		);
	}

	public function get_icon() {
		return 'fa fa-picture-o';
	}

	public function get_categories() {
		return [ 'press-elements-post-elements' ];
	}

	protected function _register_controls() {

		$post_type_object = get_post_type_object( get_post_type() );

		$this->start_controls_section(
			'section_content',
			[
				'label' => sprintf(
					/* translators: %s: Post type singular name (e.g. Post or Page) */
					__( '%s Featured Image', 'press-elements' ),
					$post_type_object->labels->singular_name
				),
			]
		);

		$this->add_control(
			'preview',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => get_the_post_thumbnail(),
				'separator' => 'none',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'size',
				'label' => __( 'Image Size', 'press-elements' ),
				'default' => 'large',
				'exclude' => [ 'custom' ],
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
					'post' => sprintf(
						/* translators: %s: Post type singular name (e.g. Post or Page) */
						__( '%s URL', 'press-elements' ),
						$post_type_object->labels->singular_name
					),
					'file' => __( 'Media File URL', 'press-elements' ),
					'custom' => __( 'Custom URL', 'press-elements' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'press-elements' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'press-elements' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => sprintf(
					/* translators: %s: Post type singular name (e.g. Post or Page) */
					__( '%s Featured Image', 'press-elements' ),
					$post_type_object->labels->singular_name
				),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .press-elements-featured-image img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .press-elements-featured-image img' => 'opacity: {{SIZE}};',
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
					'{{WRAPPER}} .press-elements-featured-image img' => '-webkit-transform: rotate({{SIZE}}deg); -moz-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
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
				'selector' => '{{WRAPPER}} .press-elements-featured-image img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'press-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .press-elements-featured-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .press-elements-featured-image img',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$image_size = $settings['size_size'];
		$featured_image = get_the_post_thumbnail( null, $image_size );

		if ( empty( $featured_image ) )
			return;

		switch ( $settings['link_to'] ) {
			case 'custom' :
				if ( ! empty( $settings['link']['url'] ) ) {
					$link = esc_url( $settings['link']['url'] );
				} else {
					$link = false;
				}
				break;

			case 'file' :
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
				$link = esc_url( $image_url[0] );
				break;

			case 'post' :
				$link = esc_url( get_the_permalink() );
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

		$html = '<div class="press-elements-featured-image ' . $animation_class . '">';
		if ( $link ) {
			$html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, $featured_image );
		} else {
			$html .= $featured_image;
		}
		$html .= '</div>';

		echo $html;

	}

	protected function _content_template() {

		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		?>
		<#
			var featured_images = [];
			<?php
			$all_image_sizes = Group_Control_Image_Size::get_all_image_sizes();
			foreach ( $all_image_sizes as $key => $value ) {
				printf( 'featured_images[ "%1$s" ] = \'%2$s\';', $key, get_the_post_thumbnail( null, $key ) );
			}
			printf( 'featured_images[ "full" ] = \'%2$s\';', $key, get_the_post_thumbnail( null, 'full' ) );
			?>
			var featured_image = featured_images[ settings.size_size ];

			var link_url;
			switch( settings.link_to ) {
				case 'custom':
					link_url = settings.link.url;
					break;
				case 'file':
					link_url = '<?php echo esc_url( $image_url[0] ); ?>';
					break;
				case 'post':
					link_url = '<?php echo esc_url( get_the_permalink() ); ?>';
					break;
				case 'home':
					link_url = '<?php echo esc_url( get_home_url() ); ?>';
					break;
				case 'none':
				default:
					link_url = false;
			}

			var animation_class = '';
			if ( '' !== settings.hover_animation ) {
				animation_class = 'elementor-animation-' + settings.hover_animation;
			}

			var html = '<div class="press-elements-featured-image ' + animation_class + '">';
			if ( link_url ) {
				html += '<a href="' + link_url + '">' + featured_image + '</a>';
			} else {
				html += featured_image;
			}
			html += '</div>';

			print( html );
		#>
		<?php

	}

}
