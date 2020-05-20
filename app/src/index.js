import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home";
import {NavBar} from "./pages/NavBar";
import {SignUp} from "./pages/SignUp";
import {FourOhFour} from "./pages/FourOhFour";
import {Footer} from "./pages/Footer";


const Routing = () => (
	<>
		<NavBar/>
		<SignUp/>
		<BrowserRouter>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route path="/" component={SignUp}/>
				<Route component={FourOhFour}/>
			</Switch>
		</BrowserRouter>
		<Footer/>

	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));