<?php

class ET_Builder_Module_Bar_Counters_Item_Meta extends ET_Builder_Module_Bar_Counters_Item {
	function init() {
		parent::init();
		$this->name                        = esc_html__( 'Bar Counter Meta', 'et_builder' );
		$this->plural                      = esc_html__( 'Bar Counters Meta', 'et_builder' );
		$this->slug                        = 'et_pb_counter_meta';
		$this->render_slug                 = 'et_pb_counter';
		$this->advanced_setting_title_text = esc_html__( 'New Bar Counter from Meta', 'et_builder' );
		$this->settings_text               = esc_html__( 'Bar Counter from meta Settings', 'et_builder' );

	}

	function get_fields() {
		$fields = array(
			'content' => array(
				'label'           => esc_html__( 'Title', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input a title for your bar.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
			),
			'post_id_meta' => array(
				'label'            => esc_html__( 'Post Id from where get data', 'et_builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Define Id to get metas.', 'et_builder' ),
				'toggle_slug'      => 'main_content',
				'default_on_front' => '0',
			),
			'percent_meta' => array(
				'label'            => esc_html__( 'Percent Post Meta', 'et_builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Define a percentage for this bar from a post meta field.', 'et_builder' ),
				'toggle_slug'      => 'main_content',
				'default_on_front' => '0',
			),
			'percent_max_value_meta' => array(
				'label'            => esc_html__( 'Max Value Meta for Percent Calculation', 'et_builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Define a max value for percentage calculation from a post meta field.', 'et_builder' ),
				'toggle_slug'      => 'main_content',
				'default_on_front' => '0',
			),
			'bar_background_color' => array(
				'label'        => esc_html__( 'Bar Background Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'hover'        => 'tabs',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'bar',
			),
		);

		return $fields;
	}

	function render( $attrs, $content = null, $render_slug ) {
		$render_slug = RLProgressBarMeta::fix_classname($render_slug);
		global $et_pb_counters_settings;

		$post_id_meta				   = intval(esc_attr($this->props['post_id_meta']));
		$percent_meta                  = floatval(esc_attr( get_post_meta($post_id_meta, $this->props['percent_meta'], true) ));
		$percent_max_value_meta		   = floatval(esc_attr( get_post_meta($post_id_meta, $this->props['percent_max_value_meta'], true) ));
		//echo "id: $post_id_meta, P: $percent_meta, M: $percent_max_value_meta";
		
		$percent                       = ($percent_meta * 100 ) / $percent_max_value_meta;
		$background_color              = self::$_->array_get( $this->props, 'background_color' );
		$background_color              = empty( $background_color ) ? $et_pb_counters_settings['background_color'] : $background_color;
		$background_color_hover        = self::get_hover_value( 'background_color' );
		$bar_background_color          = self::$_->array_get( $this->props, 'bar_background_color' );
		$bar_background_color          = empty( $bar_background_color ) ? $et_pb_counters_settings['bar_bg_color'] : $bar_background_color;
		$bar_background_hover_color    = et_pb_hover_options()->get_value( 'bar_background_color', $this->props );
		$background_image              = $this->props['background_image'];
		$use_background_color_gradient = $this->props['use_background_color_gradient'];

		// Add % only if it hasn't been added to the attribute
		if ( '%' !== substr( trim( $percent ), -1 ) ) {
			$percent .= '%';
		}

		if ( empty( $background_color_hover ) ) {
			$background_color_hover = $et_pb_counters_settings['background_color_hover'];
		}


		$background_color_style = $bar_bg_color_style = '';

		if ( '' !== $background_color ) {
			if ( empty( $background_image ) && 'on' !== $use_background_color_gradient ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => '.et_pb_counters %%order_class%% .et_pb_counter_container',
					'declaration' => 'background-image: none;',
				) );
			}
		}

		if ( '' !== $background_color ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_counter_container',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color )
				),
			) );
		}

		if ( '' !== $background_color_hover ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_counter_container:hover',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $background_color_hover )
				),
			) );
		}

		if ( '' !== $bar_background_color ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_counter_amount',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $bar_background_color )
				),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .et_pb_counter_amount.overlay',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $bar_background_color )
				),
			) );
		}

		if ( '' !== $bar_background_hover_color ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '.et_pb_counters %%order_class%% .et_pb_counter_amount',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $bar_background_hover_color )
				),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '.et_pb_counters %%order_class%%:hover .et_pb_counter_amount.overlay',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $bar_background_hover_color )
				),
			) );
		}

		$video_background = $this->video_background();
		$parallax_image_background = $this->get_parallax_image_background();

		// Module classname
		$this->add_classname( $this->get_text_orientation_classname() );

		// Remove automatically added classnames
		$this->remove_classname( array(
			'et_pb_module',
			$render_slug,
		) );

		$output = sprintf(
			'<li class="%6$s">
				<span class="et_pb_counter_title">%1$s</span>
				<span class="et_pb_counter_container"%4$s>
					%8$s
					%7$s
					<span class="et_pb_counter_amount" style="%5$s" data-width="%3$s"><span class="et_pb_counter_amount_number">%2$s</span></span>
					<span class="et_pb_counter_amount overlay" style="%5$s" data-width="%3$s"><span class="et_pb_counter_amount_number">%2$s</span></span>
				</span>
			</li>',
			sanitize_text_field( $content ),
			( isset( $et_pb_counters_settings['use_percentages'] ) && 'on' === $et_pb_counters_settings['use_percentages'] ? esc_html( $percent ) : '' ),
			esc_attr( $percent ),
			$background_color_style,
			$bar_bg_color_style,
			$this->module_classname( $render_slug ),
			$video_background,
			$parallax_image_background
		);

		return $output;
	}
	
}
new ET_Builder_Module_Bar_Counters_Item_Meta();
