<?php
/**
 * Archive request handler.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive\Request;

use Service\Archive\Request\ExceptionLogger;
class Handler {

    protected $_logger_file = "/tmp/archive.log";

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
        $ArchiveEntity = new \Service\Archive\Request\ArchiveEntity($row);
        $ArchiveEntity->create();
    }

    public function remove($row) {
        $SourceEntity = new \Service\Archive\Request\SourceEntity($row);
        $SourceEntity->remove();
    }
}
