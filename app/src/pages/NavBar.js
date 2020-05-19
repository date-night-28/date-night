import React from "react"
import { Navbar, Nav , NavItem } from "react-bootstrap"
import { Link } from "react-router-dom"


export const NavBar = () => {
	return (
		<Navbar>
			<Navbar.Header>
				<Navbar.Brand>
					<link to={"/"}>test</link>
				</Navbar.Brand>
				<Navbar.Toggle/>
			</Navbar.Header>
			<Navbar.Collapse>
				<Nav>
					<NavItem eventKey={1} componentClass={Link} to="/">
						Home
					</NavItem>
					<NavItem eventKey={2} componentClass={Link} to="/">
						Home
					</NavItem>
					<NavItem eventKey={3} componentClass={Link} to="/">
						Home
					</NavItem>
				</Nav>
			</Navbar.Collapse>
		</Navbar>
	)
};
