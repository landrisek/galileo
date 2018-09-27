function closeMap() {
    $('.seznam-map-close').css({display: 'none'})
    $('.seznam-map-open').css({display: 'block'})
    $('#mapa').data('resized', true).animate({height:'0px',width:'0%'}, 500)
}
function openMap() {
    $('.seznam-map-open').css({display: 'none'})
    $('.seznam-map-close').css({display: 'block'})
    $('.toogle-list').removeClass('toogle-list-max', 500)
    $('#mapa').css({display: 'block'})
    $('#mapa').data('resized', true).animate({height:'400px',width:'100%'}, 500)
}