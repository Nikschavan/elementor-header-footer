<?php
// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since x.x.x
 */
class Retina extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since x.x.x
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'retina';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since x.x.x
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Retina Logo', 'hfe' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since x.x.x
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since x.x.x
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'HFE' ];
	}

	/**
	 * Register Retina Logo controls.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_content_retina_image_controls();
		$this->register_retina_image_styling_controls();
		$this->register_retina_caption_styling_controls();
	}

	/**
	 * Register Retina Logo General Controls.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function register_content_retina_image_controls() {
		$this->start_controls_section(
			'section_retina_image',
			[
				'label' => __( 'Retina Image', 'hfe' ),
			]
		);
		$this->add_control(
			'retina_image',
			[
				'label'   => __( 'Choose Default Image', 'hfe' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'real_retina',
			[
				'label'   => __( 'Choose Retina Image', 'hfe' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'retina_image',
				'label'   => __( 'Image Size', 'hfe' ),
				'default' => 'medium',
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'hfe' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'hfe' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hfe' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'hfe' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .hfe-retina-image-container, {{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_source',
			[
				'label'   => __( 'Caption', 'hfe' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'       => __( 'None', 'hfe' ),
					'attachment' => __( 'Attachment Caption', 'hfe' ),
					'custom'     => __( 'Custom Caption', 'hfe' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'caption',
			[
				'label'       => __( 'Custom Caption', 'hfe' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Enter your image caption', 'hfe' ),
				'condition'   => [
					'caption_source' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => __( 'Link', 'hfe' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'hfe' ),
					'custom' => __( 'Custom URL', 'hfe' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'hfe' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'hfe' ),
				'condition'   => [
					'link_to' => 'custom',
				],
				'show_label'  => false,
			]
		);
		$this->end_controls_section();
	}
	/**
	 * Register Retina Image Style Controls.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function register_retina_image_styling_controls() {
		$this->start_controls_section(
			'section_style_retina_image',
			[
				'label' => __( 'Retina Image', 'hfe' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'          => __( 'Width', 'hfe' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units'     => [ '%', 'px', 'vw' ],
				'range'          => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .hfe-retina-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label'          => __( 'Max Width', 'hfe' ) . ' (%)',
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units'     => [ '%' ],
				'range'          => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .hfe-retina-image img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab(
			'normal',
			[
				'label' => __( 'Normal', 'hfe' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'     => __( 'Opacity', 'hfe' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-retina-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .hfe-retina-image img',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'selector'  => '{{WRAPPER}} .hfe-retina-image img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'hfe' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .hfe-retina-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .hfe-retina-image img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __( 'Hover', 'hfe' ),
			]
		);
		$this->add_control(
			'opacity_hover',
			[
				'label'     => __( 'Opacity', 'hfe' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-retina-image:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .hfe-retina-image:hover img',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'hfe' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);
		$this->add_control(
			'background_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'hfe' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-retina-image img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	/**
	 * Register Caption style Controls.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function register_retina_caption_styling_controls() {

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'     => __( 'Caption', 'hfe' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'hfe' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label'     => __( 'Background Color', 'hfe' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .widget-image-caption',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .widget-image-caption',
			]
		);

			$this->add_responsive_control(
				'caption_space',
				[
					'label'     => __( 'Spacing', 'hfe' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: 0px;',
					],
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Check if the current widget has caption
	 *
	 * @access private
	 * @since x.x.x
	 *
	 * @param array $settings returns settings.
	 *
	 * @return boolean
	 */
	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	/**
	 * Get the caption for current widget.
	 *
	 * @access private
	 * @since x.x.x
	 * @param array $settings returns the caption.
	 *
	 * @return string
	 */
	private function get_caption( $settings ) {
		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['retina_image']['id'] );
					break;
				case 'custom':
					$caption = ! empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}
		return $caption;
	}

	/**
	 * Render Retina Image output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since x.x.x
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['retina_image']['url'] ) ) {
			return;
		}

		$has_caption = $this->has_caption( $settings );

		$this->add_render_attribute( 'wrapper', 'class', 'hfe-retina-image' );
		$link = $this->get_link_url( $settings );

		if ( $link ) {
			$this->add_render_attribute(
				'link',
				[
					'href'                         => $link['url'],
				]
			);

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute(
					'link',
					[
						'class' => 'elementor-clickable',
					]
				);
			}

			if ( ! empty( $link['is_external'] ) ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}

			if ( ! empty( $link['nofollow'] ) ) {
				$this->add_render_attribute( 'link', 'rel', 'nofollow' );
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $has_caption ) : ?>
				<figure class="wp-caption">
			<?php endif; ?>
			<?php if ( $link ) : ?>
					<a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>
			<?php
			$size = $settings[ 'retina_image' . '_size' ];
			$demo = '';

			if ( 'custom' !== $size ) {
				$image_size = $size;
			} else {
				require_once( ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php' );

				$image_dimension = $settings[ 'retina_image' . '_custom_dimension' ];

				$image_size = [
					// Defaults sizes.
					0           => null, // Width.
					1           => null, // Height.

					'bfi_thumb' => true,
					'crop'      => true,
				];

				$has_custom_size = false;
				if ( ! empty( $image_dimension['width'] ) ) {
					$has_custom_size = true;
					$image_size[0]   = $image_dimension['width'];
				}

				if ( ! empty( $image_dimension['height'] ) ) {
					$has_custom_size = true;
					$image_size[1]   = $image_dimension['height'];
				}

				if ( ! $has_custom_size ) {
					$image_size = 'full';
				}
			}
			$retina_image_url = $settings['real_retina']['url'];

			$image_url = $settings['retina_image']['url'];

			$image_data = wp_get_attachment_image_src( $settings['retina_image']['id'], $image_size, true );

			$retina_data = wp_get_attachment_image_src( $settings['real_retina']['id'], $image_size, true );

			$retina_image_class = 'elementor-animation-';

			if ( ! empty( $settings['hover_animation'] ) ) {
				$demo = $settings['hover_animation'];
			}
			if ( ! empty( $image_data ) ) {
				$image_url = $image_data[0];
			}
			if ( ! empty( $retina_data ) ) {
				$retina_image_url = $retina_data[0];
			}
			$class_animation= $retina_image_class . $demo;

			if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE ) {

				$date     = new \DateTime();
				$timestam = $date->getTimestamp();
				$image_url = $image_url . '?' . $timestam;
				$retina_image_url = $retina_image_url . '?' . $timestam;
			}

			?>
				<div class="hfe-retina-image-set">
					<div class="hfe-retina-image-container">
						<img class="hfe-retina-img <?php echo $class_animation; ?>"  src="<?php echo $image_url; ?>" srcset="<?php echo $image_url . ' 1x' . ',' . $retina_image_url . ' 2x'; ?>"/>
					</div>
				</div>
			<?php if ( $link ) : ?>
					</a>
			<?php endif; ?>
			<?php if ( $has_caption ) : ?>
					<?php if ( ! empty( $this->get_caption( $settings ) ) ) : ?> 
						<figcaption class="widget-image-caption wp-caption-text"><?php echo $this->get_caption( $settings ); ?></figcaption>
				<?php endif; ?>
				</figure>
			<?php endif; ?>
		</div> 
		<?php
	}

	/**
	 * Retrieve Retina image widget link URL.
	 *
	 * @since x.x.x
	 * @access private
	 *
	 * @param array $settings returns settings.
	 * @return array|string|false An array/string containing the link URL, or false if no link.
	 */
	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}
			return $settings['link'];
		}
	}
}
