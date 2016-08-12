<?php

namespace Acreat\Drupal\Composer\Tools {

    use Composer\Composer;
    use Composer\IO\IOInterface;
    use Composer\Script\ScriptEvents;
    use Composer\Script\CommandEvent;
    use Composer\EventDispatcher\EventSubscriberInterface;
    use Composer\Plugin\PluginInterface;
    use Composer\Plugin\PluginEvents;

    /**
     *
     */
    class Plugin implements PluginInterface, EventSubscriberInterface {

        protected $composer;

        protected $io;

        /**
         *
         */
        public function activate(Composer $composer, IOInterface $io) {
            $this->composer = $composer;
            $this->io = $io;
        }

        /**
         *
         */
        public static function getSubscribedEvents() {
            return array(
                ScriptEvents::POST_UPDATE_CMD => array('onPostUpdateCmd', 10)
            );
        }

        /**
         *
         */
        public function onPostUpdateCmd(CommandEvent $event) {
            $drupalRoot = $this->composer->getConfig()->get('nom du param');
        }

    }

}
