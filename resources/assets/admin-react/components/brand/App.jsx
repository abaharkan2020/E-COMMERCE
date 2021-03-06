import React from 'react'
import {Route, HashRouter, NavLink, withRouter, BrowserRouter, Router} from "react-router-dom";
import Breadcrumb from './../Breadcrumb'
import Footer from './../Footer'

import Index from './Index'
import Create from './Create'
import Edit from './Edit'

export default class Brand extends React.Component{
	render(){
		return (
			<div className="content">
				<div className="header">
					<h1 className="page-title">Brand</h1>
				</div>
				<Breadcrumb/>
				<div className="container-fluid">
					<HashRouter>
						<div>
							<Route exact path="/brand" component={Index}/>
							<Route path="/brand/create" component={Create}/>
							<Route path="/brand/:id/edit" component={Edit}/>
						</div>
					</HashRouter>
				</div>

				<Footer />
			</div>
			)
	}
}