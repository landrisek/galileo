$ = require('../../../../node_modules/jquery/dist/jquery.min.js')
describe('SeznamMap', () => {
    it('Loader.load should return exactly three scripts', () => {
        $.getScript('https://api.mapy.cz/loader.js', function(response) {
            console.log(response)
            return
            $.getScript('https://api.mapy.cz/js/api/v4/smap-jak.js?v=4.13.32', function() {
                $.getScript('https://api.mapy.cz/config.js?key=&amp;v=4.13.32', function() {
                    $.getScript('https://api.mapy.cz/js/lang/cs.js?v=4.13.32', function() {
                        loadMap(source)
                        loader.setAttribute('loaded', true)
                    });
                });
            });
        });
    });
});