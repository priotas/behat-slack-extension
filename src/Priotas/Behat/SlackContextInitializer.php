<?php
namespace Priotas\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;

class SlackContextInitializer implements ContextInitializer
{
    /**
     * @var SlackChannel
     */
    protected $channel;

    /**
     * Initializes initializer.
     *
     * @param SlackChannel $channel
     */
    public function __construct(SlackChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Initializes provided context.
     *
     * @param Context $context
     */
    public function initializeContext(Context $context)
    {
        if (method_exists($context, 'setSlackChannel')) {
            $context->setSlackChannel($this->channel);
        } else {
            $context->slackChannel = $this->channel;
        }
    }
}
