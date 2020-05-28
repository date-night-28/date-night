import {Button, Card} from "react-bootstrap";
import React, {useEffect, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
export const FavoriteCard = ({activity}) => {

	return (
		<>

			<Card className="m-3 col-lg-2 col-12">
<Card.Img variant="top" src={activity.activityImageUrl} />
			<h4 className="text-center bg-dark text-white">{activity.activityTitle}</h4>
			<Card.Body>
			<Card.Link href={activity.activityLink} target="_blank">Click here to View more details.</Card.Link>
			<th/>
			<Button variant="primary">
			Delete
			</Button>
			</Card.Body>
			</Card>

		</>
	)
}