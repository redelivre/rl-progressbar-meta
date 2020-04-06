<?php
class RLProgressBarMeta {
	
	public function __construct() {
		add_action('init', array($this, 'init'), 20);
	}
	
	public function init() {
		add_action('et_builder_ready', array($this, 'et_builder_ready'), 20 );
		add_filter('et_builder_counters_meta_classes', array($this, 'fix_classname'), 10, 1);
		add_filter('et_builder_counter_meta_classes', array($this, 'fix_classname'), 10, 1);
	}
	
	public function et_builder_ready()
	{
		require_once dirname(__FILE__).'/modules/modules.php';
	}
	
	public static function fix_classname($classname) {
		if(is_array($classname)) {
			foreach ($classname as $k => $cl) {
				$classname[$k] = str_replace('_meta', '', $cl);
			}
		} elseif(is_string($classname)) {
			$classname = str_replace('_meta', '', $classname);
		}
		return $classname;
	}
	
	
	
}
new RLProgressBarMeta();