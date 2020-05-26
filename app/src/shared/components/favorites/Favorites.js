import React, {useEffect} from 'react'
import { Card, Button} from "react-bootstrap";
import Jumbotron from "react-bootstrap/Jumbotron";
import {useDispatch, useSelector} from "react-redux";
import {getFavoritesByFavoriteProfileId} from "../../actions/favoritesAction";
import * as jwtDecode from "jwt-decode";
import {FavoriteCard} from "./FavoriteCard"
export const Favorites = ({match}) => {

let profileId=
	(window.localStorage.getItem("jwt-token"))
	?
	jwtDecode(window.localStorage.getItem("jwt-token"))
		.auth.profileId
			:
			""


	// use selector to set favorites to users stored in state
	const favorites = useSelector(state => state.favorites);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get favorites
	const effects = () => {

		dispatch(getFavoritesByFavoriteProfileId(profileId))
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);


	return (
		<>
		<Jumbotron fluid>
		<h1 className="text-center">Favorites</h1>
			</Jumbotron>

			<main className="container">
				<div className="card-group card-columns">
					{favorites.map(favorite => <FavoriteCard activityId={favorite.favoriteActivityId} key={favorite.favoriteActivityId}/>)}
				</div>
			</main>


	</>
	)
};