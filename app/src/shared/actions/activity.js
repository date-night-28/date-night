import {httpConfig} from "../utils/http-config";

export const getAllActivities = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/activity/");
	dispatch({type: "GET_ALL_ACTIVITIES",payload : payload.data });
};

export const getActivityByActivityId = (id) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/activity/${id}`);
	dispatch({type: "GET_ACTIVITY_BY_ACTIVITY_ID", payload: data})
};

export const getActivityByActivityTitle = (name) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/activity/${name}`);
	dispatch({type: "GET_ACTIVITY_BY_ACTIVITY_TITLE", payload: data})
};
