# Advanced Custom Fields: acf-css-gradient-picker Field
=====================

Contributors: Liam Abrahams
Tags: acf, gradient-picker
Requires at least: 5.8.2
Tested up to: 5.8.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Short Description

Generate a CSS Gradient from a ACF field.


## Long description

CSS Gradient Picker for ACF. Options to choose linear or gradient. Returns:

```
Array (
  [format] => linear,
  [angle] => 90,
  [colours] => Array (
    [colour1] => #cccccc,
    [colour2] => #fff
  ),
  [stops] => Array (
    [stop1] => 0,
    [stop2] => 100
  ),
  [gradient] => linear-gradient(90deg, #cccccc 0%, #fff 100%)
)
```

**WARNING**: This field won't work with the_field() as it is designed to return an array of data for a theme developer to use.


= Compatibility =

This ACF field type is compatible with:
* ACF 5

== Installation ==

1. Copy the `acf-css-gradient-picker` folder into your `wp-content/plugins` folder
2. Activate the acf-css-gradient-picker plugin via the plugins admin page
3. Create a new field via ACF and select the css-gradient-picker type
4. Read the description above for usage instructions

== Changelog ==

= 1.0.0 =
* Initial Release.
