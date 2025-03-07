<?php
/**
 * Use namespace to avoid conflict
 */

namespace SPEL\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Video_playlist
 * @package spider\Widgets
 * @since 1.0.0
 */
class Video_Playlist extends Widget_Base {
	public function get_name() {
		return 'docy_videos_playlist'; // ID of the widget (Don't change this name)
	}

	public function get_title() {
		return esc_html__( 'Video Playlist', 'spider-elements' );
	}

	public function get_icon() {
		return 'eicon-video-playlist spel-icon';
	}

	/**
	 * Name: get_style_depends()
	 * Desc: Register the required CSS dependencies for the frontend.
	 */
	public function get_style_depends() {
		return [ 'ionicons', 'slick', 'slick-theme', 'elegant-icon', 'video-js', 'video-js-theaterMode', 'spel-main' ];
	}

	/**
	 * Name: get_script_depends()
	 * Desc: Register the required JS dependencies for the frontend.
	 */
	public function get_script_depends() {
		return [ 'slick', 'video-js', 'artplayer', 'video-js-nuevo', 'ionicons', 'spel-el-widgets', 'spel-script' ];
	}

	public function get_keywords() {
		return [ 'spider', 'spider elements', 'video', 'playlist', 'video playlist', 'video list' ];
	}

	public function get_categories() {
		return [ 'spider-elements' ];
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


		//==================== Select Preset Skin ====================//
		$this->start_controls_section(
			'spe_video_preset', [
				'label' => __( 'Preset Skin', 'spider-elements' ),
			]
		);

		$this->add_control(
			'style', [
				'label'   => esc_html__( 'Skin', 'spider-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'1' => [
						'title' => __( 'Tab', 'spider-elements' ),
						'icon'  => 'video-playlist',
					],
					'2' => [
						'title' => __( 'Slide', 'spider-elements' ),
						'icon'  => 'video-playlist2',
					],
				],
				'toggle'  => false,
				'default' => '1',
			]
		);

		$this->end_controls_section(); // End Preset Skin


		//======================= Title Section =======================//
		$this->start_controls_section(
			'title_opt_sec', [
				'label'     => __( 'Title', 'spider-elements' ),
				'condition' => [
					'style' => [ '1' ]
				]
			]
		);

