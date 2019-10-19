<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('acf_css_gradient_picker') ) :



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
			'font_size'	=> 14,
			'value'	=> 'type:linear;angle:90;colours:#000,#fff;stops:0,100',
			'type'	=> 'linear',
			'angle'	=> 90,
			'colours'	=> array('colour1' => '#000', 'colour2' => '#fff'),
			'stops'	=> array('stop1' => 0, 'stop2' => 100),
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

		echo '<pre>';
			print_r( $field );
		echo '</pre>';


		// PC::debug($field['value']);

		$colour = $field['value']['full'];
		$colour1 = $field['value']['colour1'];
		$colour2 = $field['value']['colour2'];

		if(!empty($field['value']['stop1'])) {
			$stop1 = $field['value']['stop1'];
		} else {
			$stop1 = 0;
		}
		if(!empty($field['value']['stop2'])) {
			$stop2 = $field['value']['stop2'];
		} else {
			$stop2 = 100;
		}
		if(!empty($field['value']['angle'])) {
			$angle = $field['value']['angle'];
		} else {
			$angle = 0;
		}

		// vars
		$text_input = acf_get_sub_array( $field, array('id', 'class', 'name') );
		$hidden_input = acf_get_sub_array( $field, array('name') );

		$text_input1 = acf_get_sub_array( $field, array('id', 'class', 'name') );
		$hidden_input1 = acf_get_sub_array( $field, array('name') );

		$text_input2 = acf_get_sub_array( $field, array('id', 'class', 'name') );
		$hidden_input2 = acf_get_sub_array( $field, array('name') );

		$text_input['value'] = $colour;
		$hidden_input['value'] = $colour;
		$text_input1['value'] = $colour1;
		$hidden_input1['value'] = $colour1;
		$text_input2['value'] = $colour2;
		$hidden_input2['value'] = $colour2;

		// PC::debug($text_input);


		// html
		?>
			<div class="acf-css-gradient-picker" acf-css-gradient-picker-id="1">
				<?php acf_hidden_input( $hidden_input1 ); ?>
				<?php acf_text_input( $text_input1 ); ?>
				<input type="number" name="colour1_stop" value="<?= $stop1; ?>" min="0" max="100"/>%
			</div>
			<div class="acf-css-gradient-picker" acf-css-gradient-picker-id="2">
				<?php acf_hidden_input( $text_input2 ); ?>
				<?php acf_text_input( $hidden_input2 ); ?>
				<input type="number" name="colour2_stop" value="<?= $stop2; ?>" min="0" max="100" />%
			</div>
			<div class="acf-css-gradient-picker-output"></div>

			<div class="global_inputs">
				<?php acf_hidden_input( $hidden_input ); ?>
				<?php acf_text_input( $text_input ); ?>
			</div>

			<div class="acf-button-group acf-css-gradient-picker-type">
				<label class="selected"><input type="radio" name="linear" value="linear" checked="checked"> Linear</label>
				<label><input type="radio" name="radial" value="radial"> Radial</label>
			</div>
			<br />
			<div class="acf-css-gradient-picker acf-css-gradient-picker-angle">
				<input type="number" value="<?= $angle; ?>" min="0" max="360"/> degrees
			</div>


			<?php


		/*
		*  Create a simple text input using the 'font_size' setting.
		*/

		/*?>
		<input type="text" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" style="font-size:<?php echo $field['font_size'] ?>px;" />
		<?php*/
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

		// // globals
		// global $wp_scripts;
		//
		//
		// // register if not already (on front end)
		// // http://wordpress.stackexchange.com/questions/82718/how-do-i-implement-the-wordpress-iris-picker-into-my-plugin-on-the-front-end
		// if( !isset($wp_scripts->registered['iris']) ) {
		//
		// 	// styles
		// 	wp_register_style('wp-color-picker', admin_url('css/color-picker.css'), array(), '', true);
		//
		//
		// 	// scripts
		// 	wp_register_script('iris', admin_url('js/iris.min.js'), array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), '1.0.7', true);
		// 	wp_register_script('wp-color-picker', admin_url('js/color-picker.min.js'), array('iris'), '', true);
		//
		//
		// 	// localize
		//     wp_localize_script('wp-color-picker', 'wpColorPickerL10n', array(
		//         'clear'			=> __('Clear', 'acf' ),
		//         'defaultString'	=> __('Default', 'acf' ),
		//         'pick'			=> __('Select Color', 'acf' ),
		//         'current'		=> __('Current Color', 'acf' )
		//     ));
		//
		// }
		//
		// // enqueue
		// wp_enqueue_style('wp-color-picker');
    // wp_enqueue_script('wp-color-picker');
		//
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


	function load_value( $value, $post_id, $field ) {
		$full = $value;

		// Get the colours
		preg_match('/(?<=colours\:)(#[a-zA-Z0-9]+\,#[a-zA-Z0-9]+);/', $full, $colours);
		$colours = explode(",", $colours[1]);
		// Get the stops
		preg_match('/(?<=stops\:)([0-9]+\,[0-9]+);/', $full, $stops);
		$stops = explode(",", $stops[1]);
		// Get the type
		preg_match('/(?<=type\:)([a-zA-Z]+);/', $full, $type);
		// Get the angle
		preg_match('/(?<=angle\:)([0-9]+);/', $full, $angle);


		$value = array(
			"colour1" => $colours[0],
			"colour2" => $colours[1],
			"stop1" => $stops[0],
			"stop2" => $stops[1],
			"type" => $type[1],
			"angle" => $angle[1],
			"full" => $full,
		);
		return $value;

	}


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

	/*

	function update_value( $value, $post_id, $field ) {

		return $value;

	}

	*/


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

		$input = $value;

		$value = '';
		$value .= $input['type'] . '-gradient';
		if($input['type'] == 'radial') {
			$value .= '(circle, ';
		} else {
			$value .= '(' . $input['angle'] . 'deg, ';
		}
		$value .= $input['colour1'] . ' ' . $input['stop1'] . '%, ';
		$value .= $input['colour2'] . ' ' . $input['stop2'] . '%)';

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

	/*

	function update_field( $field ) {

		return $field;

	}

	*/


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
