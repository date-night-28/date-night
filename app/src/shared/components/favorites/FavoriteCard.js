import {Button, Card} from "react-bootstrap";
import React, {useEffect, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
export const FavoriteCard = ({activity}) => {

	return (
		<>

			<Card className="m-3" style={{background: `url(${activity.activityImageUrl}) no-repeat center center`,  backgroundSize: "cover", height: "25rem", width: "50"}}>

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