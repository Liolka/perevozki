<div class="page_main-column grid-container"> 

<? /*<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> */?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
                        
<script>
var rendererOptions = {
  draggable: true
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
var directionsService = new google.maps.DirectionsService();
var map;
	
var SLS = {
	SITE_ADMIN_HOST :   "transcrm.transinfo.by",
	SITE_MAIN_HOST  :   "www.transinfo.by",
	COOKIE_DOMAIN   :   ".transinfo.by",
	PUSHER_URL_WEB  :   "PUSHER_URL_WEB"
};

function initialize() {

  var rendererOptions = {
     draggable: true
  };
  directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
 // directionsDisplay = new google.maps.DirectionsRenderer();
  geocoder = new google.maps.Geocoder();
  var minsk = new google.maps.LatLng(53.9, 27.56);
  var mapOptions = {
    zoom:8,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: minsk
  }
  map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('filter-aad'));
	
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);
	

  directionsDisplay.setMap(map);

	google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
		computeTotalDistance(directionsDisplay.directions);
	});
	
//----------------------------------------------	
  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });
	
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
  });
	
}

function computeTotalDistance(result) {
    $('#km').val(result.routes[0].legs[0].distance.value);
}

function codeAddress(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

function calcRoute() {
  if ($('#fromidcity option:selected').val() > 0) {
  	var start = $('#fromidc option:selected').text()+','+$('#fromidr option:selected').text()+','+$('#fromidcity option:selected').text();
  } else {
  	var start = $('#fromidc option:selected').text()+','+$('#fromidr option:selected').text();
  }

  if ($('#toidcity option:selected').val() > 0) {
	  var end = $('#toidc option:selected').text()+','+$('#toidr option:selected').text()+','+$('#toidcity option:selected').text();
  } else {
	  var end = $('#toidc option:selected').text()+','+$('#toidr option:selected').text();
  }

  if ($('#toidc option:selected').val() == 0 )	{
     codeAddress(start);
  } else {
	  var request = {
		origin:start,
		destination:end,
		travelMode: google.maps.TravelMode.DRIVING,
		provideRouteAlternatives:true
	  };

	  directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
	   $('#infodata').html("Итого РАССТОЯНИЕ: "+result.routes[0].legs[0].distance.text+" ВРЕМЯ В ПУТИ: "+result.routes[0].legs[0].duration.text);
			 directionsDisplay.setDirections(result);
		$('#km').val(result.routes[0].legs[0].distance.value);
		}
	  });
  }
}


$(document).ready( function() {
	initialize();
});

</script>


