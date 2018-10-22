function closeMap(id) {
    $('#' + id + '-close').css({display: 'none'})
    $('#' + id + '-open').css({display: 'block'})
    $('#' + id).data('resized', true).animate({height:'0px',width:'0%'}, 500)
}
function openMap(id) {
    $('#' + id + '-open').css({display: 'none'})
    $('#' + id + '-close').css({display: 'block'})
    $('#' + id).css({display: 'block'})
    $('#' + id).data('resized', true).animate({height:'400px',width:'100%'}, 500)
}