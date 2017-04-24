<?php

namespace Priotas\Behat;

use PHPUnit\Framework\TestCase;

class SlackChannelTest extends TestCase
{
    public function testInstanceWrongArgumentCount2()
    {
        if (version_compare(PHP_VERSION, '7.1.0') >= 0) {
            $this->expectException('ArgumentCountError');
            $o =  new SlackChannel();
        } else {
            $this->markTestSkipped();
        }
    }

    public function testInstanceWrongArgumentCount1()
    {
        if (version_compare(PHP_VERSION, '7.1.0') >= 0) {
            $this->expectException('ArgumentCountError');
            $o =  new SlackChannel('behat');
        } else {
            $this->markTestSkipped();
        }
    }

    public function testInstanceCorrect()
    {
        $o =  new SlackChannel('token', 'channel');
        $this->assertInstanceOf(\Priotas\Behat\SlackChannel::class, $o);
    }
}