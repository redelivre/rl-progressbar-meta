<?php
require_once 'BarCountersItem.php';
class ET_Builder_Module_Bar_Counters_Meta extends ET_Builder_Module_Bar_Counters {
	function init() {
		parent::init();
		$this->name            = esc_html__( 'Bar Counters from Meta', 'et_builder' );
		$this->plural          = esc_html__( 'Bar Counters from Meta', 'et_builder' );
		$this->slug            = 'et_pb_counters_meta';
		$this->child_slug      = 'et_pb_counter_meta';
		$this->child_item_text = esc_html__( 'Bar Counter Meta', 'et_builder' );
	}
	
	function render( $attrs, $content = null, $render_slug ) {
		$render_slug = RLProgressBarMeta::fix_classname($render_slug);
		return parent::render( $attrs, $content = null, $render_slug );
	}
}

new ET_Builder_Module_Bar_Counters_Meta;