		$this->add_control(
			'title', [
				'label'     => esc_html__( 'Title text', 'spider-elements' ),
				'type'      => Controls_Manager::TEXTAREA,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_tag', [
				'label'   => __( 'Title HTML Tag', 'spider-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => spel_get_title_tags(),
				'default' => 'h3',
			]
		);

		$this->add_control(
			'color_title', [
				'label'     => __( 'Text Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name'     => 'typography_title',
				'selector' => '{{WRAPPER}} .title'
			]
		);

		$this->end_controls_section(); // End Title Section


		//======================= Video Playlist Section =======================//
		$this->start_controls_section(
			'section_playlist', [
				'label' => esc_html__( 'Playlist', 'spider-elements' ),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Heading', 'spider-elements' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Title', 'spider-elements' ),
				'placeholder' => esc_html__( 'Tab Title Text Here', 'spider-elements' ),
				'label_block' => true,
			]
		);

		$repeater2 = new repeater();
		$repeater2->add_control(
			'title2', [
				'label'       => esc_html__( 'Title', 'spider-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater2->add_control(
			'video_upload', [
				'label'      => esc_html__( 'Upload Video', 'spider-elements' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
			]
		);

		$repeater2->add_control(
			'thumbnail', [
				'label'   => esc_html__( 'Thumbnail', 'spider-elements' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater2->add_control(
			'video_caption', [
				'label'       => esc_html__( 'Description', 'spider-elements' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Default title', 'spider-elements' ),
				'placeholder' => esc_html__( 'Type your caption here', 'spider-elements' ),
				'description' => esc_html__( 'This field is applicable for Preset Two', 'spider-elements' ),
			]
		);

		$repeater2->add_control(
			'current_author', [
				'label'   => esc_html__( 'Author', 'spider-elements' ),
				'type'    => Controls_Manager::HIDDEN,
				// current login user name
				'default' => get_current_user_id() ? get_userdata( get_current_user_id() )->display_name : ''
			]
		);
		// CURRENT DATE control
		$repeater2->add_control(
			'current_date', [
				'label'   => esc_html__( 'Current Date', 'spider-elements' ),
				'type'    => Controls_Manager::HIDDEN,
				// DEFAULT CURRENT DATE with time zone
				'default' => date( get_option( 'date_format' ) . get_option( 'time_format' ), current_time( 'timestamp', 0 ) )
			]
		);

		$repeater->add_control(
			'videos', [
				'label'              => esc_html__( 'Playlist Items', 'spider-elements' ),
				'type'               => Controls_Manager::REPEATER,
				'fields'             => $repeater2->get_controls(),
				'default'            => [
					[
						'title2' => esc_html__( 'Add Video', 'spider-elements' ),
					]
				],
				'frontend_available' => true,
				'title_field'        => '{{{ title2 }}}'
			]
		);

		$this->add_control(
			'tabs', [
				'label'              => esc_html__( 'Playlist Items', 'spider-elements' ),
				'type'               => Controls_Manager::REPEATER,
				'fields'             => $repeater->get_controls(),
				'default'            => [
					[
						'title' => esc_html__( 'Insert Video', 'spider-elements' ),
					]
				],
				'frontend_available' => true,
				'title_field'        => '{{{ title }}}',
				'prevent_empty'      => true,
			]
		);

		$this->end_controls_section(); // end of playlist section

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

		// Style Section
		$this->start_controls_section(
			'style_sec',
			[
				'label' => esc_html__( 'Style Section', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'sec_padding', [
				'label'      => __( 'Section padding', 'spider-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .video_list_area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'unit' => 'px', // The selected CSS Unit. 'px', '%', 'em',
				],
			]
		);

		$this->add_control(
			'sec_bg_color', [
				'label'     => esc_html__( 'Background Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video_list_area' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_layout',
			[
				'label' => esc_html__( 'Layout', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'layout_height',
			[
				'label'      => esc_html__( 'Height', 'spider-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .e-tabs .e-tabs-main-area' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_top_bar',
			[
				'label' => esc_html__( 'Top Bar', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_playlist_name',
			[
				'label' => esc_html__( 'Playlist Name', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'playlist_name_background',
			[
				'label'     => esc_html__( 'Background', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tabs-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'playlist_name_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .e-tabs-header .e-tabs-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'playlist_name_typography',
				'selector' => '{{WRAPPER}} .e-tabs-header .e-tabs-title',
			]
		);

		$this->add_control(
			'heading_videos_amount',
			[
				'label' => esc_html__( 'Video Count', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'videos_amount_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .e-tabs-header .e-tabs-videos-count'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .e-tabs-header .e-tabs-header-right-side i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .e-tabs-header .e-tabs-header-right-side svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'videos_amount_typography',
				'selector' => '{{WRAPPER}} .e-tabs-header .e-tabs-videos-count',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_videos',
			[
				'label' => esc_html__( 'Videos', 'spider-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'playlist_tabs' );

		$this->start_controls_tab(
			'playlist_tabs_normal',
			[
				'label' => esc_html__( 'Normal', 'spider-elements' ),
			]
		);

		$this->add_control(
			'heading_tab_normal',
			[
				'label' => esc_html__( 'Item', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'normal_background',
			[
				'label'     => esc_html__( 'Background', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video_list .video_list_inner .card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'normal_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tab-title .e-tab-title-text'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .e-tab-title .e-tab-title-text a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name'     => 'normal_typography',
				'selector' => '{{WRAPPER}} .e-tab-title .e-tab-title-text',
			]
		);

		$this->add_control(
			'heading_duration_normal',
			[
				'label' => esc_html__( 'Duration', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'normal_duration_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tab-title .e-tab-duration' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'normal_duration_typography',
				'selector' => '{{WRAPPER}} .e-tab-title .e-tab-duration',
			]
		);

		$this->add_control(
			'heading_icon_normal',
			[
				'label' => esc_html__( 'Icon', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'normal_icon_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video_list .video_list_inner .card .card-body .nav li a .media .d-flex .video_tab_img:after' => 'color: {{VALUE}};',
				],
			]
		);


		// Default shadow values for the icon.
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'           => 'normal_icon_top_text_shadow',
				'fields_options' => [
					'text_shadow_type' => [
						'label' => _x( 'Shadow', 'Text Shadow Control', 'spider-elements' ),
					],
					'text_shadow'      => [
						'selectors' => [
							'{{WRAPPER}} .e-tab-title i'   => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
							'{{WRAPPER}} .e-tab-title svg' => 'filter: drop-shadow({{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}});',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'normal_icon_size',
			[
				'label'     => esc_html__( 'Size', 'spider-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'min' => 10,
					'max' => 30,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--playlist-item-icon-size: {{SIZE}}px',
					'{{WRAPPER}}' => '--playlist-item-icon-size: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'heading_separator_normal',
			[
				'label'     => esc_html__( 'Separator', 'spider-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'normal_separator_style',
			[
				'label'     => esc_html__( 'Style', 'spider-elements' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''       => esc_html__( 'None', 'spider-elements' ),
					'solid'  => _x( 'Solid', 'Border Control', 'spider-elements' ),
					'double' => _x( 'Double', 'Border Control', 'spider-elements' ),
					'dotted' => _x( 'Dotted', 'Border Control', 'spider-elements' ),
					'dashed' => _x( 'Dashed', 'Border Control', 'spider-elements' ),
					'groove' => _x( 'Groove', 'Border Control', 'spider-elements' ),
				],
				'selectors' => [
					'{{WRAPPER}} .e-tab-title' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'normal_separator_weight',
			[
				'label'     => esc_html__( 'Weight', 'spider-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'min' => 0,
					'max' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .e-tab-title' => 'border-width: 0 0 {{SIZE}}px 0;',
				],
				'condition' => [
					'normal_separator_style!' => '',
				],
			]
		);

		$this->add_control(
			'normal_separator_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tab-title' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'normal_separator_style!' => '',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'playlist_tabs_active',
			[
				'label' => esc_html__( 'Active', 'spider-elements' ),
			]
		);

		$this->add_control(
			'heading_tab_active',
			[
				'label' => esc_html__( 'Item', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'active_background',
			[
				'label'     => esc_html__( 'Background', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tabs-items .e-tab-title:where( .e-active, :hover )' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#556068',
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) .e-tab-title-text'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) .e-tab-title-text a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(), [
				'name'     => 'active_typography',
				'selector' => '{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) .e-tab-title-text',
			]
		);

		$this->add_control(
			'heading_duration_active', [
				'label' => esc_html__( 'Duration', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'active_duration_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) .e-tab-duration' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'active_duration_typography',
				'selector' => '{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) .e-tab-duration',
			]
		);

		$this->add_control(
			'heading_icon_active',
			[
				'label' => esc_html__( 'Icon', 'spider-elements' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'active_icon_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) svg'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title:where( .e-active, :hover ) svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'           => 'active_icon_top_text_shadow',
				'fields_options' => [
					'text_shadow_type' => [
						'label' => _x( 'Shadow', 'Text Shadow Control', 'spider-elements' ),
					],
				],
				'selector'       => '{{WRAPPER}} .e-tab-title:where( .e-active, :hover ) i, {{WRAPPER}} .e-tab-title:where( .e-active, :hover ) svg',
			]
		);

		$this->add_responsive_control(
			'active_icon_size',
			[
				'label'     => esc_html__( 'Size', 'spider-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'min' => 10,
					'max' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .e-tab-title:where( .e-active, :hover ) span i'   => 'font-size: {{SIZE}}px',
					'{{WRAPPER}} .e-tab-title:where( .e-active, :hover ) span svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'heading_separator_active',
			[
				'label'     => esc_html__( 'Separator', 'spider-elements' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'active_separator_style',
			[
				'label'     => esc_html__( 'Style', 'spider-elements' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''       => esc_html__( 'None', 'spider-elements' ),
					'solid'  => _x( 'Solid', 'Border Control', 'spider-elements' ),
					'double' => _x( 'Double', 'Border Control', 'spider-elements' ),
					'dotted' => _x( 'Dotted', 'Border Control', 'spider-elements' ),
					'dashed' => _x( 'Dashed', 'Border Control', 'spider-elements' ),
					'groove' => _x( 'Groove', 'Border Control', 'spider-elements' ),
				],
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title.e-active' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'active_separator_weight',
			[
				'label'     => esc_html__( 'Weight', 'spider-elements' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'min' => 0,
					'max' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tab-title.e-active' => 'border-width: 0 0 {{SIZE}}px 0;',
				],
				'condition' => [
					'active_separator_style!' => '',
				],
			]
		);

		$this->add_control(
			'active_separator_color',
			[
				'label'     => esc_html__( 'Color', 'spider-elements' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .e-tabs-items-wrapper .e-tabs-items .e-tab-title.e-active' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'active_separator_style!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

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
		$settings = $this->get_settings();
		extract( $settings ); //extract all settings array to variables converted to name of key

		// Render the widget output on the frontend.
		include "templates/video-playlist/video-playlist-{$settings['style']}.php";

	}
}