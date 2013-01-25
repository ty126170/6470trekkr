var map;
var infowindow;
var geocoder;

function place_submit(){
    var desiredLoc = document.getElementById('place').value;
    //alert(desiredLoc);
    
    geocoder.geocode({'address':desiredLoc}, function(results, status){
        if (status == google.maps.GeocoderStatus.OK) {
            
            map = new google.maps.Map(document.getElementById('map'), {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: results[0].geometry.location,
                zoom: 14
            });
            
            var request = {
              location: results[0].geometry.location,
              radius: 500,
              types: ['museum', 'park', 'aquarium', 'amusement_park', 'art_gallery']
            };
        
            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, callback);
        }
        else {
            alert("Geocode was not successful for the following reason: " + status);
        }
                    
    });
}

function initialize() {
    geocoder = new google.maps.Geocoder();
    var boston = new google.maps.LatLng(42.3583,-71.0603);
    
    map = new google.maps.Map(document.getElementById('map'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: boston,
        zoom: 14
    });
    
}

function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        document.getElementById('attractions').innerHTML = '<h2>Suggested Attractions</h2>'
        for (var i = 0; i < 6; i++) {
            createMarker(results[i]);
            var text = document.getElementById('attractions').innerHTML;
            document.getElementById('attractions').innerHTML = text + '<br>' + results[i].name;
        }
    }
}

function createMarker(place) {
    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
      map: map,
      position: placeLoc
    });

    google.maps.event.addListener(marker, 'click', function() {
      infowindow.setContent(place.name);
      infowindow.open(map, this);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);
