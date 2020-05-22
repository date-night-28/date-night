import {combineReducers} from "redux"
import profileReducer from "./profileReducer";
import activityReducer from "./activityReducer";
import favoritesReducer from "./favoritesReducer";

export default combineReducers({

	profile: profileReducer,
	activities: activityReducer,
	favorite: favoritesReducer,

});