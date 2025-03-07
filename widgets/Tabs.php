<?php
/**
 * Use namespace to avoid conflict
 */

namespace SPEL\Widgets;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Tabs
 * @package spider\Widgets
 * @since 1.0.0
 */
class Tabs extends Widget_Base {

	public function get_name() {
		return 'docy_tabs'; // ID of the widget (Don't change this name)
	}

	public function get_title() {
		return esc_html__( 'Tabs', 'spider-elements' );
	}

	public function get_icon() {
		return 'eicon-tabs spel-icon';
	}

	public function get_keywords() {
		return [ 'spider', 'spider elements', 'tab', 'tabs', 'tab widget' ];
	}

	public function get_categories() {
		return [ 'spider-elements' ];
	}

	/**
	 * Name: get_style_depends()
	 * Desc: Register the required CSS dependencies for the frontend.
	 */
	public function get_style_depends() {
		return [ 'elegant-icon', 'spel-main' ];
	}

	/**
	 * Name: get_script_depends()
	 * Desc: Register the required JS dependencies for the frontend.
	 */
	public function get_script_depends() {
		return [ 'spel-el-widgets' ];
	}


	/**
	 * Name: register_controls()
	 * Desc: Register controls for these widgets
	 * Params: no params
	 * Return: @void
	 * Since: @1.0.0
	 * Package: @spider-elements
	 * Author: spider-themes
	 */
	protected function register_controls() {
		$this->elementor_content_control();
		$this->elementor_style_control();
	}


