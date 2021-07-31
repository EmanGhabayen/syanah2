/**
 * Holds google map object and related utility entities.
 * @constructor
 */

//Init Map
jQuery.listingo_init_map = function (map_lat, map_lng) {

    var mapwrapper = jQuery('#location-pickr-map');

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        var dir_latitude = scripts_vars.dir_latitude;
        var dir_longitude = scripts_vars.dir_longitude;
        var dir_map_type = scripts_vars.dir_map_type;
        var dir_close_marker = scripts_vars.dir_close_marker;
        var dir_cluster_marker = scripts_vars.dir_cluster_marker;
        var dir_map_marker = scripts_vars.dir_map_marker;
        var dir_cluster_color = scripts_vars.dir_cluster_color;
        var dir_zoom = scripts_vars.dir_zoom;
        var dir_map_scroll = scripts_vars.dir_map_scroll;
    } else {
        var dir_latitude = 51.5001524;
        var dir_longitude = -0.1262362;
        var dir_map_type = 'ROADMAP';
        var dir_zoom = 12;
        var dir_map_scroll = false;
    }

    if (dir_map_type == 'ROADMAP') {
        var map_id = google.maps.MapTypeId.ROADMAP;
    } else if (dir_map_type == 'SATELLITE') {
        var map_id = google.maps.MapTypeId.SATELLITE;
    } else if (dir_map_type == 'HYBRID') {
        var map_id = google.maps.MapTypeId.HYBRID;
    } else if (dir_map_type == 'TERRAIN') {
        var map_id = google.maps.MapTypeId.TERRAIN;
    } else {
        var map_id = google.maps.MapTypeId.ROADMAP;
    }

    var scrollwheel = true;

    if (dir_map_scroll == 'false') {
        scrollwheel = false;
    }

    mapwrapper.gmap3({
        map: {
            options: {
                panControl: false,
                scaleControl: false,
                navigationControl: false,
                draggable: true,
                scrollwheel: scrollwheel,
                streetViewControl: false,
                center: [map_lat, map_lng],
                zoom: parseInt(dir_zoom),
                mapTypeId: map_id,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
            },
            callback: function () {
                setTimeout(function () {
                    jQuery.listingo_map_fallback();
                }, 100);
            }
        },
        marker: {
            values: [{
                    latLng: [map_lat, map_lng],
                }],
            options: {
                draggable: true
            },
            events: {
                dragend: function (marker) {
                    jQuery('#location-latitude').val(marker.getPosition().lat());
                    jQuery('#location-longitude').val(marker.getPosition().lng());
                },
            },
        }

    });
};
//Call To Add Map
jQuery.listingo_map_fallback = function () {
    var map_div = jQuery('#location-pickr-map').gmap3("get");
    var map_input = document.getElementById("location-address");
    jQuery("#location-address").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        if (scripts_vars.country_restrict !== '') {
            var options = {
                componentRestrictions: {country: scripts_vars.country_restrict}
            };

            var autocomplete = new google.maps.places.Autocomplete(map_input, options);
        } else {

            var autocomplete = new google.maps.places.Autocomplete(map_input);
        }
    } else {
        var autocomplete = new google.maps.places.Autocomplete(map_input);
    }

    autocomplete.bindTo("bounds", map_div);

    google.maps.event.addListener(autocomplete, "place_changed", function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map_div.fitBounds(place.geometry.viewport);
        } else {
            map_div.setCenter(place.geometry.location);
            //map_div.setZoom(11);
        }

        var marker = jQuery('#location-pickr-map').gmap3({get: "marker"});
        marker.setPosition(place.geometry.location);
		
		listingo_fetch_selected_location(place);
		
        jQuery("#location-latitude").val(marker.getPosition().lat());
        jQuery("#location-longitude").val(marker.getPosition().lng());
    });

}


