import React from 'react'
import ReactDOM from 'react-dom'
import {Helmet} from 'react-helmet'

var ID = 'SeznamMap'

class SeznamMap extends React.Component {
    constructor(props) {
        super(props)
    }
    render() {
        return (<div><Helmet><script src="https://api.mapy.cz/loader.js"></script></Helmet><div>)
    }
}
var element = document.getElementById(ID)
if(null != element) {
    ReactDOM.render(<SeznamMap />, document.getElementById(ID))
}