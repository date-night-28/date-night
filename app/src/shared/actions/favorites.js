import {httpConfig} from "../utils/http-config";


export const getFavoriteByFavoriteActivityIdAndFavoriteProfileId = (favoriteProfileId, favoriteActivityId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/favorite/?favoriteActivityId=${favoriteActivityId} &favoriteProfileId=${favoriteProfileId}`);
	dispatch({type: "GET_FAVORITE_BY_FAVORITE_ACTIVITY_ID_AND_FAVORITE_PROFILE_ID", payload: data})
};

export const getFavoritesByFavoriteProfileId = (favoriteProfileId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/favorite/?favoriteProfileId=${favoriteProfileId}`);
	dispatch({type: "GET_FAVORITES_BY_FAVORITE_PROFILE_ID", payload: data})
};

export const getFavoritesByFavoriteActivityId = (favoriteActivityId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/favorite/?favoriteActivityId=${favoriteActivityId}`);
	dispatch({type: "GET_FAVORITES_BY_FAVORITE_ACTIVITY_ID", payload: data})
};