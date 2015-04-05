<?php
/**
 * Archive main, run in cli.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
class Controller_Archive extends \Core\Controller {

    /**
     * Disable render in cli.
     */
    public function init() {
        \Yaf\Dispatcher::getInstance()->disableView();
    }

    /**
     * Archive request from database to anthor.
     */
    public function RequestAction() {
        $Archive = new \Service\Archive\Request();
        $Archive->setLimit(10000);
        $Archive->setPassDays(40);
        $Archive->archive();
    }
}