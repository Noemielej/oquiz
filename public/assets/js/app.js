var app = {

  init: function() {
    console.log('init');

    // Interception du form de connexion
    $('#formSignin').on('submit', app.formSigninSubmit);

    // Interception du form du quizz
    $('#formQuizz').find('#buttonQuizz').on('submit', app.formQuizSubmit);

  },

  formSigninSubmit: function (evt) {
    // On empeche l'envoi du formulaire
    evt.preventDefault();
    console.log('formSigninSubmit');

    // On récupère les données du form
    var formData = $(this).serialize();
    console.log(formData);
    // On exécute l'appel Ajax
    // L'URL à appeler est stockée dans l'attribut "action" du formulaire
    $.ajax({
      url : $(this).attr('action'),
      //url: './ajax/signin',
      method : 'POST',
      dataType : 'json',
      data : formData
    }).done(function(response) {
      console.log(response);
      // Je stocke dans une variable la partie content pour ne pas faire pleins de recherches inutiles dans le DOM
      var $alertDiv = $('#alertSignin');
      var $content = $alertDiv.find('.content');

      // Si ok
      if (response.code == 1) {
        // J'ajoute la classe danger
        $alertDiv.removeClass('alert-danger').addClass('alert-success');
        // J'affiche le message de succès
        $content.html('Connexion réussie');
        // J'affiche la div
        $alertDiv.show();


        var urlToRedirect = response.redirect;
        console.log(urlToRedirect);

        // Je redirige après 2 secondes
        window.setTimeout(function() {
          location.href = urlToRedirect;
        }, 2000);
      }
      // Sinon, il y a des erreurs à afficher
      else {
        // J'ajoute la classe danger
        $alertDiv.addClass('alert-danger');
        // Je vide le contenu (anciennes erreurs)
        $content.html("");
        // Je parcours les erreurs retournées par l'appel Ajax
        $.each(response.errorList, function(index, value) {
          // Je crée un élément "div" avec du code html à l'intérieur
          var $currenterrorDiv = $('<div>', {
            html: value
          });
          // J'ajoute cet élément au DOM
          $content.append($currenterrorDiv);
        });
        // J'affiche la div
        $alertDiv.show();
      }

    }).fail(function() {
      alert('ajax failed');
    });

  },

  formQuizSubmit:function(evt) {
    // On empêche l'envoi du formulaire
    evt.preventDefault();
    console.log('formQuizSubmit');
  }
  // On récupère les données du form
  //var formQuizData = $(this).serialize();
  //console.log(formData);
  // On exécute l'appel Ajax
  // L'URL à appeler est stockée dans l'attribut "action" du formulaire
  // $.ajax({
  //   url : $(this).attr('action'),
  //   //url: './ajax/signin',
  //   method : 'GET',
  //   dataType : 'json',
  //   data : formQuizData
  // }).done(function(response) {
  //   console.log(response);
  //
  // }).fail(function() {
  //   alert('ajax failed');
  // });

};

$(app.init);
