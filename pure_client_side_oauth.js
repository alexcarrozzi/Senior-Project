	gapi.auth.authorize({
		client_id: '191668664245-2elcebkqrt3bve8eoj0jq7vfqn1istkt.apps.googleusercontent.com',
		scope: 'https://googleapis.com/auth/calendar'
		},
		handleAuthResultPopup()
	);
	
	function handleAuthResultPopup(){
		alert(gapi.auth.getToken());
	}
