// import React, {useState} from "react";
// import {Button} from "react-bootstrap";
// import {Modal} from "react-bootstrap";
// import {ProfileForm} from "./ProfileForm";
//
//
// export const ProfileModal = () => {
// 	const [show, setShow] = useState(false);
//
// 	const handleClose = () => setShow(false);
// 	const handleShow = () => setShow(true);
//
// 	return (
// 		<>
// 			<Button variant="primary" onClick={handleShow}>
// 				Profile
// 			</Button>
//
// 			<Modal show={show} onHide={handleClose}>
// 				<Modal.Header closeButton>
// 					<Modal.Title>Profile</Modal.Title>
// 				</Modal.Header>
// 				<Modal.Body>
// 					<ProfileForm/>
// 				</Modal.Body>
// 				<Modal.Footer>
// 					<Button variant="secondary" onClick={handleClose}>
// 						Close
// 					</Button>
// 					<Button variant="primary" onClick={handleClose}>
// 						Save Changes
// 					</Button>
// 				</Modal.Footer>
// 			</Modal>
// 		</>
// 	);
// }