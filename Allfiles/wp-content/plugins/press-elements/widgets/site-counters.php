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
 * Press Elements Site Counters
 *
 * Site counters element for elementor.
 *
 * @since 1.2.0
 */
class Press_Elements_Site_Counters extends Widget_Base {

	public function get_name() {
		return 'site-counters';
	}

	public function get_title() {
		return __( 'Site Counters', 'press-elements' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'press-elements-site-elements' ];
	}

	protected function _register_controls() {

		$post_types = array();
		$all_post_types = get_post_types( $args = array( 'public' => true ), 'objects' );
		foreach ( $all_post_types as $post_type ) {
			$post_types[ $post_type->name ] = $post_type->labels->name;
		}
		unset( $post_types['attachment'] );

		$taxonomies = array();
		$all_taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
		foreach ( $all_taxonomies as $taxonomy ) {
			$taxonomies[ $taxonomy->name ] = $taxonomy->labels->name;
		}

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Site Counters', 'press-elements' ),
			]
		);

		$this->add_control(
			'display',
			[
				'label' => __( 'Display', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_type',
				'options' => [
					'post_type' => __( 'Post Type', 'press-elements' ),
					'taxonomy' => __( 'Taxonomy', 'press-elements' ),
					'comments' => __( 'Comments', 'press-elements' ),
					'users' => __( 'Users', 'press-elements' ),
				],
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post Type', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => $post_types,
				'default' => 'post',
				'condition' => [
					'display' => 'post_type',
				],
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label' => __( 'Taxonomy', 'press-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => $taxonomies,
				'default' => 'category',
				'condition' => [
					'display' => 'taxonomy',
				],
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number',
			[
				'label' => __( 'Number', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => __( 'Text Color', 'press-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-site-counters .press-elements-total' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .press-elements-site-counters .press-elements-total',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'number_shadow',
				'selector' => '{{WRAPPER}} .press-elements-site-counters .press-elements-total',
			]
		);

		$this->add_control(
			'number_hover_animation',
			[
				'label' => __( 'Hover Animation', 'press-elements' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label',
			[
				'label' => __( 'Label', 'press-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Text Color', 'press-elements' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .press-elements-site-counters .press-elements-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .press-elements-site-counters .press-elements-label',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'label_shadow',
				'selector' => '{{WRAPPER}} .press-elements-site-counters .press-elements-label',
			]
		);

		$this->add_control(
			'label_hover_animation',
			[
				'label' => __( 'Hover Animation', 'press-elements' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$total = 0;
		$label = '';

		switch ( $settings['display'] ) {
			case 'users' :
				$users_count = count_users();
				$total = $users_count['total_users'];
				$label = __( 'Users', 'press-elements' );
				break;

			case 'comments' :
				$count_comments = wp_count_comments();
				$total = $count_comments->approved;
				$label = __( 'Comments', 'press-elements' );
				break;

			case 'taxonomy' :
				$total = wp_count_terms( $settings['taxonomy'] );
				$taxonomy = get_taxonomy( $settings['taxonomy'] );
				$label = ( is_object( $taxonomy ) ) ? $taxonomy->labels->name : '';
				break;

			case 'post_type' :
			default:
				$query = new \WP_Query( array( 'post_type' => $settings['post_type'] ) );
				$total = $query->found_posts;
				wp_reset_postdata();
				$post_type_object = get_post_type_object( $settings['post_type'] );
				$label = ( is_object( $post_type_object ) ) ? $post_type_object->labels->name : '';
				break;
		}

		$number_hover_animation = ! empty( $settings['number_hover_animation'] ) ? 'elementor-animation-' . $settings['number_hover_animation'] : '';
		$label_hover_animation = ! empty( $settings['label_hover_animation'] ) ? 'elementor-animation-' . $settings['label_hover_animation'] : '';

		$html = '<div class="press-elements-site-counters">';
		$html .= sprintf( '<%1$s class="press-elements-total %2$s">%3$s</%1$s>', $settings['html_tag'], $number_hover_animation, $total );
		$html .= sprintf( '<%1$s class="press-elements-label %2$s">%3$s</%1$s>', $settings['html_tag'], $label_hover_animation, $label );
		$html .= '</div>';

		echo $html;

	}

	protected function _content_template() {
		/*
		?>
		<#
		var total = 0;
		var label = '';

		switch( settings.display ) {
			case 'users':
				<?php $count_users = count_users(); ?>
				total = <?php echo (int) $count_users['total_users']; ?>;
				label = '<?php echo __( 'Users', 'press-elements' ); ?>';
				break;

			case 'comments':
				<?php $count_comments = wp_count_comments(); ?>
				total = <?php echo (int) $count_comments->approved; ?>;
				label = '<?php echo __( 'Comments', 'press-elements' ); ?>';
				break;

			case 'taxonomy':
				var taxonomy_total = [];
				var taxonomy_labels = [];
				<?php
				$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
				foreach ( $taxonomies as $taxonomy ) {
					printf( 'taxonomy_total[ "%1$s" ] = \'%2$s\';', $taxonomy->name, wp_count_terms( $taxonomy->name ) );
					printf( 'taxonomy_labels[ "%1$s" ] = \'%2$s\';', $taxonomy->name, $taxonomy->labels->name );
				}
				?>
				total = taxonomy_total[ settings.taxonomy ];
				label = taxonomy_labels[ settings.taxonomy ];
				break;

			case 'post_type':
			default:
				var post_type_count = [];
				var post_type_labels = [];
				<?php
				$post_types = get_post_types( $args = array( 'public' => true ), 'objects' );
				foreach ( $post_types as $post_type ) {
					$query = new \WP_Query( array( 'post_type' => $post_type ) );
					printf( 'post_type_count[ "%1$s" ] = \'%2$s\';', $post_type->name, $query->found_posts );
					printf( 'post_type_labels[ "%1$s" ] = \'%2$s\';', $post_type->name, $post_type->labels->name );
					wp_reset_postdata();
				}
				?>
				total = post_type_count[ settings.post_type ];
				label = post_type_labels[ settings.post_type ];
				break;
		}

		var number_animation_class = '';
		if ( '' !== settings.number_hover_animation ) {
			number_animation_class = 'elementor-animation-' + settings.number_hover_animation;
		}
		var label_animation_class = '';
		if ( '' !== settings.label_hover_animation ) {
			label_animation_class = 'elementor-animation-' + settings.label_hover_animation;
		}

		var html = '<div class="press-elements-site-counters">';
		html += '<' + settings.html_tag + ' class="press-elements-total ' + number_animation_class + '">' + total + '</' + settings.html_tag + '>';
		html += '<' + settings.html_tag + ' class="press-elements-label ' + label_animation_class + '">' + label + '</' + settings.html_tag + '>';
		html += '</div>';

		print( html );
		#>
		<?php
		*/
	}
}
