import {useState, useEffect} from "react";
import * as jwtDecode from "jwt-decode";

export const UseJwt = () => {

	const [jwt, setJwt] = useState(null);

	useEffect(() => {
		setJwt(window.localStorage.getItem("jwt-token"));
	}, []);
	return jwt;
};


export const UseJwtProfileId = () => {
	const[profileId, setProfileId] = useState(null);

	useEffect(() => {
		const token = window.localStorage.getItem("jwt-token");
		if(token !== null) {
			const decodeJwt = jwtDecode(token);
			setProfileId(decodeJwt.auth.profileId);
		}
	}, []);
	return profileId;
};
