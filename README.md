[![Build Status](https://travis-ci.org/priotas/behat-slack-extension.svg?branch=master)](https://travis-ci.org/priotas/behat-slack-extension)

# Installation

```composer require --dev priotas/behat-slack-extension```

# Configuration

## behat.yml

```BASH
profile_name:
    extensions:
        Priotas\Behat\SlackExtension:
            slackToken: "xoxb-0000000000-xxxxxxxxxxxxxxxxxxxxxxxx"
            slackChannel: "XXXXXXXXX"
```

## Environment Variable

```BASH
export BEHAT_PARAMS='{"extensions" : {"Priotas\Behat\SlackExtension:" : {"slackToken" : "xoxb-0000000000-xxxxxxxxxxxxxxxxxxxxxxxx", slackChannel: "XXXXXXXXX"}}}'
```

# Usage

```PHP
/**
 * @AfterStep
 */
public function takeScreenshotAfterFailedStep(Behat\Behat\Hook\Scope\AfterStepScope $scope)
{
    /** Behat\Behat\Tester\Result\StepResult $result */
    $result = $scope->getTestResult();
    if (!$result->isPassed()) {

        $driver = $this->getSession()->getDriver();
        if ($driver instanceof \Behat\Mink\Driver\Selenium2Driver) {
            $driver->resizeWindow(1024, 768);

            $featureName = basename($scope->getFeature()->getFile(), '.feature');
            $stepText = $featureName . '.' . $this->scenarioName . '.' . $scope->getStep()->getText();
            $fileTitle = 'behat_screenshot_' . preg_replace("#[^a-zA-Z0-9\._-]#", '', $stepText);
            $fileName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileTitle . '.png';
            $screenshot = $driver->getScreenshot();
            file_put_contents($fileName, $screenshot);

            print "Screenshot for '{$stepText}' placed in {$fileName}\n";

            if (isset($this->slackChannel)) {
                print "Uploading Screenshot to Slack...\n";
                $this->slackChannel->upload($fileName, $fileTitle, $stepText);
            }
        }
    }
}
```
