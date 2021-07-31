/* global document */
var loader_html	= '';
jQuery(document).ready(function () {
    "use strict";
	var dir_latitude	 = scripts_vars.dir_latitude;
	var dir_longitude	= scripts_vars.dir_longitude;
	var dir_map_type	 = scripts_vars.dir_map_type;
	var dir_close_marker		  = scripts_vars.dir_close_marker;
	var dir_cluster_marker		= scripts_vars.dir_cluster_marker;
	var dir_map_marker			= scripts_vars.dir_map_marker;
	var dir_cluster_color		 = scripts_vars.dir_cluster_color;
	var dir_zoom				  = scripts_vars.dir_zoom;
	var dir_map_scroll			= scripts_vars.dir_map_scroll;
	
	loader_html	= '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
	
	//Prepare Subcatgories
	jQuery(document).on('change','.sp-sortby, .sp-orderby, .sp-showposts', function (event) {
		jQuery(".sp-form-search").submit();
	});	

});

//Init Map Scripts
function listingo_init_map_script( _data_list ){
	var dir_latitude	 = scripts_vars.dir_latitude;
	var dir_longitude	= scripts_vars.dir_longitude;
	var dir_map_type	 = scripts_vars.dir_map_type;
	var dir_close_marker		    = scripts_vars.dir_close_marker;
	var dir_cluster_marker		  = scripts_vars.dir_cluster_marker;
	var dir_map_marker			  = scripts_vars.dir_map_marker;
	var dir_cluster_color		  = scripts_vars.dir_cluster_color;
	var dir_zoom				  = scripts_vars.dir_zoom;
	var dir_map_scroll			  = scripts_vars.dir_map_scroll;
	var gmap_norecod			  = scripts_vars.gmap_norecod;
	var map_styles			      = scripts_vars.map_styles;


	if( _data_list.status == 'found' ){
		var response_data	= _data_list.users_list;
		if( _data_list.lat && _data_list.long ){
			var dir_latitude    = _data_list.lat;
			var dir_longitude	= _data_list.long;
		}
	} else{
		if( _data_list.lat && _data_list.long ){
			var dir_latitude    = _data_list.lat;
			var dir_longitude	= _data_list.long;
		} else{
			var dir_latitude    = dir_latitude;
			var dir_longitude	= dir_longitude;
		}
	}
	
	var location_center = new google.maps.LatLng(dir_latitude,dir_longitude);
	
	if(dir_map_type == 'ROADMAP'){
		var map_id = google.maps.MapTypeId.ROADMAP;
	} else if(dir_map_type == 'SATELLITE'){
		var map_id = google.maps.MapTypeId.SATELLITE;
	} else if(dir_map_type == 'HYBRID'){
		var map_id = google.maps.MapTypeId.HYBRID;
	} else if(dir_map_type == 'TERRAIN'){
		var map_id = google.maps.MapTypeId.TERRAIN;
	} else {
		var map_id = google.maps.MapTypeId.ROADMAP;
	}
	
	var scrollwheel	   = true;
	var lock		   = 'lock';
	
	if( dir_map_scroll == 'false' ){
		scrollwheel		= false;
		lock		    = 'unlock';
	}

	var mapOptions = {
		center: location_center,
		zoom: parseInt(dir_zoom),
		mapTypeId: map_id,
		scaleControl: true,
		scrollwheel: false,
		disableDefaultUI: true,
		draggable:scrollwheel,
		fullscreenControl:true
	}
	
	var map = new google.maps.Map(document.getElementById("sp-search-map"), mapOptions);
	
	var styles = listingo_get_map_styles(map_styles);
	if(styles != ''){
		var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
		map.mapTypes.set('map_style', styledMap);
		map.setMapTypeId('map_style');
	}
		
	var bounds = new google.maps.LatLngBounds();

	//Zoom In
	if(  document.getElementById('doc-mapplus') ){ 
		 google.maps.event.addDomListener(document.getElementById('doc-mapplus'), 'click', function () {      
		   var current= parseInt( map.getZoom(),10 );
		   current++;
		   if(current>20){
			   current=20;
		   }
		   map.setZoom(current);
		   jQuery(".infoBox").hide();
		});  
	}
	
	//Zoom Out
	if(  document.getElementById('doc-mapminus') ){ 
		google.maps.event.addDomListener(document.getElementById('doc-mapminus'), 'click', function () {      
			var current= parseInt( map.getZoom(),10);
			current--;
			if(current<0){
				current=0;
			}
			map.setZoom(current);
			jQuery(".infoBox").hide();
		});  
	}
	
	//Lock Map
	if( document.getElementById('doc-lock') ){ 
		google.maps.event.addDomListener(document.getElementById('doc-lock'), 'click', function () {
			if(lock == 'lock'){
				map.setOptions({ 
						scrollwheel: false,
						draggable: false 
					}
				);
				
				jQuery("#doc-lock").html('<i class="fa fa-lock" aria-hidden="true"></i>');
				lock = 'unlock';
			}else if(lock == 'unlock'){
				map.setOptions({ 
						scrollwheel: false,
						draggable: true 
					}
				);
				
				jQuery("#doc-lock").html('<i class="fa fa-unlock" aria-hidden="true"></i>');
				lock = 'lock';
			}
		});
	}
	
	//Map resize
	jQuery(document).on("click",'.tg-mapinnerbanner .tg-btnmapview', function(e){
        jQuery('.tg-mapinnerbanner').toggleClass('tg-open');
		if( jQuery('.tg-mapinnerbanner').hasClass('tg-open') ) {
			jQuery('body').append(loader_html);
		}
		setTimeout(function(){
			jQuery('body').find('.provider-site-wrap').remove();
			google.maps.event.trigger(map,"resize");
			map.setCenter(location_center);
		},1000);
    });
	
	jQuery(document).on("click",'.tg-sidebarvtwo .tg-btnmapview', function(e){
		jQuery('#sp-search-map div.gm-style button[title="Toggle fullscreen view"]').trigger('click');
    });
	
	
	if( _data_list.status == 'found' && typeof(response_data) != "undefined" && response_data !== null ){
		jQuery('#gmap-noresult').html('').hide(); //Hide No Result Div
		var markers = new Array();
		var info_windows = new Array();
		var clusterMarker = [];

		var spiderConfig = {
			 markersWontMove: true, 
			 markersWontHide: true, 
			 keepSpiderfied: true, 
			 circleSpiralSwitchover: 40 
		};
		
		// Create OverlappingMarkerSpiderfier instsance
		var markerSpiderfier = new OverlappingMarkerSpiderfier(map, spiderConfig);
		map.active_window = false;
		for (var i=0; i < response_data.length; i++) {
			
			markers[i] = new google.maps.Marker({
				position: new google.maps.LatLng(response_data[i].latitude,response_data[i].longitude),
				map: map,
				icon: response_data[i].icon,
				title: response_data[i].username,
				animation: google.maps.Animation.DROP,
				visible: true
			});
			
			bounds.extend(markers[i].getPosition());
			var boxText = document.createElement("div");
			boxText.className = 'directory-detail';
			var innerHTML = "";
			boxText.innerHTML += response_data[i].html.content;
			
			var myOptions = {
				content: boxText,
				disableAutoPan: true,
				maxWidth: 0,
				alignBottom: true,
				pixelOffset: new google.maps.Size( -200, -65 ),
				zIndex: null,
				closeBoxMargin: "0 0 -16px -16px",
				closeBoxURL: dir_close_marker,
				infoBoxClearance: new google.maps.Size( 1, 1 ),
				isHidden: false,
				pane: "floatPane",
				enableEventPropagation: false
			};
		
			var ib = new InfoBox( myOptions );
			attachInfoBoxToMarker( map, markers[i], ib );
			markerSpiderfier.addMarker(markers[i]);  // adds the marker to the spiderfier
		}
		
		var markerClustererOptions = {
			ignoreHidden: true,
			maxZoom: 15,
			styles: [{
				textColor: scripts_vars.dir_cluster_color,
				url: scripts_vars.dir_cluster_marker,
				height: 48,
				width: 48
			}]
		};
		
		// Create cluster	
		new MarkerClusterer(map, markers, markerClustererOptions);
		
	} else{
		jQuery('#gmap-noresult').html(gmap_norecod).show();
	}
}
//Assign Info window to marker
function attachInfoBoxToMarker( map, marker, infoBox ){
	google.maps.event.addListener( marker, 'spider_click', function(){
		var scale = Math.pow( 2, map.getZoom() );
		var offsety = ( (100/scale) || 0 );
		var projection = map.getProjection();
		var markerPosition = marker.getPosition();
		var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
		var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
		var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
		
		// close it
		if (map.active_window != false) {
		  map.active_window.infoBox.close(map,map.active_window.marker);
		}
		
		infoBox.open(map,marker);
		// then add the active window to this prop
		map.active_window = {infoBox: infoBox , marker: marker};
		map.setCenter( aboveMarkerLatLng );
		//infoBox.open( map, marker );
	});
}


