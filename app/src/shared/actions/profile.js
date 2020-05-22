import {httpConfig} from "../utils/http-config";

export const getProfileByProfileName = () => async dispatch => {
	const {data} = await httpConfig('apis/profile/');
	dispatch({type: "GET_PROFILE_BY_NAME", payload: data })
};

export const getProfileByProfileId = (id) => async dispatch => {
	const {data} = await httpConfig('apis/profile/${id}');
	dispatch({type: "GET_PROFILE_BY_PROFILE_ID", payload: data })
};

export const getProfileByProfileEmail = (email) => async dispatch => {
	const {data} = await httpConfig('apis/profile/?userEmail=${email}');
	dispatch({type: "GET_PROFILE_BY_PROFILE_EMAIL", payload: data })
};