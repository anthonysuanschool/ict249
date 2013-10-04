/**
 * @file
 *
 * Drupal integration with the jQuery Raty library.
 *
 */

(function ($) {

  Drupal.behaviors.raty = {
    attach: function (context, settings) {
      $('.raty-star', context).once('raty-star', function(){

        $(this).raty({
          readOnly  : true,
          path      : '/' + Drupal.settings.raty.raty_path + '/img/',
          width     : 'auto',
          number    : function() {
            return $(this).attr('data-number');
          },
          score     : function() {
            return $(this).attr('data-score');
          }
        });

      });
    }
  };

})(jQuery);
