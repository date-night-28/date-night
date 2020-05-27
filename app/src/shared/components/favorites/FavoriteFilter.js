import React, {useEffect} from 'react'
import Jumbotron from "react-bootstrap/Jumbotron";
import {useDispatch, useSelector} from "react-redux";
import {getFavoritesByCurrentLoggedInUser} from "../../actions/favoritesAction";
import {filterActivitiesByFavorites} from "../../actions/activityAction";
import {FavoriteCard} from "./FavoriteCard";

export const FavoriteFilter = ({favorites}) => {

	// use selector to set favorites to users stored in state
	const activities = useSelector(state => state.activities ? state.activities : []);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get favorites
	const effects = () => {


		dispatch(filterActivitiesByFavorites(favorites))
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

			<main>
				<div className="card-group card-columns">
					{activities.map(activity => <FavoriteCard activity={activity} key={activity.activityId}/>)}
				</div>
			</main>


		</>
	)
}