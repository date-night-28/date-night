import {combineReducers} from "redux"
import activityReducer from "./avtivityReducer";

export const combinedReducers = combineReducers({

	activity: activityReducer,
});