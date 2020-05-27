export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_ACTIVITIES":
			return action.payload;
		case "GET_ACTIVITY_BY_ACTIVITY_ID":
			return [...state, action.payload];
		case "GET_ACTIVITY_BY_ACTIVITY_TITLE":
			return [...state, action.payload];
		case "FILTER_ACTIVITIES_BY_FAVORITES":
			let favoriteActivities=[]
			action.payload.forEach(favorite=>{

				favoriteActivities=[...favoriteActivities, ...state.filter(activity=>activity.activityId===favorite.favoriteActivityId)]
			})

			return favoriteActivities

		default:
			return state;
	}
}