<script>
    var rendererOptions = {
      draggable: true
    };
    var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    var directionsService = new google.maps.DirectionsService();
    var map;

    function initialize() {
        var rendererOptions = {
            draggable: true
        };
        directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
        // directionsDisplay = new google.maps.DirectionsRenderer();
        geocoder = new google.maps.Geocoder();
        var minsk = new google.maps.LatLng(53.9, 27.56);
        var mapOptions = {
            zoom:8,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: minsk
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        directionsDisplay.setMap(map);

        google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
            computeTotalDistance(directionsDisplay.directions);
        });
    }

    function computeTotalDistance(result) {
        $('#km').val(result.routes[0].legs[0].distance.value);
    }

    function codeAddress(address) {
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }

    function calcRoute() {
        if ($('#fromidcity option:selected').val() > 0) {
            var start = $('#fromidc option:selected').text()+','+$('#fromidr option:selected').text()+','+$('#fromidcity option:selected').text(); 
        } else {
            var start = $('#fromidc option:selected').text()+','+$('#fromidr option:selected').text();
        }

        if ($('#toidcity option:selected').val() > 0) {
            var end = $('#toidc option:selected').text()+','+$('#toidr option:selected').text()+','+$('#toidcity option:selected').text();
        } else {
            var end = $('#toidc option:selected').text()+','+$('#toidr option:selected').text();
        }

        if ($('#toidc option:selected').val() == 0 ) {
            codeAddress(start);
        } else {
            var request = {
                origin:start,
                destination:end,
                travelMode: google.maps.TravelMode.DRIVING,
                provideRouteAlternatives:true
            };
			
            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    $('#infodata').html("Итого РАССТОЯНИЕ: "+result.routes[0].legs[0].distance.text+" ВРЕМЯ В ПУТИ: "+result.routes[0].legs[0].duration.text);
                    directionsDisplay.setDirections(result);
                    $('#km').val(result.routes[0].legs[0].distance.value);
                }
            });
        }
    }


    $(document).ready( function() {
        initialize();		

    });



    var datalist;
    var k1;
    var k2;
    var cdata = new Array(0,0,0,0,0,0,0,0,0,0,0);
    var dlinks = 1;


    function d_rez(t) {
        if (t==0) {
            $('#infodata').slideDown(1000);
            if (dlinks == 1) {
                $('#netochnosti').show();
                $('#rezurl').show();
            }

        }
        $('#routedata').html($("#filter1").val()+' - '+$("#filter2").val());

        if ($("#filter1").val()) {
            calcRoute2($("#filter1").val(),$("#filter2").val());
        } else {
            calcRoute2($("#filter111").val(),$("#filter222").val());
        }

    }



    function hiderez(i) {
        doSelect(i);
        $('.autocomplete').hide();
    }

    function doSelect(i) {
        //var obj = datalist[key];
        if (typeof($('#filter'+i).val()) != 'undefined') {
            txt = $('#filter'+i).val().replace(/^[0-9 ]+/,'');
            txt = strip(txt);
            //$('#filter'+i).val(txt);
        }

        wayp = '';
        if (i==1) {
            start = txt;
        } else if (i==2) {
            end = txt;
        } else if (i>2) {
            wayp = txt;
        }

        url = 'http://' + SLS.SITE_MAIN_HOST + '/distance/'+$('#filter1').val()+'/'+$('#filter2').val();
        $("#rez_url").html(url.replace(/,\s+/g,','));
		
		console.log(i);
		console.log(txt);
		console.log(start);
		console.log(end);


        calcRoute2(start,end);
    }

    var end = 0;

    function calcRoute2(start,end) {
        var waypts = [];
        var hw = false;
        var too = false;

        if (!start && !end) { return false; }

        if (end == 0 ) {
            codeAddress(start);
        } else {
            for (i=3;i<9;i++) {
                vv = $("#filter"+i).val();
                if (vv) {
                    console.log('vv:'+vv);
                    waypts.push({
                        location:vv,
                        stopover:true
                    });
                }
            }

            if ($("#d_hw").is(":checked")) hw = true;
            if ($("#d_to").is(":checked")) too = true;

            var request = {
                origin:start,
                destination:end,
                waypoints:waypts,
                provideRouteAlternatives:true,
                avoidHighways: hw,
                avoidTolls: too,
                travelMode: google.maps.TravelMode.DRIVING,
                provideRouteAlternatives:true
            };

            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);
      
                    var txt = "";
                    var rashod = "";
                    var rashodv = 0;
                    var summ = '';
                    var fprice = '';

                    /*
					if (typeof(result.routes[0]) != 'undefined') {
                        $('#km').val(result.routes[0].legs[0].distance.value);
                         
                        if (result.routes[0].legs[0].distance.value > 0) {  
                            $.post("http://" + SLS.SITE_MAIN_HOST + "/request.php?mode=front&item=transinfo_ru_distance&action=save_d", {
                                fromc: cdata[1], 
                                toc: cdata[2], 
                                tc1: cdata[3], 
                                tc2: cdata[4], 
                                tc3: cdata[5], 
                                tc4: cdata[6], 
                                tc5: cdata[7], 
                                tc6: cdata[8], 
                                tc7: cdata[9], 
                                km: result.routes[0].legs[0].distance.value   
                            },
                            function(data) { }
                            );   
                        }
                    }
					*/

                    $('#infodata').html(' ');
         
                    //debugger;
                    for (i=0;i<result.routes.length;i++) {

                        summ = result.routes[i].summary;
                        var dist=0;
                        var  mtime=0;
                        ///////////legs

                        for (ii=0;ii<result.routes[i].legs.length;ii++) {
                            dist = dist + result.routes[i].legs[ii].distance.value;
                            mtime = mtime + result.routes[i].legs[ii].duration.value;
                        }

                        var mhours = parseInt( mtime / 3600 ) % 24;
                        var mminutes = parseInt( mtime / 60 ) % 60;


                        if ($('#drashod').val()) { 
                            rashodv = Math.round(dist/1000/100*$('#drashod').val().replace(/,/g, '.')); 
                            rashod = "<p class='result-value'>"+rashodv+" л. топлива</p>"; 
                        }

                        if ($('#dfuelprice').val()) { 
                            fprice = "<p class='result-value'>"+Math.round(rashodv*$('#dfuelprice').val().replace(/,/g, '.'))+" "+$('#dfuelpricev').val().replace(/,/g, '.')+"</p>"; 
                        }

                        txt = "<div class='droute dfirst'><h3>Расстояние по маршруту "+summ+": </h3><p class='result-value'>"+parseInt(dist/1000)+" км.</p><p class='result-value'>"+mhours+" ч. "+mminutes+" мин.</p>"+rashod+fprice+"<a href='javascript:' onClick='d_alternate("+i+")' class='b-btn blue-btn btn-border'>Показать на карте</a><a href='#scorrect' class='b-btn rorange-btn btn-border' onClick=\"$('#d_correct').toggle()\">Скорректировать</a><div class='clear'></div></div>";
                        
                        $('#infodata').append(txt);
                    }

                }
            });
        }
    }

    function send_correct(obj) {
        $.post(
            "http://" + SLS.SITE_MAIN_HOST + "/request.php?mode=front&item=transinfo_ru_distance&action=save_new",
            { 
                fromc: cdata[1], 
                toc: cdata[2], 
                tc1: cdata[3], 
                tc2: cdata[4], 
                tc3: cdata[5], 
                tc4: cdata[6], 
                tc5: cdata[7], 
                tc6: cdata[8], 
                tc7: cdata[9], 
                km: $("#d_correct_i").val(), 
                comment: $("#d_correct_t").val()  
            },
            function(data) {
                $("#d_correct").html("<h2> Данные получены. Спасибо. </h2>");
            }
        );  
    }

    function d_alternate(i) {
        directionsDisplay.setRouteIndex(i); 
    }

    function dtabs(obj) {

        if ($(obj).attr('class') == 'active' ) { return false; }

        $('.active').removeClass();

        if ($(obj).attr('id') == 'dtabsaddress') {
            $('#distance_tab1').hide();
            $('#distance_tab2').fadeIn(250);
            $(obj).addClass('active');
            dlinks = 0;
            $('#filter1').val('');
            $('#filter2').val('');
        } else {
            $('#distance_tab2').hide();
            $('#distance_tab1').fadeIn(250);
            $(obj).addClass('active');
            dlinks = 1;
        }
    }


