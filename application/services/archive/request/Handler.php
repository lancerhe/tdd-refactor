<?php
/**
 * Archive request handler.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive\Request;

class Handler {

    protected $_create_table_sql = 'CREATE TABLE IF NOT EXISTS {table} (
    "id"  INTEGER,
    "amount"  TEXT NOT NULL ,
    "coupons" INTEGER NOT NULL ,
    "cash" INTEGER NOT NULL ,
    "request" INTEGER NOT NULL ,
    "type" INTEGER NOT NULL ,
    "production_id" INTERGE NOT NULL,
    "source_ip" TEXT NOT NULL,
    "source_name" TEXT NOT NULL,
    "ctime" INTEGER NOT NULL,
    "archive_time" INTEGER NOT NULL,
    PRIMARY KEY ("id" ASC) ON CONFLICT ROLLBACK
)';

    protected $_logger_file = "/tmp/archive.log";

    public function setLoggerFile($file) {
        $this->_logger_file = $file;
    }

    public function archive($row) {
        $this->_row = $row;
        try {
            $this->create();
        } catch (\Exception $Exception) {
            file_put_contents($this->_logger_file, date("Y-m-d") . ":" . $Exception->getMessage() . PHP_EOL, FILE_APPEND);
            return;
        }

        try {
            $this->remove();
        } catch (\Exception $Exception) {
            file_put_contents($this->_logger_file, date("Y-m-d") . ":" . $Exception->getMessage() . PHP_EOL, FILE_APPEND);
            return;
        }
    }

    public function create() {
        $Model  = new \Core\Model\Medoo();
        $sql    = str_replace('{table}', 'request_archives_' . date('Ym', $this->_row['ctime']), $this->_create_table_sql);

        if ( ! $result = $Model->medoo()->exec( $sql ) ) 
            throw new \Exception('Create table failure.');

        $result = $Model->medoo()->insert('request_archives_' . date('Ym', $this->_row['ctime']), $this->_row);

        if ( $Model->medoo()->error()[2] ) 
            throw new \Exception($Model->medoo()->error()[2]);
    }

    public function remove() {
        $Model  = new \Core\Model\Medoo();
        if ( ! $result = $Model->medoo()->exec( "DELETE FROM request WHERE id = " . $this->_row['id'] ) ) 
            throw new \Exception('Delete from table failure.');
    }
}
