<?php

/**
 * @file
 *
 * Theme functions for Raty module.
 */

/**
 * Wraps and returns the input widget with a Raty widget above it.
 *
 * @param array $variables
 *   The element details from hook_theme.
 */
function theme_raty_views_filter($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));
  _form_set_class($element, array('form-text'));

  $raty_class = $element['#views_filter_data']['identifier'];
  $label = $element['#views_filter_data']['title'];

  $output = '<div class="raty-input-wrapper">';
  if (!empty($label)) {
    $output .= '<label for="' . $element['#id'] . '">' . t($label) . '</label>';
  }

  $raty_element = '<div id="' . $raty_class . '" class="raty-star-widget" ';
  // @TODO: Move this into css.
  $raty_element .= 'style="float: left;" ';
  $raty_element .='data-score="' . $element['#value'] . '"></div>';

  $output .= $raty_element;
  $output .= '<input' . drupal_attributes($element['#attributes']) . ' />';
  $output .= '</div>';

  return $output;
}

/**
 * Wraps and returns the input widget with a Raty widget above it.
 *
 * @param array $variables
 *   The element details from hook_theme.
 */
function theme_raty_input_widget($variables) {
  $element = $variables['element'];
  $raty_class = 'raty-star-widget';
  $output = '<div class="raty-input-wrapper">';

  if (!empty($element['#title'])) {
    unset($variables['element']['#title']);
    // Put the label above the stars instead of field.
    $output = '<label for="' . $element['#id'] . '-value">';
    $output .= t($element['#title']) . '</label>';
  }

  $raty_element = '<div id="' . $element['#raty_id'] . '" class="raty-star-widget" ';
  // @TODO: Move this into css.
  $raty_element .= 'style="float: left;" ';
  $raty_element .='data-score="' . $element['#value'] . '"></div>';

  $output .= $raty_element;
  $output .= $element['#children'];
  $output .= '</div>';

  return $output;
}
