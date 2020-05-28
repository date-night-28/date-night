import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import {UseJwt} from "../../utils/JwtHelpers";
import {httpConfig} from "../../utils/http-config";
// import {ProfileModal} from "./profile/ProfileModal";

const loggedIn=window.localStorage.getItem("jwt-token")

export const MainNav = (props) => {
	const jwt=UseJwt();

	const signOut = () => {
		httpConfig.get("apis/sign-out/")
			.then(reply =>{
				if (reply.status === 200){
					window.localStorage.removeItem("jwt-token");
					setTimeout(()=>{
						window.location.reload();
					},1500);
				}
			});
	};

	return(
		<Navbar fixed="top" bg="dark" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand>Date Night</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				{/*<ProfileModal/>*/}
				<SignUpModal/>
				<SignInModal/>
				{jwt !== null &&
				<LinkContainer exact to="/Favorites"
				><Nav.Link>Favorites</Nav.Link>
				</LinkContainer>
				}
				{jwt !== null &&
					<Nav.Item onClick={signOut}
								 className="btn"
					>Sign Out</Nav.Item>
				}

			</Nav>
		</Navbar>
	)
};