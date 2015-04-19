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
        $row['archive_time'] = time();
        $this->_row = $row;
        try {
            $this->create();
        } catch (\Exception $Exception) {
            $this->writeExceptionLog( $Exception->getMessage() );
            return false;
        }

        try {
            $this->remove();
        } catch (\Exception $Exception) {
            $this->writeExceptionLog( $Exception->getMessage() );
            return false;
        }
        return true;
    }

    public function buildTableName() {
        return 'request_archives_' . date('Ym', $this->_row['ctime']);
    }

    public function create() {
        $ArchiveEntity = new \Service\Archive\Request\ArchiveEntity($this->_row);
        $ArchiveEntity->create();
    }

    public function remove() {
        $this->_Model_Archive->removeById($this->_row['id']);
    }
}
