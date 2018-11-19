$ = require('../../../../node_modules/jquery/dist/jquery.min.js')

describe('SeznamMap', () => {
    it('Loader.load() required valid api links', () => {
        expect($.get({async:false,url:'xxx'}).readyState).toEqual(0)
        expect($.get({async:false,url:'https://api.mapy.cz/loader.js'}).readyState).toEqual(4)
        expect($.get({async:false,url:'https://api.mapy.cz/js/api/v3/smap-jak.js?v=xxx'}).readyState).toEqual(0)
        expect($.get({async:false,url:'https://api.mapy.cz/js/api/v5/smap-jak.js'}).readyState).toEqual(4)
        expect($.get({async:false,url:'https://api.mapy.cz/js/api/v6/smap-jak.js'}).readyState).toEqual(0)
        expect($.get({async:false,url:'https://api.mapy.cz/js/api/v4/smap-jak.js?v=4.13.32'}).readyState).toEqual(4)
        expect($.get({async:false,url:'https://api.mapy.cz/config.js?key=&amp;v=4.13.32'}).readyState).toEqual(4)
        expect($.get({async:false,url:'https://api.mapy.cz/js/lang/cs.js?v=4.13.32'}).readyState).toEqual(4)
    });
});