function doSet(key,i) {
	var obj = datalist[key];
	txt = obj.cityname.replace(/^[0-9 ]+/,'')+', '+obj.rname+', '+obj.cname;
	txt = strip(txt);

	if (typeof(cdata) != 'undefined') {
		cdata[i] = obj.cityid;
	}

	autocompleteobj = obj;

	$("#filter"+i).val(txt);
}
	
function strip(html) {
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent||tmp.innerText;
}
	
	
function capitaliseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
	
	
function findcity(val,obj,i,idrr) {
	var html = '',
		txt = '',
		key='';

	val = capitaliseFirstLetter(val);

	$('#filter'+i).val(val);

	if (val != null && val.length > 1) {
		$.get('http://www.transinfo.by/request.php',{mode:'front',item:'transinfo_structure_geo',idr:idrr,action:'loadcitylist',f:encodeURIComponent(val),JsHttpRequest:'0-xml'}, function(data) {

			if (data.js.q) datalist = data.js.q 

			if (data.js.q != null) {
				notfound=0;
				$.each(data.js.q, function(key, val) { 
					if (val.cityname != 'undefined')	{
						txt = "<b>"+val.cityname+"</b>";
						if (val.rname != '') txt = txt+',<i>'+val.rname+'</i>';
						if (val.cname != '') txt = txt+', '+val.cname;

						if (val.citynameen != '') txt = txt+' - <b>'+val.citynameen+'</b>';
						if (val.rnameen != '') txt = txt+', <i>'+val.rnameen+'</i>';
						if (val.cnameen != '') txt = txt+', '+val.cnameen;

						if (txt) {
							html = html + '<li><a href="javascript:doSelect('+key+','+i+')" onClick="doSelect('+key+','+i+')" onMouseOver="doSet('+key+','+i+')">'+txt+'</a></li>';
						}
					}
				});
			} else {
				html = 'город <b>'+val+'</b> не найден';
				notfound=1;
			}

			$("#autocomplete"+i).html('<ul>'+html+'</ul>');
			$("#autocomplete"+i).slideDown('slow');
		},'json');
	}
}
	
	function getcitieslist(obj) {
		console.log($(obj).val());
		
// https://maps.googleapis.com/maps/api/place/autocomplete/json?input=Гоме&types=(cities)&language=ru_RU&components=country:by&key=AIzaSyA1mi5FQDkimCEvKq5XZnR-Ladfn_jiGkE		
		$.get('/gmap.php',
			  {input : $(obj).val()}, 
			  function(data) {
				console.log(data);
			
			/*
			if (data.js.q) datalist = data.js.q 

			if (data.js.q != null) {
				notfound=0;
				$.each(data.js.q, function(key, val) { 
					if (val.cityname != 'undefined')	{
						txt = "<b>"+val.cityname+"</b>";
						if (val.rname != '') txt = txt+',<i>'+val.rname+'</i>';
						if (val.cname != '') txt = txt+', '+val.cname;

						if (val.citynameen != '') txt = txt+' - <b>'+val.citynameen+'</b>';
						if (val.rnameen != '') txt = txt+', <i>'+val.rnameen+'</i>';
						if (val.cnameen != '') txt = txt+', '+val.cnameen;

						if (txt) {
							html = html + '<li><a href="javascript:doSelect('+key+','+i+')" onClick="doSelect('+key+','+i+')" onMouseOver="doSet('+key+','+i+')">'+txt+'</a></li>';
						}
					}
				});
			} else {
				html = 'город <b>'+val+'</b> не найден';
				notfound=1;
			}

			$("#autocomplete"+i).html('<ul>'+html+'</ul>');
			$("#autocomplete"+i).slideDown('slow');
			*/
		},'json');
		
		
	}
