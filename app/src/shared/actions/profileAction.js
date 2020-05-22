import {httpConfig} from "../utils/http-config";

export const getProfileByProfileName = (profileName) => async dispatch => {
	const {data} = await httpConfig(`apis/profile/?profileName=${profileName}`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_NAME", payload: data })
};

export const getProfileByProfileId = (id) => async dispatch => {
	const {data} = await httpConfig(`apis/profile/${id}`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_ID", payload: data })
};

export const getProfileByProfileEmail = (profileEmail) => async dispatch => {
	const {data} = await httpConfig(`apis/profile/?profileEmail=${profileEmail}`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_EMAIL", payload: data })
};