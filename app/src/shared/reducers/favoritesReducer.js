export default (state = [], action) => {
	switch(action.type) {
		case "GET_FAVORITE_BY_FAVORITE_ACTIVITY_ID_AND_FAVORITE_PROFILE_ID":
			return action.payload;
		case "GET_FAVORITES_BY_CURRENT_LOGGED_IN_USER":
			return action.payload;
		case "GET_FAVORITES_BY_FAVORITE_ACTIVITY_ID":
			return action.payload;

		default:
			return state;
	}
}