//Init header top Map
jQuery.listingo_init_ads_map = function (map_lat, map_lng) {

    var mapwrapper = jQuery('#location-pickr-map-ads');

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        var dir_latitude = scripts_vars.dir_latitude;
        var dir_longitude = scripts_vars.dir_longitude;
        var dir_map_type = scripts_vars.dir_map_type;
        var dir_close_marker = scripts_vars.dir_close_marker;
        var dir_cluster_marker = scripts_vars.dir_cluster_marker;
        var dir_map_marker = scripts_vars.dir_map_marker;
        var dir_cluster_color = scripts_vars.dir_cluster_color;
        var dir_zoom = scripts_vars.dir_zoom;
        var dir_map_scroll = scripts_vars.dir_map_scroll;
    } else {
        var dir_latitude = 51.5001524;
        var dir_longitude = -0.1262362;
        var dir_map_type = 'ROADMAP';
        var dir_zoom = 12;
        var dir_map_scroll = false;
    }

    if (dir_map_type == 'ROADMAP') {
        var map_id = google.maps.MapTypeId.ROADMAP;
    } else if (dir_map_type == 'SATELLITE') {
        var map_id = google.maps.MapTypeId.SATELLITE;
    } else if (dir_map_type == 'HYBRID') {
        var map_id = google.maps.MapTypeId.HYBRID;
    } else if (dir_map_type == 'TERRAIN') {
        var map_id = google.maps.MapTypeId.TERRAIN;
    } else {
        var map_id = google.maps.MapTypeId.ROADMAP;
    }

    var scrollwheel = true;

    if (dir_map_scroll == 'false') {
        scrollwheel = false;
    }

    mapwrapper.gmap3({
        map: {
            options: {
                panControl: false,
                scaleControl: false,
                navigationControl: false,
                draggable: true,
                scrollwheel: scrollwheel,
                streetViewControl: false,
                center: [map_lat, map_lng],
                zoom: parseInt(dir_zoom),
                mapTypeId: map_id,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
            },
            callback: function () {
                setTimeout(function () {
                    jQuery.listingo_map_ads_fallback();
                }, 100);
            }
        },
        marker: {
            values: [{
                    latLng: [map_lat, map_lng],
                }],
            options: {
                draggable: true
            },
            events: {
                dragend: function (marker) {
                    jQuery('#location-latitude-ads').val(marker.getPosition().lat());
                    jQuery('#location-longitude-ads').val(marker.getPosition().lng());
                },
            },
        }

    });
};
//Call To Add Map
jQuery.listingo_map_ads_fallback = function () {
    var map_div = jQuery('#location-pickr-map-ads').gmap3("get");
    var map_input = document.getElementById("location-address-ads");
    jQuery("#location-address-ads").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        if (scripts_vars.country_restrict !== '') {
            var options = {
                componentRestrictions: {country: scripts_vars.country_restrict}
            };

            var autocomplete = new google.maps.places.Autocomplete(map_input, options);
        } else {

            var autocomplete = new google.maps.places.Autocomplete(map_input);
        }
    } else {
        var autocomplete = new google.maps.places.Autocomplete(map_input);
    }

    autocomplete.bindTo("bounds", map_div);

    google.maps.event.addListener(autocomplete, "place_changed", function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map_div.fitBounds(place.geometry.viewport);
        } else {
            map_div.setCenter(place.geometry.location);
            //map_div.setZoom(11);
        }

        var marker = jQuery('#location-pickr-map-ads').gmap3({get: "marker"});
        marker.setPosition(place.geometry.location);

		listingo_fetch_selected_location(place);
										
        jQuery("#location-latitude-ads").val(marker.getPosition().lat());
        jQuery("#location-longitude-ads").val(marker.getPosition().lng());
    });

}

