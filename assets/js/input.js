(function($){


	/**
	*  initialize_field
	*
	*  This function will initialize the $field.
	*
	*  @date	30/11/17
	*  @since	5.6.5
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function initialize_field( $field ) {

		function controls() {
			return $field.find('div[acf-css-gradient-picker-id]');
		}

		function updateOutput() {
			var $output = $field.find('div.acf-css-gradient-picker-output');
			var $input1 = $field.find('div[acf-css-gradient-picker-id="1"]').find('input[type="text"]');
			var $input2 = $field.find('div[acf-css-gradient-picker-id="2"]').find('input[type="text"]');

			var $type = $field.find('div.acf-css-gradient-picker-type input[type="radio"]:checked').val();

			var $stop1 = $field.find('div[acf-css-gradient-picker-id="1"]').find('input[type="number"]');
			var $stop2 = $field.find('div[acf-css-gradient-picker-id="2"]').find('input[type="number"]');

			// $angle = 90;
			var $angle = $field.find('div.acf-css-gradient-picker-angle').find('input[type="number"]');
			$angle = $($angle).val();

			$gradient = $input1.val() + ' ' + $stop1.val() + '%, ' + $input2.val() + ' ' + $stop2.val() + '%';
			if($type == 'radial') {
					var $output_css = 'radial-gradient(circle, ' + $gradient + ')';
			} else {
					var $output_css = 'linear-gradient(' + $angle + 'deg, ' + $gradient + ')';
			}
			$output.css('background', $output_css);

			var $global_outputs = $field.find('div.global_inputs');
			var $global_outputs_inputText = $($global_outputs).find('input[type="text"]');

			var $save_str = '';
			$save_str += 'type:' + $type + ';';
			$save_str += 'angle:' + $angle + ';';
			$save_str += 'colours:' + $input1.val() + ',' + $input2.val() + ';';
			$save_str += 'stops:' + $stop1.val() + ',' + $stop2.val() + ';';

			acf.val( $global_outputs_inputText, $save_str );
			$global_outputs_inputText.val($save_str);
		}

		function loadPreview() {
			var $global_outputs = $field.find('div.global_inputs');
			var $global_outputs_inputText = $($global_outputs).find('input[type="text"]');

			
			var $type = $($global_outputs_inputText).val().match('(?<=type:)([a-zA-Z]+);')[1];
			var $angle = $($global_outputs_inputText).val().match('(?<=angle:)([0-9]+);')[1];
			var $colours = $($global_outputs_inputText).val().match('(?<=colours\:)(#[a-zA-Z0-9]+\,#[a-zA-Z0-9]+);')[1];
			$colours = $colours.split(",");
			var $stops = $($global_outputs_inputText).val().match('(?<=stops\:)([0-9]+\,[0-9]+);')[1];
			$stops = $stops.split(",");

			$css_output = buildOutput($type, $angle, $colours[0], $stops[0], $colours[1], $stops[1]);

			console.log($css_output);
			var $output = $field.find('div.acf-css-gradient-picker-output');
			$($output).css('background', $css_output);
		}

		function onClickSelectType() {
			var $selectType = $('.acf-css-gradient-picker-type input[type="radio"]');
			$($selectType).click(function(e) {
				var $label = $(this).parent('label');
				var selected = $($label).hasClass('selected');

				$('input[type="radio"]').parent('label').removeClass('selected');
				$('input[type="radio"]').prop('checked', false);
				$label.addClass('selected');
				$(this).prop('checked', true);

				setTimeout(function(){
					updateOutput();
				}, 1);
			});
		}

		function buildOutput($type, $angle, $colour1, $stop1, $colour2, $stop2) {

			$output = '';
			$output += $type + '-gradient';
			if($type == "radial") {
				$output += '(circle, ';
			} else {
				$output += '(' + $angle + 'deg, ';
			}
			$output += $colour1 + ' ' + $stop1 + '%, ';
			$output += $colour2 + ' ' + $stop2 + '%)';
			return $output;
		}

		function onChangeStopPosition() {
			var $stop_field = $field.find('div[acf-css-gradient-picker-id]').find('input[type="number"]');
			$($stop_field).change(function(){

				setTimeout(function(){
					updateOutput();
				}, 1);
			})
		}

		function onChangeAngle() {
			var $angle_field = $field.find('div.acf-css-gradient-picker-angle').find('input[type="number"]');
			$($angle_field).change(function(){
				setTimeout(function(){
					updateOutput();
				}, 1);
			})
		}

		// loadSelectType();
		onClickSelectType();
		onChangeAngle();
		onChangeStopPosition();
		loadPreview();



		var $els = controls();

		$els.each(function($index, $el) {
			$el = $($el);
			var $input			= $el.find('input[type="hidden"]');
			var $inputText	= $el.find('input[type="text"]');

			var onChange = function(e) {
				// // timeout is required to ensure the $input val is correct
				setTimeout(function(){
					updateOutput();
					// acf.val( $input, 'test' );
				}, 1);
			}

			// args
			var args = {
				defaultColor: false,
				palettes: true,
				hide: true,
				change: onChange,
				clear: onChange
			};

			$inputText.wpColorPicker( args );

		});


	}



	if( typeof acf.add_action !== 'undefined' ) {

		/*
		*  ready & append (ACF5)
		*
		*  These two events are called when a field element is ready for initizliation.
		*  - ready: on page load similar to $(document).ready()
		*  - append: on new DOM elements appended via repeater field or other AJAX calls
		*
		*  @param	n/a
		*  @return	n/a
		*/

		acf.add_action('ready_field/type=css_gradient_picker', initialize_field);
		acf.add_action('append_field/type=css_gradient_picker', initialize_field);


	} else {

		/*
		*  acf/setup_fields (ACF4)
		*
		*  These single event is called when a field element is ready for initizliation.
		*
		*  @param	event		an event object. This can be ignored
		*  @param	element		An element which contains the new HTML
		*  @return	n/a
		*/

		$(document).on('acf/setup_fields', function(e, postbox){

			// find all relevant fields
			$(postbox).find('.field[data-field_type="FIELD_NAME"]').each(function(){

				// initialize
				initialize_field( $(this) );

			});

		});

	}

})(jQuery);
