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

    protected $_failure = 0;

    protected $_success = 0;

    public function count($result) {
        ( $result ) ? $this->_success ++ : $this->_failure ++;
    }

    public function start() {
        $this->_success = 0;
        $this->_failure = 0;
    }

    public function close() {
        file_put_contents("/tmp/archiveresult.log", "success:{$this->_success}; failure: {$this->_failure}"  . PHP_EOL, FILE_APPEND);
    }
}