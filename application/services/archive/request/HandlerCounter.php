<?php
/**
 * Archive request handler counter.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-19
 */
namespace Service\Archive\Request;

use Service\Archive\Request\Handler;

class HandlerCounter {

    /**
     * @var Hander
     */
    protected $_Handler;

    protected static $_failure = 0;

    protected static $_success = 0;

    public function __construct(Handler $Handler) {
        $this->_Handler = $Handler;
    }

    public function archive($request) {
        $result = $this->_Handler->archive($request);
        return $result;
    }
}