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
 * Press Elements Post Title
 *
 * Single post/page title element for elementor.
 *
 * @since 1.0.0
 */
class Press_Elements_Post_Title extends Widget_Base {

	public function get_name() {
		return 'post-title';
	}

	public function get_title() {
		$post_type_object = get_post_type_object( get_post_type() );

		return sprintf(
			/* translators: %s: Post type singular name (e.g. Post or Page) */
			__( '%s Title', 'press-elements' ),
			$post_type_object->labels->singular_name
		);
	}

	public function get_icon() {
		return 'eicon-type-tool';
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
					__( '%s Title', 'press-elements' ),
					$post_type_object->labels->singular_name
				),
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
				'default' => 'h2',
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
				'label' => sprintf(
					/* translators: %s: Post type singular name (e.g. Post or Page) */
					__( '%s Title', 'press-elements' ),
					$post_type_object->labels->singular_name
				),
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
					'{{WRAPPER}} .press-elements-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .press-elements-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .press-elements-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .press-elements-title',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'press-elements' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$title = get_the_title();

		if ( empty( $title ) )
			return;

		$settings = $this->get_settings();

		switch ( $settings['link_to'] ) {
			case 'custom' :
				if ( ! empty( $settings['link']['url'] ) ) {
					$link = esc_url( $settings['link']['url'] );
				} else {
					$link = false;
				}
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

		$html = sprintf( '<%1$s class="press-elements-title %2$s">', $settings['html_tag'], $animation_class );
		if ( $link ) {
			$html .= sprintf( '<a href="%1$s" %2$s>%3$s</a>', $link, $target, $title );
		} else {
			$html .= $title;
		}
		$html .= sprintf( '</%s>', $settings['html_tag'] );

		echo $html;
	}

	protected function _content_template() {
		?>
		<#
			var title = "<?php echo get_the_title(); ?>";

			var link_url;
			switch( settings.link_to ) {
				case 'custom':
					link_url = settings.link.url;
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
			var target = settings.link.is_external ? 'target="_blank"' : '';

			var animation_class = '';
			if ( '' !== settings.hover_animation ) {
				animation_class = 'elementor-animation-' + settings.hover_animation;
			}

			var html = '<' + settings.html_tag + ' class="press-elements-title ' + animation_class + '">';
			if ( link_url ) {
				html += '<a href="' + link_url + '" ' + target + '>' + title + '</a>';
			} else {
				html += title;
			}
			html += '</' + settings.html_tag + '>';

			print( html );
		#>
		<?php
	}
}
