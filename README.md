[![Build Status](https://travis-ci.org/priotas/behat-slack-extension.svg?branch=master)](https://travis-ci.org/priotas/behat-slack-extension)

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


