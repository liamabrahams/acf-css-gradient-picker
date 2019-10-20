<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('acf_css_gradient_picker') ) :

function acf_number_input($atts = array()) {
	echo sprintf('<input %s />', acf_esc_attrs($atts));
}

function acf_map_atts($keys = array(), $field) {
	$atts = array();
	foreach( $keys as $k ) {
		if( isset($field[ $k ]) ) $atts[ $k ] = $field[ $k ];
	}
	$atts = acf_clean_atts( $atts );
	return $atts;
}

class acf_css_gradient_picker extends acf_field {


	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct( $settings ) {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'css_gradient_picker';

		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Gradient Picker', 'acf-gradient-picker');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'jquery';


		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/

		$this->defaults = array(
			'default_value' => array(
				'format'	=> 'linear',
				'angle'	=> 90,
				'colours'	=> array(
					'colour1' => '#cccccc',
					'colour2' => '#fff',
				),
				'stops'	=> array(
					'stop1' => 0,
					'stop2'=> 100,
				),
			),
		);


		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/

		// $this->l10n = array(
		// 	'error'	=> __('Error! Please enter a higher value', 'acf-gradient-picker'),
		// );


		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/

		$this->settings = $settings;


		// do not delete!
    	parent::__construct();

	}


	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field_settings( $field ) {

		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/

		// acf_render_field_setting( $field, array(
		// 	'label'			=> __('Font Size','acf-gradient-picker'),
		// 	'instructions'	=> __('Customise the input font size','acf-gradient-picker'),
		// 	'type'			=> 'number',
		// 	'name'			=> 'font_size',
		// 	'prepend'		=> 'px',
		// ));

	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field( $field ) {


		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/

		$input_number_keys = array( 'type', 'value', 'min', 'max', 'step');

		// vars
		$input = acf_get_sub_array( $field, array('id', 'class', 'name') );
		$input_hidden = acf_get_sub_array( $field, array('name') );

		// Get the full input
		$input_main = array_merge($input, array('value' => $field['value']));
		// $input_hidden_main = array_merge($input_hidden, array('value' => $field['value']));

		// Get the gradient format
		$format = $field['value']['format'];
		$input_format = array_merge(array('value' => $format), $input, array('choices' => array('linear' => 'Linear', 'radial' => 'Radial')));

		// Get the angle
		$atts_angle = acf_map_atts($input_number_keys, array('value' => $field['value']['angle']));
		$atts_angle = array_merge(acf_clean_atts( $atts_angle ), $input, array('min' => 0, 'max' => 360, 'step' => 1, 'type' => 'number', 'class' => 'acf-is-append'));

		// Get colour1
		$input_colour1 = array_merge($input, array('value' => $field['value']['colours']['colour1']));
		$input_hidden_colour1 = array_merge($input_hidden, array('value' => $field['value']['colours']['colour1']));

	 	// Get colour2
		$input_colour2 = array_merge($input, array('value' => $field['value']['colours']['colour2']));
		$input_hidden_colour2 = array_merge($input_hidden, array('value' => $field['value']['colours']['colour2']));

		// Get the stops
		$atts_stop1 = acf_map_atts($input_number_keys, array('value' => $field['value']['stops']['stop1']));
		$atts_stop1 = array_merge(acf_clean_atts( $atts_stop1 ), $input, array('min' => 0, 'max' => 100, 'step' => 1, 'type' => 'number', 'class' => 'acf-is-append'));

		$atts_stop2 = acf_map_atts($input_number_keys, array('value' => $field['value']['stops']['stop2']));
		$atts_stop2 = array_merge(acf_clean_atts( $atts_stop2 ), $input, array('min' => 0, 'max' => 100, 'step' => 1, 'type' => 'number', 'class' => 'acf-is-append'));






		// html
		?>


				<div class="acf-row">
					<div class="acf-column-50 acf-column--first">
						<div class="acf-column-row">
							<div class="acf-column-row-col-50 acf-column-row-col--first">
								<h4>Gradient Type</h4>
								<div class="acf-input-wrap">
									<div class="acf-css-gradient-picker__gradient-select">
										<?php acf_select_input($input_format); ?>
									</div>
								</div>
							</div>
							<div class="acf-column-row-col-50 acf-column-row-col--last">
								<h4>Angle</h4>
								<div class="acf-input">
									<div class="acf-input-append">deg</div>
									<div class="acf-css-gradient-picker__angle acf-input-wrap">
										<?php acf_number_input($atts_angle); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="acf-column-row">
							<div class="acf-column-row-col-50 acf-column-row-col--first">
								<h4>Colour 1</h4>
								<div class="acf-input-wrap">
									<div class="acf-css-gradient-picker__colour-picker" acf-css-gradient-picker__colour-picker-id="1">
										<?php acf_hidden_input( $input_colour1 ); ?>
										<?php acf_text_input( $input_hidden_colour1 ); ?>
									</div>
								</div>
							</div>
							<div class="acf-column-row-col-50 acf-column-row-col--last">
								<h4>Colour 1 Stop</h4>
								<div class="acf-input">
									<div class="acf-input-append">%</div>
									<div class="acf-css-gradient-picker__stop acf-input-wrap" acf-css-gradient-picker__stop-id="1">
										<?php acf_number_input($atts_stop1); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="acf-column-row">
							<div class="acf-column-row-col-50 acf-column-row-col--first">
								<div class="acf-input-wrap">
									<div class="acf-css-gradient-picker__colour-picker" acf-css-gradient-picker__colour-picker-id="2">
										<h4>Colour 2</h4>
										<?php acf_hidden_input( $input_colour2 ); ?>
										<?php acf_text_input( $input_hidden_colour2 ); ?>
									</div>
								</div>
							</div>
							<div class="acf-column-row-col-50 acf-column-row-col--last">
								<h4>Colour 2 Stop</h4>
								<div class="acf-input">
									<div class="acf-input-append">%</div>
									<div class="acf-css-gradient-picker__stop acf-input-wrap" acf-css-gradient-picker__stop-id="2">
										<?php acf_number_input($atts_stop2); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="acf-column-50 acf-column--last">
						<h4>Preview</h4>
						<div class="acf-css-gradient-picker-preview"></div>
					</div>
				</div>
				<div class="global_input">
					<?php acf_hidden_input( $input_main ); ?>
				</div>

			<?php
	}


	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/



	function input_admin_enqueue_scripts() {

		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];

		// register & include JS
		wp_register_script('acf-gradient-picker', "{$url}assets/js/input.js", array('acf-input'), $version);
		wp_enqueue_script('acf-gradient-picker');
		//

		// register & include CSS
		wp_register_style('acf-gradient-picker', "{$url}assets/css/input.css", array('acf-input'), $version);
		wp_enqueue_style('acf-gradient-picker');

	}



	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_head() {



	}

