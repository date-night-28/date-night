import {Button, Card} from "react-bootstrap";
import React, {useEffect, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
export const FavoriteCard = ({activity}) => {

	return (
		<>

			<h1 className="text-center bg-dark text-white">{activity.activityTitle}</h1>
			<Card style={{width: '50rem'}}>
				<Card.Img variant="top" src={activity.activityImageUrl} />
				<Card.Body>
					<Card.Link href={activity.activityLink} target="_blank">Click here to View Activity details.</Card.Link>
					<Button variant="primary">
						Delete
					</Button>
				</Card.Body>
			</Card>

		</>
	)
}