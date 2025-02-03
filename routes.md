POST /signIn
POST /signUp

POST /party
{
	"partyID": "",
	"nextImage":"",
	"timeRemaining":""
}


POST /party/sumbit
{
	"score":"",
	"distance":"",
	"nextImage":"",
	"timeRemaining":""
}

GET /party/score
{
	"average":"",
	"score":"",
}

GET /profile
{
	"username":""
	"totalGames": 0
}

GET /history
{
	"games": [
		{
			"date":"",
			"score": 0,
			"images": [
				{
					"href":""
				},
				{
					"href":""
				},
				{
					"href":""
				}
			]
		}
	]
}

