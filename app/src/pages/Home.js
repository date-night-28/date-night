import React from "react"
import {Button, Card} from "react-bootstrap"


export const Home = () => {
	return (
		<>
			<h1>Home</h1>

			<Button variant="primary" size="lg" block>
				Find me something to do!
			</Button>
			<Card className= "cardHome">
				<Card.Img variant="top" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAMFBMVEXJycmamprMzMzFxcWdnZ2goKCjo6PCwsLHx8e7u7unp6e4uLiwsLCtra3AwMC1tbWpnO67AAABOUlEQVR4nO3Yy46DIBiA0YJ4qb3M+7/tiLbpjMByopOcs2hI3JAv+NdwuQAAAAAAAAAAAAAAAAAAAAAAAAAAAPAPxaajd3Y+49w3DNej93Y2cQgtKUxH7+5sUhq7qmkI49GbO5s+7c7Pe1hFsQr7WN38mlVilfax5mVWrQuxSrtYcUivwS5WaX+yrinc16ElVqkY8JfJgG/5xBpvvx6IVfrE6sPz5wOxSu9YcfkbTF1ejTczq+EVK96XVqnPyyGszcQqvWJdc6sU5hgfIQ35aIlV2mJ1aRPuudr68SBWaYs1hHet7fcpVk2OlV+9HbFqlljxq7zMmsWqyCerdp0lVkW/vHG1e3ixKvo0NK7g0/a9xceteQcfHkfv7Xymxh1851wBAAAAAAAAAAAAAAAAAAAAAAAAAMAf+wbOkwdCSXzOnAAAAABJRU5ErkJggg==" />
				<Card.Body>
					<Card.Text>
						This is where small description/details of the activity will be listed. Blah blah blah something to do for you(: There’s a voice that keeps on calling me. Down the road, that’s where I’ll always be. Every stop I make, I make a new friend. Can’t stay for long, just turn around and I’m gone again. Maybe tomorrow, I’ll want to settle down, Until tomorrow, I’ll just keep moving on.
					</Card.Text>
				</Card.Body>
			</Card>


		</>
	)
}