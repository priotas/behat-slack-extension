# Installation

```composer require --dev priotas/behat-slack-extension```

# Configuration

## behat.yml

```
profile_name:
    extensions:
        Priotas\Behat\SlackExtension:
            slackToken: "xoxb-0000000000-xxxxxxxxxxxxxxxxxxxxxxxx"
            slackChannel: "XXXXXXXXX"
```

## Environment Variable

```
export BEHAT_PARAMS='{"extensions" : {"Priotas\Behat\SlackExtension:" : {"slackToken" : "xoxb-0000000000-xxxxxxxxxxxxxxxxxxxxxxxx", slackChannel: "XXXXXXXXX"}}}'
```


