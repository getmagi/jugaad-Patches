/**
 * @file
 * Patches behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.patches = {
    attach: function (context, settings) {

      console.log('It works!');

    }
  };

} (Drupal));
