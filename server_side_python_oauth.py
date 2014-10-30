flow = OAuth2WebServerFlow(
	client_id = '191668664245-2elcebkqrt3bve8eoj0jq7vfqn1istkt.apps.googleusercontent.com',
	client_secret = '2jGQmUbYVHbZyAeS-l0gbb10',
	scope = 'https://googleapis.com/auth/calendar'
)

callback = self.relative_url('/oasuth2callback')
authorize_url = flow.step1_get_authorize_url(callback)
self.redirect(authorize_url)

credentials = flow.step2_exchange(self.request.params)
print 'Access token %s' % credentials.access_token
print 'Refresh token %s' % credentials.refresh_token

#Store refresh token in database with user information

#Calling the API (for tasks...not calendar)
#Using HTTP Header
GET /tasks/v1/lists/@default/tasks HTTP/1.1
Host: www.googleapis.com
Authorization: Bearer <access token>

#Using a Query Parameter
GET /tasks/v1/lists/@default/task?access_token=<access token> HTTP/1.1
Host: www.googleapis.com
