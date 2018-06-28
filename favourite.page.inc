<?php

/**
 * @file
 * Contains favourite.page.inc.
 *
 * Page callback for Favourite entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Favourite templates.
 *
 * Default template: favourite.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_favourite(array &$variables) {
  // Fetch Favourite Entity Object.
  $favourite = $variables['elements']['#favourite'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