//Init detail page Map Scripts
function listingo_init_detail_map_script( _data ){
	
	var response_data	= _data.userinfo;
	
	var dir_map_type	 = scripts_vars.dir_map_type;
	var dir_zoom		 = scripts_vars.dir_zoom;
	var dir_map_scroll	 = scripts_vars.dir_map_scroll;
	var gmap_norecod	 = scripts_vars.gmap_norecod;
	var map_styles		 = scripts_vars.map_styles;

	if(dir_map_type == 'ROADMAP'){
		var map_id = google.maps.MapTypeId.ROADMAP;
	} else if(dir_map_type == 'SATELLITE'){
		var map_id = google.maps.MapTypeId.SATELLITE;
	} else if(dir_map_type == 'HYBRID'){
		var map_id = google.maps.MapTypeId.HYBRID;
	} else if(dir_map_type == 'TERRAIN'){
		var map_id = google.maps.MapTypeId.TERRAIN;
	} else {
		var map_id = google.maps.MapTypeId.ROADMAP;
	}
	
	var styles = listingo_get_map_styles(map_styles);

	jQuery('#tg-locationmap').gmap3({
									marker:{
									  latLng: [response_data[0].latitude, response_data[0].longitude],
									  draggable:true,
									  options: {
											title: response_data[0].address,
											icon: response_data[0].marker,
									  }
									},
									map: {
										options: {
											zoom: parseInt(dir_zoom),
											scrollwheel: dir_map_scroll,
											disableDoubleClickZoom: true,
										}
									}
								});
}

