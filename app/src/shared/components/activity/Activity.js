import React from "react"
import {Button, Card, Container} from "react-bootstrap";
import dateLogo from "./image.png"
import {httpConfig} from "../../utils/http-config";
import {useHistory} from "react-router";

export const Activity = ({activities}) => {
	let activity = activities[Math.round(Math.random() * activities.length - 1)]

	const history=useHistory();
	const submit = () => {
		history.push("/")
	}

	const clickedFavorite = () => {
		const headers = {
			'X-JWT-TOKEN': window.localStorage.getItem("jwt-token"),
		};
		httpConfig.post("apis/favorite/", {"favoriteActivityId": activity.activityId}, {
			headers: headers
		})
			.then(reply => {
				let {message, type} = reply;
				// setStatus({message, type});
				if(reply.status === 200) {
					alert("Added to Favorites")
				} else {
					console.log("didn't work")
				};
			});
	};

	return (
		<>
			<div className="row d-flex justify-content-center">
			<img src={dateLogo} alt="date night" />
			</div>
			<div>
			<h1 className="text-center bg-dark text-white">{activity.activityTitle}</h1>
			</div>
			<div className="row d-flex justify-content-center">
			<Card style={{width: '50rem'}}>
				<Card.Img variant="top" src={activity.activityImageUrl} />
				<Card.Body>
					<button className="btn btn-outline-danger" type="submit" onClick={submit}>
						Find me something to do!
					</button>
					<Button onClick={clickedFavorite} variant="danger">
						Favorite
					</Button>
					<Card.Link href={activity.activityLink} target="_blank">Click here to View Activity details.</Card.Link>
				</Card.Body>
			</Card>
		</div>
		</>
	)
}