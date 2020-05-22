// import React from 'react';
// import {httpConfig} from "../../../utils/http-config";
// import {Formik} from "formik/dist/index";
// import * as Yup from "yup";
// import {ProfileFormContent} from "./ProfileFormContent";
//
//
// export const ProfileForm = () => {
// 	const validator = Yup.object().shape({
// 		profileEmail: Yup.string()
// 			.email("email must be a valid email")
// 			.required('email is required'),
// 		profileName: Yup.string()
// 			.required("Password is required")
// 			.min(8, "Password must be at least eight characters")
// 	});
//
//
// 	// //the initial values object defines what the request payload is.
// 	// const signIn = {
// 	// 	profileEmail: "",
// 	// 	profileName: ""
// 	// };
// 	//
// 	// const submitSignIn = (values, {resetForm, setStatus}) => {
// 	// 	httpConfig.post("/apis/profile/", values)
// 	// 		.then(reply => {
// 	// 			let {message, type} = reply;
// 	// 			setStatus({message, type});
// 	// 			if(reply.status === 200 && reply.headers["x-jwt-token"]) {
// 	// 				window.localStorage.removeItem("jwt-token");
// 	// 				window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
// 	// 				resetForm();
// 	// 			}
// 	// 		});
// 	// };
// //
// // 	return (
// // 		<>
// // 			<Formik
// // 				initialValues={signIn}
// // 				onSubmit={submitSignIn}
// // 				validationSchema={validator}
// // 			>
// // 				{ProfileFormContent}
// // 			</Formik>
// // 		</>
// // 	)
// };