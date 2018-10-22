var webpack = require('webpack');
var path = require('path');
var ManifestPlugin = require("webpack-manifest-plugin");
var WebpackMd5HashPlugin = require('webpack-md5-hash');
var __DEV__ = JSON.parse(process.env.BUILD_DEV || "true");
var __DEV__ = false /**/
var ASSETS_DIR = 'assets/galileo/js';
var BUILD_DIR = path.resolve(__dirname, ASSETS_DIR);
var APP_DIR = path.resolve(__dirname, 'app/Galileo/react');

module.exports = {
    entry: {  SvgMap: APP_DIR + '/SvgMap.jsx'
    },
    devServer: {
        proxy: {
            '/app': {
                target: 'http://10.10.0.100/',
                secure: false
            }
        }
    },
    output: {
        path: BUILD_DIR,
        filename: __DEV__ ? '[name].js' : '[name].[chunkhash].js',
        chunkFilename: __DEV__ ? '[name].js' : '[name].[chunkhash].js'
    },
    module : {
        loaders : [
            {
                test : /\.jsx?/,
                exclude:/(node_modules|bower)/,
                include : APP_DIR,
                loader : 'babel-loader',
                query  :{
                    presets:['react','env']
                }
            }
        ]
    },
    plugins: [
        new WebpackMd5HashPlugin(),
        new ManifestPlugin({fileName: 'manifest.json', basePath: '', publicPath: ASSETS_DIR + '/', stripSrc: /\.js/})
    ],
    bail: true
}