//Init header top Map
jQuery.listingo_init_header_map = function (map_lat, map_lng) {

    var mapwrapper = jQuery('#location-pickr-map-header');

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        var dir_latitude = scripts_vars.dir_latitude;
        var dir_longitude = scripts_vars.dir_longitude;
        var dir_map_type = scripts_vars.dir_map_type;
        var dir_close_marker = scripts_vars.dir_close_marker;
        var dir_cluster_marker = scripts_vars.dir_cluster_marker;
        var dir_map_marker = scripts_vars.dir_map_marker;
        var dir_cluster_color = scripts_vars.dir_cluster_color;
        var dir_zoom = scripts_vars.dir_zoom;
        var dir_map_scroll = scripts_vars.dir_map_scroll;
    } else {
        var dir_latitude = 51.5001524;
        var dir_longitude = -0.1262362;
        var dir_map_type = 'ROADMAP';
        var dir_zoom = 12;
        var dir_map_scroll = false;
    }

    if (dir_map_type == 'ROADMAP') {
        var map_id = google.maps.MapTypeId.ROADMAP;
    } else if (dir_map_type == 'SATELLITE') {
        var map_id = google.maps.MapTypeId.SATELLITE;
    } else if (dir_map_type == 'HYBRID') {
        var map_id = google.maps.MapTypeId.HYBRID;
    } else if (dir_map_type == 'TERRAIN') {
        var map_id = google.maps.MapTypeId.TERRAIN;
    } else {
        var map_id = google.maps.MapTypeId.ROADMAP;
    }

    var scrollwheel = true;

    if (dir_map_scroll == 'false') {
        scrollwheel = false;
    }

    mapwrapper.gmap3({
        map: {
            options: {
                panControl: false,
                scaleControl: false,
                navigationControl: false,
                draggable: true,
                scrollwheel: scrollwheel,
                streetViewControl: false,
                center: [map_lat, map_lng],
                zoom: parseInt(dir_zoom),
                mapTypeId: map_id,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
            },
            callback: function () {
                setTimeout(function () {
                    jQuery.listingo_map_header_fallback();
                }, 100);
            }
        },
        marker: {
            values: [{
                    latLng: [map_lat, map_lng],
                }],
            options: {
                draggable: true
            },
            events: {
                dragend: function (marker) {
                    jQuery('#location-latitude-header').val(marker.getPosition().lat());
                    jQuery('#location-longitude-header').val(marker.getPosition().lng());
                },
            },
        }

    });
};
//Call To Add Map
jQuery.listingo_map_header_fallback = function () {
    var map_div = jQuery('#location-pickr-map-header').gmap3("get");
    var map_input = document.getElementById("location-address-header");
    jQuery("#location-address-header").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        if (scripts_vars.country_restrict !== '') {
            var options = {
                componentRestrictions: {country: scripts_vars.country_restrict}
            };

            var autocomplete = new google.maps.places.Autocomplete(map_input, options);
        } else {

            var autocomplete = new google.maps.places.Autocomplete(map_input);
        }
    } else {
        var autocomplete = new google.maps.places.Autocomplete(map_input);
    }

    autocomplete.bindTo("bounds", map_div);

    google.maps.event.addListener(autocomplete, "place_changed", function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map_div.fitBounds(place.geometry.viewport);
        } else {
            map_div.setCenter(place.geometry.location);
            //map_div.setZoom(11);
        }

        var marker = jQuery('#location-pickr-map-header').gmap3({get: "marker"});
        marker.setPosition(place.geometry.location);

		listingo_fetch_selected_location(place);
										
        jQuery("#location-latitude-header").val(marker.getPosition().lat());
        jQuery("#location-longitude-header").val(marker.getPosition().lng());
    });

}

/*********************************************
 * Geo Locate Map
 *******************************************/
jQuery(document).ready(function (e) {

    //Geo Locate
    jQuery(document).on("click", ".geolocate-header", function () {
		var _this	= jQuery(this);
		var _isfetch	= _this.data('key');
        jQuery('#location-pickr-map-header').gmap3({
            getgeoloc: {
                callback: function (latLng) {
                    if (latLng) {
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({"latLng": latLng}, function (data, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (data[0]) {
                                    jQuery('#location-pickr-map-header').gmap3({
                                        marker: {
                                            latLng: latLng
                                        },
                                        map: {
                                            options: {
                                                zoom: 11
                                            }
                                        }
                                    });
									
									if( _isfetch != null && _isfetch === 'fetch' ){
										var place = data[0];
										listingo_fetch_user_location(place);
									}
									
									listingo_fetch_selected_location(data[0]);
                                    jQuery("#location-address-header").val(data[0].formatted_address);
                                    jQuery("#location-latitude-header").val(latLng.lat());
                                    jQuery("#location-longitude-header").val(latLng.lng());
                                }
                            }
                        });
                    }
                }
            }
        });
        return false;
    });
});

