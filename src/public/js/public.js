//jquery stuff
(function ($) {
  var $ = jQuery.noConflict();
  $(document).ready(function($) {

    const matchunter_api = JSON.parse(matchunter.api);

    $('.matchunter-container').each( function(){
      const thisWidget = $(this);

      $.ajax({
        url: `${matchunter_api.root}/views/round/matches/1/1`,
        type: 'GET',
        contentType: 'application/json',
        headers: {
          Authorization: `Bearer ${matchunter.token}`
        },
        success: function(response) {
          thisWidget.html(response).addClass('is-ready');
        },
        error: function (error) {

        }
      });
    });

  });
})(jQuery);
