import React from 'react'
import { Card, Button} from "react-bootstrap";
import Jumbotron from "react-bootstrap/Jumbotron";
export const Favorites = ({match}) => {


		return <>
			<Jumbotron fluid>
		<h1 className="text-center">Favorites</h1>
			</Jumbotron>
			<Card>
				<Card.Img style={{ width: '18rem' }} src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAMFBMVEXJycmamprMzMzFxcWdnZ2goKCjo6PCwsLHx8e7u7unp6e4uLiwsLCtra3AwMC1tbWpnO67AAABOUlEQVR4nO3Yy46DIBiA0YJ4qb3M+7/tiLbpjMByopOcs2hI3JAv+NdwuQAAAAAAAAAAAAAAAAAAAAAAAAAAAPAPxaajd3Y+49w3DNej93Y2cQgtKUxH7+5sUhq7qmkI49GbO5s+7c7Pe1hFsQr7WN38mlVilfax5mVWrQuxSrtYcUivwS5WaX+yrinc16ElVqkY8JfJgG/5xBpvvx6IVfrE6sPz5wOxSu9YcfkbTF1ejTczq+EVK96XVqnPyyGszcQqvWJdc6sU5hgfIQ35aIlV2mJ1aRPuudr68SBWaYs1hHet7fcpVk2OlV+9HbFqlljxq7zMmsWqyCerdp0lVkW/vHG1e3ixKvo0NK7g0/a9xceteQcfHkfv7Xymxh1851wBAAAAAAAAAAAAAAAAAAAAAAAAAMAf+wbOkwdCSXzOnAAAAABJRU5ErkJggg==" />

				<Card.Body>
					<Card.Title>Favorite Activity1</Card.Title>
					<Card.Text >
						etermine. Beyond rather sooner so if up wishes or.
					</Card.Text>
					<Button variant="primary">Link to activity</Button>
					<Button variant="primary">Delete Fave</Button>

				</Card.Body>
			</Card>

		<Card>
			<Card.Img variant="top" style={{ width: '18rem' }} src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAMFBMVEXJycmamprMzMzFxcWdnZ2goKCjo6PCwsLHx8e7u7unp6e4uLiwsLCtra3AwMC1tbWpnO67AAABOUlEQVR4nO3Yy46DIBiA0YJ4qb3M+7/tiLbpjMByopOcs2hI3JAv+NdwuQAAAAAAAAAAAAAAAAAAAAAAAAAAAPAPxaajd3Y+49w3DNej93Y2cQgtKUxH7+5sUhq7qmkI49GbO5s+7c7Pe1hFsQr7WN38mlVilfax5mVWrQuxSrtYcUivwS5WaX+yrinc16ElVqkY8JfJgG/5xBpvvx6IVfrE6sPz5wOxSu9YcfkbTF1ejTczq+EVK96XVqnPyyGszcQqvWJdc6sU5hgfIQ35aIlV2mJ1aRPuudr68SBWaYs1hHet7fcpVk2OlV+9HbFqlljxq7zMmsWqyCerdp0lVkW/vHG1e3ixKvo0NK7g0/a9xceteQcfHkfv7Xymxh1851wBAAAAAAAAAAAAAAAAAAAAAAAAAMAf+wbOkwdCSXzOnAAAAABJRU5ErkJggg==" />

			<Card.Body>
				<Card.Title>Favorite Activity2</Card.Title>
				<Card.Text>
					arranging of determine. Beyond rather sooner so if up wishes or.
				</Card.Text>
				<Button variant="primary">Link to activity</Button>
				<Button variant="primary">Delete Fave</Button>

			</Card.Body>
		</Card>

	</>

};