</script>




<div class="distance-page__wrap">
    <div class="page__main-title">
        <h2><i></i>
          РАСЧЁТ РАССТОЯНИЙ        </h2>
        <p class="adding-text">Система расчета расстояний - позволяет вам расчитывать растояния с помощью прогрессивных технологий Google Maps.</p>
        <noscript>
          &lt;p class="adding-text it-red"&gt;
          Для данный страницы необходимо включить JavaScript поддержку в вашем браузере. Для включения данной функции &lt;a href="http://www.transinfo.by/java.html" target="_blank"&gt;следуйте инструкции&lt;/a&gt;
          &lt;/p&gt;
        </noscript>
        <div class="clear"></div>
    </div>

    <div class="distance__form-wrap">

        <div class="distance_tabs">
            <a href="javascript:" onclick="dtabs(this)" id="dtabscity" class="active">Расчет по городам</a>
            <a href="javascript:" onclick="dtabs(this)" id="dtabsaddress">Расчет по адресу</a>
        </div>

        <input type="hidden" name="k1" value="">
        <input type="hidden" name="k2" value="">

        <div class="distance__form-inner">

            <div id="distance_tab1">
                <div class="grid-33 tablet-grid-50">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Откуда:</b>
                                <span class="adding-txt">Например: Минск, Беларусь</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter1" value="" onkeyup="findcity(this.value,this,1)" onblur="hiderez(1)">
                                <input type="text" name="query1" id="filter-aad" value="" onkeyup="getcitieslist(this)" >
                                <div id="autocomplete1" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="grid-33 tablet-grid-50">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Куда:</b>
                                <span class="adding-txt">Например: Москва, Россия</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query2" id="filter2" value="" onkeyup="findcity(this.value,this,2)" onblur="hiderez(2)">
                                <div id="autocomplete2" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="grid-33 tablet-grid-50">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №1:</b>
                                <span class="adding-btn" onclick="$('#d_addcity4').fadeIn(150);$('#daddlnk1').hide();" id="daddlnk1"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner" id="d_addcity0">
                                <input type="text" name="query" id="filter3" value="" onkeyup="findcity(this.value,this,3)" onblur="hiderez(3)">
                                <div id="autocomplete3" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="grid-33 tablet-grid-50" id="d_addcity4" style="display:none;">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №2:</b>
                                <span class="adding-btn" onclick="$('#d_addcity5').fadeIn(150);$('#daddlnk4').hide();" id="daddlnk4"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter4" value="" onkeyup="findcity(this.value,this,4)" onblur="hiderez(4)">
                                <div id="autocomplete4" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="grid-33 tablet-grid-50" id="d_addcity5" style="display:none;">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №3:</b>
                                <span class="adding-btn" onclick="$('#d_addcity6').fadeIn(150);$('#daddlnk5').hide();" id="daddlnk5"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter5" value="" onkeyup="findcity(this.value,this,5)" onblur="hiderez(5)">
                                <div id="autocomplete5" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="grid-33 tablet-grid-50" id="d_addcity6" style="display:none;">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №4:</b>
                                <span class="adding-btn" onclick="$('#d_addcity7').fadeIn(150);$('#daddlnk6').hide();" id="daddlnk6"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter6" value="" onkeyup="findcity(this.value,this,6)" onblur="hiderez(6)">
                                <div id="autocomplete6" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="grid-33 tablet-grid-50" id="d_addcity7" style="display:none;">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №5:</b>
                                <span class="adding-btn" onclick="$('#d_addcity8').fadeIn(150);$('#daddlnk7').hide();" id="daddlnk7"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter7" value="" onkeyup="findcity(this.value,this,7)" onblur="hiderez(7)">
                                <div id="autocomplete7" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="grid-33 tablet-grid-50" id="d_addcity8" style="display:none;">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №6:</b>
                                <span class="adding-btn" onclick="$('#d_addcity9').fadeIn(150);$('#daddlnk8').hide();" id="daddlnk8"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter8" value="" onkeyup="findcity(this.value,this,8)" onblur="hiderez(8)">
                                <div id="autocomplete8" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="grid-33 tablet-grid-50" id="d_addcity9" style="display:none;">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Через город №7:</b>
                                <span class="adding-btn" onclick="$('#d_addcity10').fadeIn(150);$('#daddlnk9').hide();" id="daddlnk9"><i></i>Добавить</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter9" value="" onkeyup="findcity(this.value,this,9)" onblur="hiderez(9)">
                                <div id="autocomplete9" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                                <div class="clear"></div>
            </div>

            <div id="distance_tab2" style="display:none;">
                <div class="grid-50 tablet-grid-50">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Откуда (Адрес):</b>
                                <span class="adding-txt">Например: Белaрусь, Минск, Независимости 44</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query" id="filter111" value="" onchange="calcRoute2($(&quot;#filter111&quot;).val(),$(&quot;#filter222&quot;).val())">
                                <div id="autocomplete1" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="grid-50 tablet-grid-50">
                    <div class="form_line-wrap">
                        <div class="form_line-item">
                            <p class="form_item-title">
                                <b>Куда (Адрес):</b>
                                <span class="adding-txt">Например: Россия, Москва, Тверская 44</span>
                            </p>
                            <div class="form_item-inner">
                                <input type="text" name="query2" id="filter222" value="" onchange="calcRoute2($(&quot;#filter111&quot;).val(),$(&quot;#filter222&quot;).val())">
                                <div id="autocomplete2" class="autocomplete"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="distance__form-options">
                <div class="grid-33 tablet-grid-50">
                    <label>
                        <input type="checkbox" name="d_hw" id="d_hw" value="1" onchange="calcRoute2($(&quot;#filter1&quot;).val(),$(&quot;#filter2&quot;).val())">Избегать автомагистралей
                    </label>
                    <label>
                        <input type="checkbox" name="d_to" id="d_to" value="1" onchange="calcRoute2($(&quot;#filter1&quot;).val(),$(&quot;#filter2&quot;).val())">Избегать платных дорог, паромов
                    </label>
                </div>
                <div class="grid-66 tablet-grid-50">
                    <div class="distance-options__item">
                        Средний расход топлива
                        <input type="text" class="inp-w-1" name="rashod" id="drashod" onchange="d_rez(1)">
                        литров/100 км.  
                    </div>
                    <div class="distance-options__item">
                        Цена 1 литра топлива
                        <input type="text" class="inp-w-2" name="fuelprice" id="dfuelprice" onchange="d_rez(1)">
                        <select name="fuelpricev" id="dfuelpricev">
                            <option value="рублей">руб.</option> 
                            <option value="usd">USD</option> 
                            <option value="eur">EUR</option> 
                        </select>
                    </div>
                </div>        
                <div class="clear"></div>
            </div>

            <div class="grid-33 tablet-grid-50 distance__result-btn">
                <a href="javascript:d_rez(0)" class="b-btn blue-btn">Показать результат</a>
            </div>
            <div class="clear"></div>


            <div class="distance__result-list" id="infodata" style="display: block;"> 
                <div class="clear"></div>
            </div>

            <a name="scorrect"></a>
            <div class="clear"></div>
        </div>

        <div class="distance__result-actions">
            <div class="grid-50 tablet-grid-100">
                <a href="javascript:" onclick="$('#d_rezurl').toggle()" id="rezurl">Скопировать ссылку на результат расчета</a>

                <div class="result-action_sblock" id="d_rezurl" style="display:none">
                    <p><b>Ссылка на расчет:</b></p>
                    <textarea type="text" name="rez_url" id="rez_url"></textarea>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="grid-50 tablet-grid-100">
                <a href="javascript:" onclick="$('#d_correct').toggle()" id="netochnosti">Нашли неточности в работе расчета расстояний?</a>

                <div class="result-action_sblock" id="d_correct" style="display:none">
                    <p><b>Маршрут:</b> <span id="routedata"></span></p>
                    <p>Корректное расстояние: <input type="text" name="d_correct" id="d_correct_i"> км.</p>
                    <p>Ваши замечания и предложения по работе расчета:</p>
                    <textarea name="d_correct" id="d_correct_t"></textarea>
                    <a href="javascript:send_correct(this)" class="b-btn medium-btn green-btn">Отправить</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>

    <div class="distance__map-wrap">
        <div class="canvas-map_block">
			<div id="map_canvas" style="width:100%;height:400px;"></div>
        </div>

        <div class="distance__map-notes">
            <h3>Рекомендации по использованию расчета расстояний</h3>
            <div>
                <p>Маршрут на карте можно перемещать курсором, прокладывая маршрут через нужные города, все расчеты обновятся в соответствии с изменениями на карте</p>
            </div>
        </div>
    </div>
</div>


            </div>