	*/


	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/

   	/*

   	function input_form_data( $args ) {



   	}

   	*/


	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_footer() {



	}

	*/


	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_enqueue_scripts() {

	}

	*/


	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_head() {

	}

	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	/*
	function load_value( $value, $post_id, $field ) {
		return $value;
	}
	*/




	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/


	function update_value( $value, $post_id, $field ) {
		$value = json_decode(stripslashes($value), true );
		return $value;
	}



	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/

	function format_value( $value, $post_id, $field ) {

		// bail early if no value
		if( empty($value) ) {
			return $value;
		}

		$gradient = '';

		if (
			!empty($value['format']) &&
			!empty($value['angle']) &&
			!empty($value['colours']['colour1']) &&
			!empty($value['colours']['colour2']) &&
			is_numeric($value['stops']['stop1']) &&
			is_numeric($value['stops']['stop2'])
		) {
			// Check the format
			if ($value['format'] === 'radial') {
				$gradient .= 'radial-gradient(circle, ';
			} else {
				$gradient .= 'linear-gradient(' . $value['angle'] . 'deg, ';
			}

			// Add colours
			$gradient .= $value['colours']['colour1'] . ' ' . $value['stops']['stop1']  . '%, ';
			$gradient .= $value['colours']['colour2'] . ' ' . $value['stops']['stop2']  . '%)';
		}
		
		$value['gradient'] = $gradient;

		// return
		return $value;
	}



	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/

	/*

	function validate_value( $valid, $value, $field, $input ){

		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}


		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','TEXTDOMAIN'),
		}


		// return
		return $valid;

	}

	*/


	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/

	/*

	function delete_value( $post_id, $key ) {



	}

	*/


	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function load_field( $field ) {

		return $field;

	}

	*/


	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/



	function update_field( $field ) {
		$value = json_decode(stripslashes($value), true );
		return $field;

	}



	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/

	/*

	function delete_field( $field ) {



	}

	*/


}


// initialize
new acf_css_gradient_picker( $this->settings );


// class_exists check
endif;

?>
