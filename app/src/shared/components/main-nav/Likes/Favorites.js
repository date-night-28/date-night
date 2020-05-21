import React from 'react'
import { Card, Button} from "react-bootstrap";

export const Favorites = ({match}) => {
	console.log(match);

	return <>
	<h1/> Favorites
	<Card style={{ width: '18rem' }}>
		<Card.Img variant="top" src="https://www.fillmurray.com/200/300" />
		<Card.Body>
			<Card.Title>Card Title</Card.Title>
			<Card.Text>
				Some quick example text to build on the card title and make up the bulk of
				the card's content.
			</Card.Text>
			<Button variant="primary">Go somewhere</Button>
		</Card.Body>
	</Card>
	</>

};