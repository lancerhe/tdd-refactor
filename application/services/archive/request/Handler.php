<?php
/**
 * Archive request handler.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive\Request;

use Service\Archive\Request\ExceptionLogger;
use Service\Archive\Request\ArchiveEntity;
use Service\Archive\Request\SourceEntity;

class Handler {

    public function __construct() {
        $this->_Model_Archive = new \Model_Archive();
        $this->_ExceptionLogger = new ExceptionLogger();
    }

    public function setLoggerFile($file) {
        $this->_ExceptionLogger->setOutputFile($file);
    }

    public function archive($row) {
        try {
            $this->create($row);
            $this->remove($row);
        } catch (\Exception $Exception) {
            $this->_ExceptionLogger->setException($Exception);
            $this->_ExceptionLogger->process();
            return false;
        }
        return true;
    }

    public function create($row) {
        $ArchiveEntity = new ArchiveEntity($row);
        $ArchiveEntity->create();
    }

    public function remove($row) {
        $SourceEntity = new SourceEntity($row);
        $SourceEntity->remove();
    }
}
