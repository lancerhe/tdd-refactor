<?php
/**
 * Archive request handler.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive\Request;

class Handler {

    protected $_logger_file = "/tmp/archive.log";

    public function setLoggerFile($file) {
        $this->_logger_file = $file;
    }

    public function writeExceptionLog($message) {
        file_put_contents($this->_logger_file, date("Y-m-d") . ":" . $message . PHP_EOL, FILE_APPEND);
    }

    public function archive($row) {
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
        $Model = new \Model_Archive();
        $Model->createTableIfNotExist($this->buildTableName());
        $Model->insert($this->buildTableName(), $this->_row);
    }

    public function remove() {
        $Model  = new \Core\Model\Medoo();
        if ( ! $result = $Model->medoo()->exec( "DELETE FROM request WHERE id = " . $this->_row['id'] ) ) 
            throw new \Exception('Delete from table failure.');
    }
}
