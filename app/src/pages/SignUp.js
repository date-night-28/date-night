import React from "react"
import {Form} from "react-bootstrap"
import Jumbotron from 'react-bootstrap/Jumbotron'
import Signup from "../components/css/signup.css"



export const SignUp = () => {
	return (
		<>
			<h1>Sign Up</h1>
			<Jumbotron fluid>
					<h1>Date Night</h1>
			</Jumbotron>

			<div>
			<Form>
				<h3>Sign up now to start your adventure!</h3>
				<Form.Group controlId="formGroupEmail">
					<Form.Label>Email address</Form.Label>
					<Form.Control type="email" placeholder="Enter email" />
				</Form.Group>
				<Form.Group controlId="formGroupName">
					<Form.Label>Name</Form.Label>
					<Form.Control type="Name" placeholder="Name (Username)" />
				</Form.Group>
				<Form.Group controlId="formGroupPassword">
					<Form.Label>Password</Form.Label>
					<Form.Control type="password" placeholder="Password" />
				</Form.Group>
			</Form>
			</div>

		</>
	)
}