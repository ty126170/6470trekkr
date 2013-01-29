var map;
var infowindow;
var geocoder;
var directionsService;
var directionsDisplay;
var trekStops = [];
var suggestedStops = [];
var startIndex;
var startList;
var endIndex;
var endList;
        


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
            
            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(document.getElementById('direction_box'));
            
            var request = {
              location: results[0].geometry.location,
              radius: 800,
              types: ['museum', 'park', 'aquarium', 'amusement_park', 'art_gallery', 'cafe', 'cemetery', 'bakery', 'zoo' ]
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
    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: false,
        draggable: false
    });
    
    var boston = new google.maps.LatLng(42.3583,-71.0603);
    
    map = new google.maps.Map(document.getElementById('map'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: boston,
        zoom: 14
    });
    
}

function view_directions(){
    $("#attractions_box").hide();
    $(".attraction_suggested").hide();
    $("#directions_box").show();
}

function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        
        $("#trip").html('');
        $("#attractions").html('');
        trekStops = [];
        suggestedStops = [];
        
        //Suggest Top 6 Attractions as Trek Stops
        for (var i = 0; i < 3; i++) {
            //createMarker(results[i]);
            var newAttr = $("<div>").addClass("attraction_trip");
            var attrIcon = $("<img>").addClass("attraction_icon_home");
            var attrName = $("<div>").addClass("attraction_name").html(results[i].name);
            attrIcon.attr("src", results[i].icon);
            newAttr.append(attrIcon);
            newAttr.append(attrName);
            $("#trip").append(newAttr);
            trekStops.push(results[i]);
        }
        
        //Put rest of attractions in Suggested Stops
        for (var j = 4; j < results.length; j++) {
            var newAttr = $("<div>").addClass("attraction_suggested");
            var attrIcon = $("<img>").addClass("attraction_icon_home");
            var attrName = $("<div>").addClass("attraction_name").html(results[j].name);
            attrIcon.attr("src", results[j].icon);
            newAttr.append(attrIcon);
            newAttr.append(attrName);
            $("#attractions").append(newAttr);
            suggestedStops.push(results[j]);
        }
        
        
        //Add and remove stops on click and replan route
        //$(".attraction_trip").click(function(event){
        //   var attrIndex = $(this).parent().children().index(this);
        //    console.log($(this).attr("class"));
        //    if ($(this).attr("class") === "attraction_trip"){
        //        $("#attractions").append(this);
        //        var attr = trekStops.splice(attrIndex,1);
        //        suggestedStops.push(attr[0]);
        //    }
        //    else {
        //        $("#trip").append(this);
        //        var attr = suggestedStops.splice(attrIndex,1);
        //        trekStops.push(attr[0]);
        //    }
        //    $(this).addClass("attraction_suggested");
        //    $(this).removeClass("attraction_trip");
        //    
        //    getDirections(trekStops, false);
        //});
        
        //$(".attraction_suggested").click(function(event){
        //    var attrIndex = $(this).parent().children().index(this);
        //    console.log($(this).attr("class"));
        //    if ($(this).attr("class") === "attraction_trip"){
        //        $("#attractions").append(this);               
        //        var attr = trekStops.splice(attrIndex,1);
        //        suggestedStops.push(attr[0]);
        //    }
        //    else {
        //        $("#trip").append(this);
        //        var attr = suggestedStops.splice(attrIndex,1);
        //        trekStops.push(attr[0]);
        //    }
        //    $(this).addClass("attraction_trip");
        //    $(this).removeClass("attraction_suggested");

        //    getDirections(trekStops, false);
        //});


        $("#trip, #attractions").sortable({
            start: function(event, ui){
                startIndex = $(ui.item).parent().children().index(ui.item);
                console.log(startIndex);
                startList = $(ui.item).parent().attr("id");
                console.log(startList);
            },
        	connectWith: ".sortableList",
            receive: function(event, ui){
                if (trekStops.length > 9 && startList == "attractions"){
                    $(ui.sender).sortable('cancel');
                    alert("Sorry, you can only have a maximum of 10 Trek Stops");
                }  
            },
            stop: function(event, ui){
                
                endIndex = $(ui.item).parent().children().index(ui.item);
                console.log(endIndex);
                endList = $(ui.item).parent().attr("id");
                console.log(endList);
                
                if (startList !== endList){
                    if (startList === "trip") {
                        var attr = trekStops.splice(startIndex,1);
                        suggestedStops.splice(endIndex,0,attr[0]);
                        $(ui.item).addClass("attraction_suggested");
                        $(ui.item).removeClass("attraction_trip");  

                    }
                    else {
                        var attr = suggestedStops.splice(startIndex,1);
                        trekStops.splice(endIndex,0,attr[0]);
                        $(ui.item).addClass("attraction_trip");
                        $(ui.item).removeClass("attraction_suggested");
                    }
                }
                else {
                    if (startList === 'trip') {
                        console.log("SORTING TRIP");
                        var attr = trekStops.splice(startIndex,1);
                        trekStops.splice(endIndex,0,attr[0]);
                    }
                }
                
                getDirections(trekStops, false);
            }
		}).disableSelection();
        
        
        //Map Route Directions
        getDirections(trekStops, false);
    }
}

function getDirections(results, optimize){

    var waypts = [];
    
    for (var k = 1; k < results.length-1; k++){
        waypts.push({
           location: results[k].geometry.location,
           stopover: true
        });
    }

    var request = {
        origin: results[0].geometry.location,
        destination: results[results.length-1].geometry.location,
        travelMode: google.maps.TravelMode.WALKING,
        waypoints: waypts,
        optimizeWaypoints: optimize
    };
        
    directionsService.route(request, function(response, status){
        if (status == google.maps.DirectionsStatus.OK){
            
            directionsDisplay.setDirections(response);
            
            if (optimize === true) {
                $("#trip").html('');
                var temp = [];
                $("#trip").append('<div class="attraction_trip">' + results[0].name + '</div>');
                for (var i = 0; i < response.routes[0].waypoint_order.length; i++) {
                    $("#trip").append('<div class="attraction_trip">' + results[response.routes[0].waypoint_order[i] + 1].name + '</div>');
                    temp.push(results[response.routes[0].waypoint_order[i] + 1]);
                }
                $("#trip").append('<div class="attraction_trip">' + results[results.length-1].name + '</div>');
                trekStops = temp;                
            }

        }
        else {
            alert("Direction Service was not successful for the following reason: " + status);
        }
    });
}

function createMarker(place) {
    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
      map: map,
      position: placeLoc
    });

    google.maps.event.addListener(marker, 'mouseover', function() {
      infowindow.setContent(place.name);
      infowindow.open(map, this);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);