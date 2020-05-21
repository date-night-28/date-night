import React from "react"
import {Button, Card} from "react-bootstrap"


export const Home = () => {
	return (
		<>
			<h1>Home</h1>
			<div>
			<Button variant="primary" size="lg" block>
				Find me something to do!
			</Button>
			<Card>
				<Card.Img variant="top" src="https://www.fillmurray.com/200/300" />
				<Card.Body>
					<Card.Text>
						This is where small description/details of the activity will be listed. Blah blah blah something to do for you(: There’s a voice that keeps on calling me. Down the road, that’s where I’ll always be. Every stop I make, I make a new friend. Can’t stay for long, just turn around and I’m gone again. Maybe tomorrow, I’ll want to settle down, Until tomorrow, I’ll just keep moving on.
					</Card.Text>
				</Card.Body>
			</Card>
		</div>
		</>
	)
}