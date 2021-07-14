<?php
/**
 * Elementor Classes.
 *
 * @package header-footer-elementor
 */

namespace HFE\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

use HFE\WidgetsManager\Widgets_Loader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * HFE Page Title widget
 *
 * HFE widget for Page Title.
 *
 * @since 1.3.0
 */
class Page_Title extends Widget_Base {


	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'page-title';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Page Title', 'header-footer-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'hfe-icon-page-title';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hfe-widgets' ];
	}

	/**
	 * Register Page Title controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_controls();
	}

	/**
	 * Register Page Title controls.
	 *
	 * @since 1.5.7
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_content_page_title_controls();
		$this->register_page_title_style_controls();
	}

	/**
	 * Register Page Title General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_content_page_title_controls() {
		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'Title', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'archive_title_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				/* translators: %1$s doc link */
				'raw'             => sprintf( __( '<b>Note:</b> Archive page title will be visible on frontend.', 'header-footer-elementor' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);

		$this->add_control(
			'before',
			[
				'label'   => __( 'Before Title Text', 'header-footer-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'after',
			[
				'label'   => __( 'After Title Text', 'header-footer-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'new_page_title_select_icon',
			[
				'label'       => __( 'Select Icon', 'header-footer-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'page_title_icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'header-footer-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-page-title-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'page_custom_link',
			[
				'label'   => __( 'Link', 'header-footer-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'custom'  => __( 'Custom URL', 'header-footer-elementor' ),
					'default' => __( 'Default', 'header-footer-elementor' ),
					'none'    => __( 'None', 'header-footer-elementor' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'page_heading_link',
			[
				'label'       => __( 'Link', 'header-footer-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'header-footer-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => get_home_url(),
				],
				'condition'   => [
					'page_custom_link' => 'custom',
				],
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => __( 'HTML Tag', 'header-footer-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'header-footer-elementor' ),
					'h2' => __( 'H2', 'header-footer-elementor' ),
					'h3' => __( 'H3', 'header-footer-elementor' ),
					'h4' => __( 'H4', 'header-footer-elementor' ),
					'h5' => __( 'H5', 'header-footer-elementor' ),
					'h6' => __( 'H6', 'header-footer-elementor' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => __( 'Size', 'header-footer-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'header-footer-elementor' ),
					'small'   => __( 'Small', 'header-footer-elementor' ),
					'medium'  => __( 'Medium', 'header-footer-elementor' ),
					'large'   => __( 'Large', 'header-footer-elementor' ),
					'xl'      => __( 'XL', 'header-footer-elementor' ),
					'xxl'     => __( 'XXL', 'header-footer-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => __( 'Alignment', 'header-footer-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'header-footer-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'header-footer-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'header-footer-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'header-footer-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'      => '',
				'prefix_class' => 'hfe-page-title-align-',
				'selectors'    => [
					'{{WRAPPER}} .hfe-page-title-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register Page Title Style Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_page_title_style_controls() {
		$this->start_controls_section(
			'section_title_typography',
			[
				'label' => __( 'Title', 'header-footer-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .hfe-page-title a',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label'     => __( 'Color', 'header-footer-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .hfe-page-title a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .hfe-page-title-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .hfe-page-title-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'title_shadow',
					'selector' => '{{WRAPPER}} .elementor-heading-title',
				]
			);

			$this->add_control(
				'blend_mode',
				[
					'label'     => __( 'Blend Mode', 'header-footer-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''            => __( 'Normal', 'header-footer-elementor' ),
						'multiply'    => 'Multiply',
						'screen'      => 'Screen',
						'overlay'     => 'Overlay',
						'darken'      => 'Darken',
						'lighten'     => 'Lighten',
						'color-dodge' => 'Color Dodge',
						'saturation'  => 'Saturation',
						'color'       => 'Color',
						'difference'  => 'Difference',
						'exclusion'   => 'Exclusion',
						'hue'         => 'Hue',
						'luminosity'  => 'Luminosity',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label'     => __( 'Icon', 'header-footer-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'page_title_icon_color',
			[
				'label'     => __( 'Icon Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .hfe-page-title-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .hfe-page-title-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'page_title_icons_hover_color',
			[
				'label'     => __( 'Icon Hover Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'new_page_title_select_icon[value]!' => '',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .hfe-page-title-icon:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .hfe-page-title-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render page title widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'page_title', 'basic' );

		if ( ! empty( $settings['page_heading_link']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['page_heading_link'] );
		}

		$heading_size_tag = Widgets_Loader::validate_html_tag( $settings['heading_tag'] );
		?>
		<div class="hfe-page-title hfe-page-title-wrapper elementor-widget-heading">

		<?php
		$head_link_url    = isset( $settings['page_heading_link']['url'] ) ? $settings['page_heading_link']['url'] : '';
		$head_custom_link = isset( $settings['page_custom_link'] ) ? $settings['page_custom_link'] : '';
		?>
			<?php if ( '' != $head_link_url && 'custom' === $head_custom_link ) { ?>
						<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'url' ) ); ?>>
			<?php } elseif ( 'default' === $head_custom_link ) { ?>
						<a href="<?php echo esc_url( get_home_url() ); ?>">
			<?php } ?>
			<<?php echo $heading_size_tag; ?> class="elementor-heading-title elementor-size-<?php echo $settings['size']; ?>">
				<?php if ( '' !== $settings['new_page_title_select_icon']['value'] ) { ?>
						<span class="hfe-page-title-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['new_page_title_select_icon'], [ 'aria-hidden' => 'true' ] ); ?>             </span>
				<?php } ?>
				<?php if ( '' != $settings['before'] ) { ?>
					<?php echo wp_kses_post( $settings['before'] ); ?>
					<?php
				}

				if ( is_archive() || is_home() ) {
					echo wp_kses_post( get_the_archive_title() );
				} else {
					echo wp_kses_post( get_the_title() );
				}

				if ( '' != $settings['after'] ) {
					?>
					<?php echo wp_kses_post( $settings['after'] ); ?>
				<?php } ?>
			</<?php echo $heading_size_tag; ?> >
			<?php if ( ( '' != $head_link_url && 'custom' === $head_custom_link ) || 'default' === $head_custom_link ) { ?>
						</a>
			<?php } ?>
		</div>
		<?php

	}

	/**
	 * Render page title output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function content_template() {

		?>
		<#
		if ( '' == settings.page_title ) {
			return;
		}

		if ( '' != settings.page_heading_link.url ) {
			view.addRenderAttribute( 'url', 'href', settings.page_heading_link.url );
		}
		var iconHTML = elementor.helpers.renderIcon( view, settings.new_page_title_select_icon, { 'aria-hidden': true }, 'i' , 'object' );

		var headingSizeTag = settings.heading_tag;

		if ( typeof elementor.helpers.validateHTMLTag === "function" ) {
			headingSizeTag = elementor.helpers.validateHTMLTag( settings.heading_tag );
		} else if( HfeWidgetsData.allowed_tags ) {
			headingSizeTag = HfeWidgetsData.allowed_tags.includes( headingSizeTag.toLowerCase() ) ? headingSizeTag : 'div';
		}

		#>
		<div class="hfe-page-title hfe-page-title-wrapper elementor-widget-heading">
			<# if ( '' != settings.page_heading_link.url ) { #>
					<a {{{ view.getRenderAttributeString( 'url' ) }}} >
			<# } #>
			<{{{ headingSizeTag }}} class="elementor-heading-title elementor-size-{{{ settings.size }}}">
				<# if( '' != settings.new_page_title_select_icon.value ){ #>
					<span class="hfe-page-title-icon" data-elementor-setting-key="page_title" data-elementor-inline-editing-toolbar="basic">
						{{{iconHTML.value}}}
					</span>
				<# } #>
					<# if ( '' != settings.before ) { #>
						{{{ settings.before }}}
					<# } #>
					<?php
					if ( is_archive() || is_home() ) {
						echo wp_kses_post( get_the_archive_title() );
					} else {
						echo wp_kses_post( get_the_title() );
					}
					?>
					<# if ( '' != settings.after ) { #>
						{{{ settings.after }}}
					<# } #>
			</{{{ headingSizeTag }}}>
			<# if ( '' != settings.page_heading_link.url ) { #>
					</a>
			<# } #>
		</div>
		<?php
	}

	/**
	 * Render page title output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * Remove this after Elementor v3.3.0
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _content_template() {
		$this->content_template();
	}
}
