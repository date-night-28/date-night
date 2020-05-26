import React from "react"
import {Button, Card} from "react-bootstrap";


export const Activity = ({activities}) => {
	let activity=activities[Math.round (Math.random()*activities.length-1)]

	const submit = () => {
		window.location.reload()
	}

	return (
		<>
			<h1>Activity</h1>
			​
			<button className="btn btn-primary" type="submit" onClick={submit}>
			Find me something to do!
			</button>

			<h1 className="text-center bg-dark text-white">{activity.activityTitle}</h1>
			<Card style={{width: '50rem'}}>
				<Card.Img variant="top" src={activity.activityImageUrl} />
				<Card.Body>
					<Card.Link href={activity.activityLink} target="_blank">Click here to View Activity details.</Card.Link>
					<Button variant="primary">
						Favorite
					</Button>
				</Card.Body>
			</Card>


		</>
	)
}