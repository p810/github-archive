$(document).ready(function() {
  window.litlink = (function() {
    return {
      post : function() {
        var response = function(message, state) {
          $('#response').addClass('text-' + state).text(message);

          $('#response').fadeTo(200, 1);
        }

        $('#response').fadeTo(200, 0, function() {
          if($('#response').hasClass('text-danger')) {
            $('#response').removeClass('text-danger');
          }
          else if($('#response').hasClass('text-success')) {
            $('#response').removeClass('text-success');
          }
        });

        $.post('shorten', $('#url-form').serialize(), function(data, status) {
          console.log([data, status]);
        })
        .done(function(data) {
          $('#response').fadeTo(200, 0, function() {
            response('Your shortened URL is:' + ' ' + data.url, 'success');
          });
        })
        .fail(function(data) {
          $('#response').fadeTo(200, 0, function() {
            response('Failed to shorten your URL', 'danger');
          });
        });
      }
    }
  }());
});