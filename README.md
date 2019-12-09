## Twitter App

> 🔥 Twitter web client made out of hobby. NOTE: under development.


It is Laravel Mix web application that uses Twitter API. 

Using [atymic/twitter](https://github.com/atymic/twitter) for handling Twitter API.


###Setup

- Register your application at https://developer.twitter.com/apps
- Set callback url for your Twitter app to lead to your callback function from TwitterController (i.e. http://twitter-app.test/callback)
- After registering application, put your credentials in `.env`

```
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=
```

Make sure you install all assets

```
npm install
```

and build app

```
npm run dev
```

###Log

Things that are done so far:
- login (oauth)
- displaying home timeline for authenticated user
- popover for profile when hovering username
- some processing tweet data

Things to be done:
- handling quoted tweet
- handling media
- handling tweets and replies
- profile

After this, eventually features like posting tweets and sending DMs are to be tackled.
