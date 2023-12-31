    var marker;

    function initMap() {
      var myLatLng = {lat: -34.92, lng: -58.48};

      var styleArray = [
        {
          featureType: "all",
          stylers: [
           { saturation: -80 }
          ]
        },{
          featureType: "road.arterial",
          elementType: "geometry",
          stylers: [
            { hue: "#000000" },
            { saturation: 50 }
          ]
        },{
          featureType: "poi.business",
          elementType: "labels",
          stylers: [
            { visibility: "off" }
          ]
        }
      ];

      var map = new google.maps.Map(document.getElementById('googleMap'), {
        center: myLatLng,
        scrollwheel: false,
     // Apply the map style array to the map.
        styles: styleArray,
        zoom: 10
      });
					
      var directionsDisplay = new google.maps.DirectionsRenderer({
          map: map
        });

        marker = new google.maps.Marker({
          map: map,
		  icon: 'images/map-marker.png',
		  draggable: true,
          animation: google.maps.Animation.DROP,
          position: myLatLng
        });
		marker.addListener('click', toggleBounce);

      }

      function toggleBounce() {
        if (marker.getAnimation() !== null) {
          marker.setAnimation(null);
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

