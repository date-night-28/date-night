export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_ACTIVITIES":
			return action.payload;
		case "GET_ACTIVITY_BY_ACTIVITY_ID":
			return action.payload;
		case "GET_ACTIVITY_BY_ACTIVITY_TITLE":
			return [...state, action.payload];

		default:
			return state;
	}
}