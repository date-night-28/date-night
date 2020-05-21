import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home";
import {FourOhFour} from "./pages/FourOhFour";
import {Footer} from "./pages/Footer";
import {SignUpForm} from "./shared/components/main-nav/sign-up/SignUpForm";
import {MainNav} from "./shared/components/main-nav/MainNav";


const Routing = () => (
	<>
		<BrowserRouter>
			<MainNav/>
			<SignUpForm/>
			<Switch>
				<Route exact path="/" component={Home}/>

				<Route component={FourOhFour}/>
			</Switch>
		</BrowserRouter>
		<Footer/>

	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));