import {httpConfig} from "../utils/http-config";

export const getAllActivities = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/activity/");
	dispatch({type: "GET_ALL_ACTIVITIES",payload : payload.data });
};