//Init profile Map
jQuery.listingo_init_profile_map = function (field_key,id,map_lat, map_lng) {

    var mapwrapper = jQuery('#'+id);

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        var dir_latitude = scripts_vars.dir_latitude;
        var dir_longitude = scripts_vars.dir_longitude;
        var dir_map_type = scripts_vars.dir_map_type;
        var dir_close_marker = scripts_vars.dir_close_marker;
        var dir_cluster_marker = scripts_vars.dir_cluster_marker;
        var dir_map_marker = scripts_vars.dir_map_marker;
        var dir_cluster_color = scripts_vars.dir_cluster_color;
        var dir_zoom = scripts_vars.dir_zoom;
        var dir_map_scroll = scripts_vars.dir_map_scroll;
    } else {
        var dir_latitude = 51.5001524;
        var dir_longitude = -0.1262362;
        var dir_map_type = 'ROADMAP';
        var dir_zoom = 12;
        var dir_map_scroll = false;
    }
	
	if( map_lat && map_lng ){
		map_lat	= map_lat;
		map_lng	= map_lng;
	} else{
		map_lat	= dir_latitude;
		map_lng	= dir_longitude;
	}

    if (dir_map_type == 'ROADMAP') {
        var map_id = google.maps.MapTypeId.ROADMAP;
    } else if (dir_map_type == 'SATELLITE') {
        var map_id = google.maps.MapTypeId.SATELLITE;
    } else if (dir_map_type == 'HYBRID') {
        var map_id = google.maps.MapTypeId.HYBRID;
    } else if (dir_map_type == 'TERRAIN') {
        var map_id = google.maps.MapTypeId.TERRAIN;
    } else {
        var map_id = google.maps.MapTypeId.ROADMAP;
    }

    var scrollwheel = true;

    if (dir_map_scroll == 'false') {
        scrollwheel = false;
    }

    mapwrapper.gmap3({
        map: {
            options: {
                panControl: true,
                scaleControl: true,
                navigationControl: true,
                draggable: true,
                scrollwheel: scrollwheel,
                streetViewControl: true,
                center: [map_lat, map_lng],
                zoom: parseInt(dir_zoom),
                mapTypeId: map_id,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
            },
            callback: function () {
                setTimeout(function () {
                    jQuery.listingo_profile_map_fallback(id,field_key);
                }, 300);
            }
        },
        marker: {
            values: [{
                    latLng: [map_lat, map_lng],
                }],
            options: {
                draggable: true
            },
            events: {
                dragend: function (marker) {
					console.log(marker.getPosition().formatted_address);
                    jQuery('#location-latitude-'+field_key).val(marker.getPosition().lat());
                    jQuery('#location-longitude-'+field_key).val(marker.getPosition().lng());
                },
            },
        }

    });
};

//Call To Add Map
jQuery.listingo_profile_map_fallback = function (id,field_key) {
    var map_div = jQuery('#'+id).gmap3("get");
    var map_input = document.getElementById("location-address-"+field_key);
    jQuery("#location-address-"+field_key).bind("keypress", function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    if (typeof (scripts_vars) != "undefined" && scripts_vars !== null) {
        if (scripts_vars.country_restrict !== '') {
            var options = {
                componentRestrictions: {country: scripts_vars.country_restrict}
            };

            var autocomplete = new google.maps.places.Autocomplete(map_input, options);
        } else {

            var autocomplete = new google.maps.places.Autocomplete(map_input);
        }
    } else {
        var autocomplete = new google.maps.places.Autocomplete(map_input);
    }

    autocomplete.bindTo("bounds", map_div);

    google.maps.event.addListener(autocomplete, "place_changed", function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map_div.fitBounds(place.geometry.viewport);
        } else {
            map_div.setCenter(place.geometry.location);
            //map_div.setZoom(11);
        }

		listingo_fetch_user_location(place); //fetch location
		listingo_fetch_selected_location(place);
		
        var marker = jQuery('#'+id).gmap3({get: "marker"});
        marker.setPosition(place.geometry.location);
        jQuery("#location-latitude-"+field_key).val(marker.getPosition().lat());
        jQuery("#location-longitude-"+field_key).val(marker.getPosition().lng());
    });

}

