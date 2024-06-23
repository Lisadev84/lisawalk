
document.addEventListener("DOMContentLoaded", function () {

  // Récupére tous les éléments contenant une carte
  let mapElements = document.querySelectorAll('.map');

 
  // Itére sur chaque élément et initialise la carte correspondante
  for (let i = 0; i < mapElements.length; i++) {
    let mapElement = mapElements[i];
    let traceId = mapElement.getAttribute('id');

    // Initialise la carte avec Leaflet
    let map = L.map(mapElement).setView([44.0565054, 5.1432068], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


    // Ajoute la trace GPX à la carte
    new L.GPX('/mymaps/' + traceId + '.gpx', {
      async: true,
      marker_options: {
        startIconUrl: '../images/pin-icon-start.png',
        endIconUrl: '../images/pin-icon-end.png',
        shadowUrl: '../images/pin-shadow.png'
      }
    }).on('loaded', function (e) {
     
       // Récupére les limites (bounds) du tracé GPX et définit le centre et le zoom de la carte en fonction des limites du tracé GPX

      map.fitBounds(e.target.getBounds());
    }).addTo(map);

  }

  
  /**
  * Limiting the number of characters in textarea
  * keybordEvent
  */
  function textLimit(elt, maxlen) {
   
    if (elt.value.length > maxlen) {
      elt.value = elt.value.substring(0, maxlen);
      alert("votre message est trop long");
    }  
   
  };

  
});  
