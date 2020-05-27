import {httpConfig} from "../utils/http-config";


export const getFavoriteByFavoriteActivityIdAndFavoriteProfileId = (favoriteProfileId, favoriteActivityId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/favorite/?favoriteActivityId=${favoriteActivityId} &favoriteProfileId=${favoriteProfileId}`);
	dispatch({type: "GET_FAVORITE_BY_FAVORITE_ACTIVITY_ID_AND_FAVORITE_PROFILE_ID", payload: data})
};

export const getFavoritesByCurrentLoggedInUser = () => async (dispatch) => {
	const {data} = await httpConfig(`/apis/favorite/`);
	dispatch({type: "GET_FAVORITES_BY_CURRENT_LOGGED_IN_USER", payload: data})
};

export const getFavoritesByFavoriteActivityId = (favoriteActivityId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/favorite/?favoriteActivityId=${favoriteActivityId}`);
	dispatch({type: "GET_FAVORITES_BY_FAVORITE_ACTIVITY_ID", payload: data})
};