//Init ad page Map Scripts
function listingo_init_ad_map_script( _data ){
	var response_data	= _data.adinfo;
	
	var dir_map_type	 = scripts_vars.dir_map_type;
	var dir_zoom		 = scripts_vars.dir_zoom;
	var dir_map_scroll	 = scripts_vars.dir_map_scroll;
	var gmap_norecod	 = scripts_vars.gmap_norecod;
	var map_styles		 = scripts_vars.map_styles;

	if(dir_map_type == 'ROADMAP'){
		var map_id = google.maps.MapTypeId.ROADMAP;
	} else if(dir_map_type == 'SATELLITE'){
		var map_id = google.maps.MapTypeId.SATELLITE;
	} else if(dir_map_type == 'HYBRID'){
		var map_id = google.maps.MapTypeId.HYBRID;
	} else if(dir_map_type == 'TERRAIN'){
		var map_id = google.maps.MapTypeId.TERRAIN;
	} else {
		var map_id = google.maps.MapTypeId.ROADMAP;
	}
	
	var styles = listingo_get_map_styles(map_styles);

	jQuery('#tg-locationmapvtwo').gmap3({
									marker:{
									  latLng: [response_data[0].latitude, response_data[0].longitude],
									  draggable:true,
									  options: {
											title: response_data[0].address,
											icon: response_data[0].marker,
									  }
									},
									map: {
										options: {
											zoom: parseInt(dir_zoom),
											scrollwheel: dir_map_scroll,
											disableDoubleClickZoom: true,
										}
									}
								});
}
//Set Spiderfy Markers
function MapSpiderfyMarkers(markers){
    for (var i = 0; i < markers.length; i++) {
        if(typeof oms !== 'undefined'){
           oms.addMarker(markers[i]);
        }
    }
}