	/**
	 * Name: elementor_content_control()
	 * Desc: Register the Content Tab output on the Elementor editor.
	 * Params: no params
	 * Return: @void
	 * Since: @1.0.0
	 * Package: @spider-elements
	 * Author: spider-themes
	 */
	public function elementor_content_control() {

		// ============================ Select Style  ===========================//
		$this->start_controls_section(
			'select_style',
			[
				'label' => __( 'Preset Skins', 'spider-elements' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => __( 'Style', 'spider-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => __( 'Inline Tab', 'spider-elements' ),
					'2' => __( 'Full Width Tab', 'spider-elements' ),
				],
				'default' => '1',
			]
		);

		$this->end_controls_section(); // End Select Style


		// ============================ Tabs ===========================//
		$this->start_controls_section(
			'sec_tabs',
			[
				'label' => __( 'Tabs', 'spider-elements' ),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'spider-elements' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'far fa-lightbulb',
					'library' => 'fa-regular',
				],

			]
		);

		$repeater->add_control(
			'tab_title',
			[
				'label'       => __( 'Tab Title', 'spider-elements' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Tab Title', 'spider-elements' ),
				'placeholder' => __( 'Tab Title', 'spider-elements' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tabs_content_type',
			[
				'label'   => __( 'Content Type', 'spider-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'content'  => __( 'Content', 'spider-elements' ),
					'template' => __( 'Saved Templates', 'spider-elements' ),
				],
				'default' => 'content',
			]
		);

		$repeater->add_control(
			'primary_templates',
			[
				'label'     => __( 'Choose Template', 'spider-elements' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => spel_get_el_templates(),
				'condition' => [
					'tabs_content_type' => 'template',
				],
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label'       => __( 'Content', 'spider-elements' ),
				'default'     => __( 'Tab Content', 'spider-elements' ),
				'placeholder' => __( 'Tab Content', 'spider-elements' ),
				'type'        => Controls_Manager::WYSIWYG,
				'show_label'  => false,
				'condition'   => [
					'tabs_content_type' => 'content',
				],
			]
		);

		$repeater->end_controls_tab(); // End tab

		$this->add_control(
			'tabs',
			[
				'label'       => __( 'Add Items', 'spider-elements' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ tab_title }}}',
				'default'     => [
					[
						'tab_title'   => esc_html__( 'Tab Title #1', 'spider-elements' ),
						'tab_content' => esc_html__( 'Nostra adipiscing sequi nisi hic venenatis pede aliquid eget aperiam commodi gravida?', 'spider-elements' ),
					],
					[
						'tab_title'   => esc_html__( 'Tab Title #2', 'spider-elements' ),
						'tab_content' => esc_html__( 'Nostra adipiscing sequi nisi hic venenatis pede aliquid eget aperiam commodi gravida?', 'spider-elements' ),
					],
					[
						'tab_title'   => esc_html__( 'Tab Title #3', 'spider-elements' ),
						'tab_content' => esc_html__( 'Nostra adipiscing sequi nisi hic venenatis pede aliquid eget aperiam commodi gravida?', 'spider-elements' ),
					],
				],
			]
		);

		$this->add_control(
			'is_navigation_arrow',
			[
				'label'        => esc_html__( 'Navigation Arrow', 'spider-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Show/Hide navigation arrow button for content area', 'spider-elements' ),
				'label_on'     => esc_html__( 'Show', 'spider-elements' ),
				'label_off'    => esc_html__( 'Hide', 'spider-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before'
			]
		);

		$this->add_control(
			'is_auto_numb',
			[
				'label'        => esc_html__( 'Auto Numbering', 'spider-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Show/Hide auto numbering for tab title', 'spider-elements' ),
				'label_on'     => esc_html__( 'Show', 'spider-elements' ),
				'label_off'    => esc_html__( 'Hide', 'spider-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before'
			]
		);

		$this->add_control(
			'is_auto_play',
			[
				'label'        => esc_html__( 'Auto Play', 'spider-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Show/Hide auto play for tab', 'spider-elements' ),
				'label_on'     => esc_html__( 'Show', 'spider-elements' ),
				'label_off'    => esc_html__( 'Hide', 'spider-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before'
			]
		);

		$this->add_control(
			'is_sticky_tab',
			[
				'label'        => esc_html__( 'Sticky Mode', 'spider-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Show/Hide sticky mode for tab title', 'spider-elements' ),
				'label_on'     => esc_html__( 'Show', 'spider-elements' ),
				'label_off'    => esc_html__( 'Hide', 'spider-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before'
			]
		);

		$this->add_control(
			'tab_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'spider-elements' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'spider-elements' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'spider-elements' ),
						'icon'  => ' eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'spider-elements' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'flex-start',
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .tab_shortcode .nav-tabs'    => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .header_tabs_area .nav-tabs' => 'justify-content: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section(); // End Tabs Section

	}


	/**
	 * Name: elementor_style_control()
	 * Desc: Register the Style Tab output on the Elementor editor.
	 * Params: no params
	 * Return: @void
	 * Since: @1.0.0
	 * Package: @spider-elements
	 * Author: spider-themes
	 */
	public function elementor_style_control() {

		//============================ Tab Title Style ============================//
		$this->start_controls_section(
			'style_tabs_sec',
			[
				'label' => __( 'Tab Title', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tab_item_typo',
				'selector'  => '{{WRAPPER}} .tab_shortcode .nav-tabs .nav-item .nav-link, {{WRAPPER}} .header_tab_items .nav-tabs .nav-item .nav-link',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'spider-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .tab_shortcode .nav-tabs .nav-item .nav-link i, {{WRAPPER}} .header_tabs_area .nav-tabs .nav-item .nav-link i ' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .tab_shortcode .nav-tabs .nav-item .nav-link',
			]
		);

		$this->add_responsive_control(
			'title_border_radius',
			[
				'label'      => __( 'Border Radius', 'spider-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tab_shortcode .nav-tabs .nav-item .nav-link'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .header_tabs_area .nav-tabs .nav-item .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_margin', [
				'label'      => __( 'margin', 'spider-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tab_shortcode .nav-tabs .nav-item'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .header_tabs_area .nav-tabs .nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_pad',
			[
				'label'      => __( 'Padding', 'spider-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tab_shortcode .nav-tabs .nav-item .nav-link'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .header_tabs_area .nav-tabs .nav-item .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_title_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		// Tab Title Normal/Active/hover State
		$this->start_controls_tabs(
			'style_tab_title_tabs'
		);

		//=== Normal Tab Title
		$this->start_controls_tab(
			'style_tab_title_normal',
			[
				'label' => __( 'Normal', 'spider-elements' ),
			]
		);

		$this->add_control(
			'normal_tab_title_text_color',
			[
				'label'     => __( 'Text Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab_shortcode .spel_tab_title , {{WRAPPER}} .header_tab_items .spel_tab_title ' => 'color: {{VALUE}}',
				)
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'normal_tab_title_bg_color',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' =>
					'{{WRAPPER}} .tab_shortcode .tab-item-title, 
					{{WRAPPER}} .header_tab_items .spel_tab_title ',

			]
		);


		$this->add_control(
			'normal_tab_icon_bg_color',
			[
				'label'     => __( 'Icon Background Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab-item-title > .numb' => 'background: {{VALUE}};',
				),
				'condition' => [
					'is_auto_numb' => 'yes',
				]
			]
		);

		$this->end_controls_tab(); //End Normal Tab Title

		//=== Hover Tab Title
		$this->start_controls_tab(
			'style_tab_title_hover', [
				'label' => __( 'Hover', 'spider-elements' ),
			]
		);

		$this->add_control(
			'hover_tab_title_text_color', [
				'label'     => __( 'Text Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab_shortcode .spel_tab_title :hover, 
					 {{WRAPPER}} .header_tab_items .spel_tab_title :hover' => 'color: {{VALUE}};',
				)
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'hover_tab_title_bg_color',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' =>
					'{{WRAPPER}} .tab_shortcode .tab-item-title:hover,
					{{WRAPPER}} .header_tab_items .spel_tab_title :hover',
			]
		);

		$this->end_controls_tab(); //End Hover Tab Title


		//=== Active Tab Title
		$this->start_controls_tab(
			'style_tab_title_active', [
				'label' => __( 'Active', 'spider-elements' ),
			]
		);

		$this->add_control(
			'active_tab_title_text_color', [
				'label'     => __( 'Text Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab_shortcode .spel_tab_title .active, 
					 {{WRAPPER}} .header_tab_items .spel_tab_title .active' => 'color: {{VALUE}};',
				)
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'active_tab_title_bg_color',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' =>
					'{{WRAPPER}} .tab_shortcode .tab-item-title.active, 
					{{WRAPPER}} .header_tab_items .spel_tab_title .active',

			]
		);


		$this->add_control(
			'active_tab_title_border_color',
			[
				'label'     => __( 'Border Top Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab_shortcode .spel_tab_title .active::before,
					 {{WRAPPER}} .tab_shortcode .nav-tabs .nav-item .nav-link:hover::before' => 'background: {{VALUE}};',
				),
				'condition' => [
					'style' => [ '1' ]
				]
			]
		);

		$this->add_control(
			'active_tab_icon_bg_color',
			[
				'label'     => __( 'Icon Background Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab-item-title.active > .numb,
                     {{WRAPPER}} .tab-item-title:hover > .numb' => 'background: {{VALUE}};',
				),
				'condition' => [
					'is_auto_numb' => 'yes',
				]
			]
		);

		$this->end_controls_tab(); // End Active Tab Title

		$this->end_controls_section(); // End Tab Title Style

		//============================ Tab ProgressBar Style ============================//
		$this->start_controls_section(
			'style_tabs_progressbar',
			[
				'label' => __( 'Tab ProgressBar', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'is_auto_play' => 'yes',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'progressbar_bg_color',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' =>
					'{{WRAPPER}} .spe_auto_tabs .nav-item .nav-link .progress-bar,{{WRAPPER}} .spe_auto_tabs .nav-item .nav-link.active .tab_progress:before', 

			]
		);
		$this->add_responsive_control(
			'progressbar_height', [
				'label'      => __( 'Progress Bar Hegiht', 'spider-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '2',
				],
				'selectors'  => [
					'{{WRAPPER}} .spe_auto_tabs .nav-item .nav-link .progress-bar,{{WRAPPER}} .spe_auto_tabs .nav-item .nav-link .tab_progress' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		//=============================== Content Section ===============================//
		$this->start_controls_section(
			'style_content',
			[
				'label' => __( 'Content', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'tabs_content_typo',
				'selector'  => '{{WRAPPER}} .tab-content .tab_style',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tabs_content_text_color',
			[
				'label'     => __( 'Text Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tab-content .tab_style, {{WRAPPER}} .tab-content .tab-pane' => 'color: {{VALUE}}',
				)
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tabs_border',
				'label'    => esc_html__( 'Border', 'spider-elements' ),
				'selector' => '{{WRAPPER}} .tab_shortcode .tab-content, {{WRAPPER}} .header_tab_content .tab-content',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => __( 'Border Radius', 'spider-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tab_shortcode .tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content-pad',
			[
				'label'      => __( 'Padding', 'spider-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .tab_shortcode .tab-content, {{WRAPPER}} .header_tab_content .tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(), [
				'name'     => 'content_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tab-content',
			]
		);

		$this->end_controls_section(); // End Content Section


		//=============================== Navigation Arrow ===============================//
		$this->start_controls_section(
			'style_nav_arrow',
			[
				'label'     => __( 'Navigation Arrow', 'spider-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'is_navigation_arrow' => 'yes',
				]
			]
		);

		$this->end_controls_section(); // End Navigation Arrow

	}


	/**
	 * Name: elementor_render()
	 * Desc: Render the widget output on the frontend.
	 * Params: no params
	 * Return: @void
	 * Since: @1.0.0
	 * Package: @spider-elements
	 * Author: spider-themes
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings ); //extract all settings array to variables converted to name of key

		$tabs   = $this->get_settings_for_display( 'tabs' );
		$id_int = substr( $this->get_id_int(), 0, 3 );

		$navigation_arrow_class = ! empty( $is_navigation_arrow == 'yes' ) ? ' process_tab_shortcode' : '';
		$sticky_tab_class       = ! empty( $is_sticky_tab == 'yes' ) ? ' sticky_tab' : '';
		$tab_auto_class = !empty( $is_auto_play == 'yes' ) ? 'spe_auto_tabs' : '';

		//================= Template Parts =================//
		include "templates/tabs/tab-{$settings['style']}.php";

	}


}