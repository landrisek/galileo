function append(markers) {
    var cluster = []
    var icon = document.getElementById('galileo-seznammap-loader').getAttribute('data-icon')
    for(var key in markers) {
        if(undefined == facilities[key]) {
            var option = markers[key]
            var point = SMap.Coords.fromWGS84(option.lng, option.lat)
            var pin = JAK.mel('div')
            pin.appendChild(JAK.mel('img', {src:icon}))
            var marker = new SMap.Marker(point, option.name, { title:option.name,url:pin})
            var card = new SMap.Card()
            card.getHeader().innerHTML = option.header
            card.getBody().innerHTML = option.html
            marker.decorate(SMap.Marker.Feature.Card, card)
            cluster.push(marker)
            facilities[key] = true
        }
    }
    layer.addMarker(cluster)
}
function closeMap(id) {
    $('#' + id + '-close').css({display: 'none'})
    $('#' + id + '-open').css({display: 'block'})
    $('#' + id).data('resized', true).animate({height:'0px',width:'0%'}, 500)
}
function loadMap(source) {
    var center = JSON.parse(source.getAttribute('data-center'))
    facilities = []
    map = new SMap(JAK.gel(source.id), SMap.Coords.fromWGS84(center.longitude, center.latitude), center.zoom)
    map.addDefaultLayer(SMap.DEF_TURIST).enable()
    map.addDefaultControls()
    layer = new SMap.Layer.Marker()
    var clusterer = new SMap.Marker.Clusterer(map);
    layer.setClusterer(clusterer);
    map.addLayer(layer)
    layer.enable()
    append(JSON.parse(source.getAttribute('data-markers')))
    map.getSignals().addListener(window, 'map-redraw', function(event) {
        var coordinates = SMap.Coords.fromEvent(event, map)
        var nw = vector(135, coordinates)
        var se = vector(-45, coordinates)
        $.post(source.getAttribute('data-link'),
              {maxLatitude:nw.y,maxLongitude:se.x,minLatitude:se.y,minLongitude:nw.x},
              function(markers) { append(markers) });
    });
}
function openMap(id) {
    $('#' + id + '-open').css({display: 'none'})
    $('#' + id + '-close').css({display: 'block'})
    $('#' + id).css({display: 'block'})
    $('#' + id).data('resized', true).animate({height:'400px',width:'100%'}, 500)
}
function vector(angle, coordinates) {
    var zoom = map.getZoom()
    length = zoom / 10;
    angle = angle * Math.PI / 180;
    return { x:length * Math.cos(angle) + coordinates.x,y:length * Math.sin(angle) + coordinates.y}
}
$(document).ready(function() {
    $('.galileo-seznammap').click(function(event) {
        var loader = document.getElementById('galileo-seznammap-loader')
        var source = document.getElementById(event.target.getAttribute('data-id'))
        if(null == loader.getAttribute('loaded')) {
            $.getScript('https://api.mapy.cz/loader.js', function() {
                $.getScript('https://api.mapy.cz/js/api/v4/smap-jak.js?v=4.13.32', function() {
                    $.getScript('https://api.mapy.cz/config.js?key=&amp;v=4.13.32', function() {
                        $.getScript('https://api.mapy.cz/js/lang/cs.js?v=4.13.32', function() {
                            loadMap(source)
                            loader.setAttribute('loaded', true)
                        });
                    });
                });
            });
        } else if(null == source.getAttribute('clicked')) {
            loadMap(source)
            source.setAttribute('clicked', true)
        }
    });
});