/*********************************************
 * Geo Locate Map
 *******************************************/
jQuery(document).ready(function (e) {

    //Geo Locate
    jQuery(document).on("click", ".geolocate", function () {
		var _this	= jQuery(this);
		var _isfetch	= _this.data('key');
        jQuery('#location-pickr-map').gmap3({
            getgeoloc: {
                callback: function (latLng) {
                    if (latLng) {
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({"latLng": latLng}, function (data, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (data[0]) {
                                    jQuery('#location-pickr-map').gmap3({
                                        marker: {
                                            latLng: latLng
                                        },
                                        map: {
                                            options: {
                                                zoom: 11
                                            }
                                        }
                                    });
									
									if( _isfetch != null && _isfetch === 'fetch' ){
										var place = data[0];
										listingo_fetch_user_location(place);
										listingo_fetch_selected_location(place);
									}

                                    jQuery("#location-address").val(data[0].formatted_address);
                                    jQuery("#location-latitude").val(latLng.lat());
                                    jQuery("#location-longitude").val(latLng.lng());
                                }
                            }
                        });
                    }
                }
            }
        });
        return false;
    });
});

//Fetch country and city from locations and save it
function listingo_fetch_user_location(data){
	var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
	var place = data;
	var componentForm = {
	  locality: 'long_name',
	  administrative_area_level_1: 'short_name',
	  country: 'long_name',
	  postal_town: 'short_name',
	};
	
	for (var component in componentForm) {
		document.getElementById(component).value = '';
	}
	
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];

		if (componentForm[addressType]) {
		  var val = place.address_components[i][componentForm[addressType]];
		  document.getElementById(addressType).value = val;
		}
		// for the country, get the country code (the "short name") also
		if (addressType == "country") {
		  document.getElementById("country_code").value = place.address_components[i].short_name;
		}
	}

	var obj = {};
	jQuery(".sp-data-location input[type=hidden]").each(function() {
		var _this	= jQuery(this);
		var _key	= _this.data('key');
		obj[_key] = _this.val();
	});

	if(obj && !jQuery.isEmptyObject(obj)){
		var serialize_data = obj;
		
		var json = JSON.stringify(obj);
		jQuery('body').append(loader_html);
		var dataString = 'location='+json+'&action=listingo_update_user_location';
		
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.provider-site-wrap').remove();
				if (response.type == 'success') {
					//jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
					
					jQuery(".sp-country-select").html(response.countries);
                    jQuery(".sp-country-select").val(response.country_slug).trigger("chosen:updated");
					
					jQuery(".sp-city-select").html(response.cities);
                    jQuery(".sp-city-select").val(response.city_slug).trigger("chosen:updated");
					
				} else {
					//jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
				}
			}
		});
	}
}


//Fetch country and city from locations and save it
function listingo_fetch_selected_location(data){
	var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
	var place = data;
	
	var _county	= '';
	var _city	= '';
	
	var componentForm = {
	  locality: 'long_name',
	  administrative_area_level_1: 'short_name',
	  country: 'long_name',
	  postal_town: 'short_name',
	};

	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if( addressType == 'locality' ){
		  var val = place.address_components[i].long_name;
		  _city = val;
		  
		}
		
		// for the country, get the country code (the "short name") also
		if (addressType == "country") {
		  _county = place.address_components[i].long_name;
		}
	}
	
	var loc = _city+','+_county;
	
	jQuery('.fetched_location').val(loc);
}