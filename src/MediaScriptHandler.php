<?php

use Composer\Script\CommandEvent;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler;

class MediaScriptHandler extends ScriptHandler
{
    /**
     * @param $event CommandEvent A instance
     */
    public static function initBundle(CommandEvent $event)
    {
        $options = parent::getOptions($event);
        $consoleDir = isset($options['symfony-bin-dir']) ? $options['symfony-bin-dir'] : $options['symfony-app-dir'];

        parent::executeCommand(
            $event,
            $consoleDir,
            'sulu:media:init'
        );
    }
}
