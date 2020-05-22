import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
// import {ProfileModal} from "./profile/ProfileModal";



export const MainNav = (props) => {
	return(
		<Navbar bg="primary" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand>Navbar</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				{/*<ProfileModal/>*/}
				<SignUpModal/>
				<SignInModal/>
				<LinkContainer exact to="/Favorites"
				><Nav.Link>Favorites</Nav.Link>
				</LinkContainer>
			</Nav>
		</Navbar>
	)
};