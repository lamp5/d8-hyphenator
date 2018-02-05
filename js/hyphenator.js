(function($, Drupal){

  Drupal.behaviors.hyphenator = {
    attach: function(context, settings){
      Hyphenator.config(settings.hyphenator);

      if($('.' + settings.hyphenator.classname).length > $('.hyphenator-init').length){
        $('.' + settings.hyphenator.classname).addClass('hyphenator-init');
        console.debug('Hyphenator run');
        Hyphenator.run();
      }
    }
  };

})(jQuery, Drupal);
