<?php
/**
 * Archive request handler.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive\Request;

class Handler {

    protected $_logger_file = "/tmp/archive.log";

    public function __construct() {
        $this->_Model_Archive = new \Model_Archive();
    }

    public function setLoggerFile($file) {
        $this->_logger_file = $file;
    }

    public function writeExceptionLog($message) {
        file_put_contents($this->_logger_file, date("Y-m-d") . ":" . $message . PHP_EOL, FILE_APPEND);
    }

    public function archive($row) {
        try {
            $this->create($row);
            $this->remove($row);
        } catch (\Exception $Exception) {
            $this->writeExceptionLog( $Exception->getMessage() );
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
