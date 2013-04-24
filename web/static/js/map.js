/**
 * map.js
 * FR : ce script gère le dialogue entre le formulaire de création de
 * dinner et l'api map ( Bing Maps).
 * Lorsque certains champs sont modifiés , la carte se recharge et pointe vers le
 * lieu correspondant ( adresse , ville , pays )
 *
 */
 $(function() {
    var map,center,pin,infoBox,infoBoxOptions;
    var jQmap = $('#theMap');
    var $addressInput = $("#dinner_address");
    var $titleInput = $('#dinner_title');
    var $descriptionInput = $('#dinner_description');
    var $cityInput = $("#dinner_city");
    var $countrySelect = $('#dinner_country');
    var $latitudeInput = $("#dinner_latitude");
    var $longitudeInput = $("#dinner_longitude");
    jQmap.on("load",function(){alert('loaded')});
    var pinOptions = {
        //text: "this is the center of the map",
       //offset:new Microsoft.Maps.Point(0,-10) ,
        icon:"/static/img/restaurant-icon-optimized.png",
        width:33,height:33
    };
    var mapOptions = {
        credentials: "AiXhX2mvYB4p1IKybImtVSgvp3ZMVh42GxPVLyHaN9RCWl9mq0GvMCCsA7sz_LKE",
        mapTypeId: Microsoft.Maps.MapTypeId.road,
        scriptload:"window.mapLoaded",
        center: new Microsoft.Maps.Location(jQmap.attr("data-latitude") || 0, jQmap.attr("data-longitude") || 0),
        zoom: 12

    };
    infoBoxOptions = {
       // showPointer:false,
       visible:false,
       showCloseButton:false,
       offset:new Microsoft.Maps.Point(0,20) ,
       title:jQmap.attr("data-title")||'no title',
       description:jQmap.attr("data-description")||'no description'
   }
   /** on ajax request reponse **/
   var onLocationFound = function(data) {
    console.log(data);
    var bbox = data.resourceSets[0].resources[0].bbox;
    var viewBoundaries = Microsoft.Maps.LocationRect.fromLocations(new Microsoft.Maps.Location(bbox[0], bbox[1]), new Microsoft.Maps.Location(bbox[2], bbox[3]));
    map.setView({
        bounds: viewBoundaries
    });
        // add pushpin
        // Add a pushpin at the found location
        var location = new Microsoft.Maps.Location(data.resourceSets[0].resources[0].point.coordinates[0], data.resourceSets[0].resources[0].point.coordinates[1]);
        pin.setLocation(location);
        infoBox.setLocation(location);
        infoBox.setOptions({title:$titleInput.val(),description:$descriptionInput.val()})
        // map.entities.push(pushpin);
        $latitudeInput.val(location.latitude);
        $longitudeInput.val(location.longitude);
    };
    /**
     * EVENTS
     */
     var pinMouseOver= function(t){
        infoBox.setOptions({visible:true});
    }
    var pinMouseOut = function(){
        infoBox.setOptions({visible:false});
    }
    /** on form change **/
    var onViewUpdate = function(event) {
        var t = event.currentTarget;
        //  var geocodeRequest = "http://dev.virtualearth.net/REST/v1/Locations?query="
        var geocodeRequest = "http://dev.virtualearth.net/REST/v1/Locations?" +
        "&addressLine=" + encodeURI($addressInput.val()) +
        "&locality=" + encodeURI($cityInput.val()) +
        "&countryRegion=" + $countrySelect.val() +
        "&output=json&key=" + mapOptions.credentials +
        "&jsonp=?";
        $.getJSON(geocodeRequest, onLocationFound);
    };
    function init(){
        $addressInput.on("blur", onViewUpdate);
        $cityInput.on("blur", onViewUpdate);
        $countrySelect.on("change", onViewUpdate);
        map = new Microsoft.Maps.Map(jQmap.get(0), mapOptions);
        // centre de la map
        center = map.getCenter();
        // créer un pin
        pin = new Microsoft.Maps.Pushpin(center, pinOptions);
        infoBox = new Microsoft.Maps.Infobox(center,infoBoxOptions);
        //infoBox.hide();
        Microsoft.Maps.Events.addHandler(pin,"mouseover",pinMouseOver)
        Microsoft.Maps.Events.addHandler(pin,"mouseout",pinMouseOut)
        // ajouter un pin à la map
        map.entities.push(pin);
        map.entities.push(infoBox);
    }

    init();

});