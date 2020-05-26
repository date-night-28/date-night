import {Button, Card} from "react-bootstrap";
import {getActivityByActivityId} from "../../actions/activityAction";
import React, {useEffect, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
export const FavoriteCard = ({activityId}) => {

	// use selector to set favorites to users stored in state
	const activity = useSelector(state => state.activity);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get favorites
	const effects = () => {

		dispatch(getActivityByActivityId(activityId))
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

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