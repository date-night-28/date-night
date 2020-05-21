import React from 'react'
import {Jumbotron, Container} from "react-bootstrap/Jumbotron";
import {Card, CardImg, Card.Text, Card.Body, card.Style} from "react-bootstrap";

export const Favorites = ({match}) => {
	// console.log(match);

	return <h1>Favorites</h1>
// 		<Jumbotron fluid>
// 	<Container>
// 	<h1>Favorites</h1>
// 	</Container>
// </Jumbotron>

<div>
<Card style={{ width: '18rem' }}>
<Card.Img variant="top" src="holder.js/100px180" />
<Card.Body>
<Card.Title>Card Title</Card.Title>
<Card.Text>
Some quick example text to build on the card title and make up the bulk of
the card's content.
</Card.Text>
<Button variant="primary">Go somewhere</Button>
</Card.Body>
</Card>
</div>
};