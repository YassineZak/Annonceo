$("#modif").click(function() {
  $('#modificationProfil').css('display', 'block');
  $('#connexionOverlay').css('display', 'block');
});
$(".btn-primary").click(function() {
  $('#modificationProfil').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
$("#connexionOverlay").click(function() {
  $('#modificationProfil').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
/************* pop up formulaire de contact ***********/
$("#contact").click(function() {
  $('#contactForm').css('display', 'block');
  $('#connexionOverlay').css('display', 'block');
});
$(".btn-primary").click(function() {
  $('#contactForm').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
$("#connexionOverlay").click(function() {
  $('#contactForm').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
/******** popup connexion ************/
$(".membre").click(function() {
  $('#connexion').css('display', 'block');
  $('#connexionOverlay').css('display', 'block');
});
$("#connexionOverlay").click(function() {
  $('#connexion').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
$(".btn-primary").click(function() {
  $('#connexion').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
/************** popup inscription *************/
$(".inscription").click(function() {
  $('#inscription').css('display', 'block');
  $('#connexionOverlay').css('display', 'block');
});
$("#connexionOverlay").click(function() {
  $('#inscription').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
/*************** deposer annonce ***********/
$(".deposer-annonce").click(function() {
  $('#depotAnnonce').css('display', 'block');
  $('#connexionOverlay').css('display', 'block');
});
$("#connexionOverlay").click(function() {
  $('#depotAnnonce').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
$(".btn-primary").click(function() {
  $('#depotAnnonce').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
/************ deposer annonce non connecté ***************/
$(".deposer-annonce").click(function() {
  $('#depotAnnonceNonconnecte').css('display', 'block');
  $('#connexionOverlay').css('display', 'block');
});
$("#connexionOverlay").click(function() {
  $('#depotAnnonceNonconnecte').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
$(".close").click(function() {
  $('#depotAnnonceNonconnecte').css('display', 'none');
  $('#connexionOverlay').css('display', 'none');
});
/*************  api google autocomplete ******************/
// Lie le champs adresse en champs autocomplete afin que l'API puisse afficher les propositions d'adresses
function initializeAutocomplete(id) {
  var element = document.getElementById(id);
  if (element) {
   var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
   google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
  }
}

// Injecte les données dans les champs du formulaire lorsqu'une adresse est sélectionnée
function onPlaceChanged() {
  var place = this.getPlace();

  for (var i in place.address_components) {
    var component = place.address_components[i];
    for (var j in component.types) {
      var type_element = document.getElementById(component.types[j]);
      if (type_element) {
        type_element.value = component.long_name;
      }
    }
  }

  var longitude = document.getElementById("longitude");
  var latitude = document.getElementById("latitude");
  longitude.value = place.geometry.location.lng();
  latitude.value = place.geometry.location.lat();
}

// Initialisation du champs autocomplete
google.maps.event.addDomListener(window, 'load', function() {
  initializeAutocomplete('user_input_autocomplete_address');
});
google.maps.event.addDomListener(window, 'load', function() {
  initializeAutocomplete('user_input_autocomplete_address1');
});



///////////////////////////// modal erreur formulaire ///////////////////
$(".close").click(function() {
  $('.alert').fadeOut();
});
///////////////////////// google map /////////////////////////
(function( $ ) {
  var createMap = function( coords, zoom ) {
    var coordsParts = coords.split( "," );
    if( typeof google !== "undefined" ) {
      var options = {
        zoom: zoom,
        center: new google.maps.LatLng( coordsParts[0], coordsParts[1] ),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };

      var map = new google.maps.Map( document.getElementById( "map" ), options );

      var marker = new google.maps.Marker({
        position: new google.maps.LatLng( coordsParts[0], coordsParts[1] ),
        map: map
      });

    }

  };

  $(function() {
    $( "li", "#places" ).on( "click", function() {
      var $li = $( this );
      $li.addClass( "selected" ).siblings().removeClass( "selected" );
      createMap( $li.data( "coords" ), $li.data( "zoom" ) );
    });
    $( "li", "#places" ).eq( 0 ).trigger( "click" );
  });
})( jQuery );
//////////////// autocompletion //////////////////
$( function() {
    $( "#recherche" ).autocomplete({
      source: 'liste.php'
    });
});
/////////////// google Analytics ///////////////
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-112435852-1');
////////////////////// voir plus ///////////////////////////

$('#plus').click(function (){
  if (document.querySelector('.hide')) {
    $("div.annonceShow div.hide:first, div.annonceShow div.hide:eq( 1 ), div.annonceShow div.hide:eq( 2 )").attr('class', 'open');
  }
  else {
    document.getElementById('plus').style.display = 'none';
  }
});
if (!document.querySelector('.hide')) {
  document.getElementById('plus').style.display = 'none';
}
///////////////// image modifier à l'upload ////////////////

document.querySelector('#file-input1').addEventListener('change', function() {
    $('#image1').attr('src', './img/addpic_checked.png');
});
document.querySelector('#file-input2').addEventListener('change', function() {
    $('#image2').attr('src', './img/addpic_checked.png');
});
document.querySelector('#file-input3').addEventListener('change', function() {
    $('#image3').attr('src', './img/addpic_checked.png');
});
document.querySelector('#file-input4').addEventListener('change', function() {
    $('#image4').attr('src', './img/addpic_checked.png');
});
document.querySelector('#file-input5').addEventListener('change', function() {
    $('#image5').attr('src', './img/addpic_checked.png');
});
