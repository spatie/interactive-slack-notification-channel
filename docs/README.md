# Create and setup Slack app

1. [Create a new slack app](https://api.slack.com/apps?new_app=1).
2. Install the app the following permissions/scopes are required (please select them on OAuth & Permissions page):
   1. [`chat:write:bot`](https://api.slack.com/scopes/chat:write:bot) (or simply `chat:write`)
3. Copy your User OAuth key on `https://api.slack.com/apps/{ID}/oauth`, where `{ID}` is your app ID (e.g. `A93T619JE`)
