import React from "react"
import {Form} from "react-bootstrap"

export const SignUp = () => {
	return (
		<>
			<h1>Sign Up</h1>
			<Form>
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

		</>
	)
}