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

    public function __construct() {}

    public function archive($row) {
        $this->_row = $row;

        try {
            $this->create();
        } catch (\Exception $Exception) {
            $this->createExceptionLog(Service_Archive_CpdRequest_ExceptionLogger::TYPE_INSERT);
            return;
        }

        try {
            $this->remove();
        } catch (\Exception $Exception) {
            $this->createExceptionLog(Service_Archive_CpdRequest_ExceptionLogger::TYPE_INSERT);
            return;
        }
    }

    public function getTableName() {
        return 'request_archives_' . date('Ym', $this->_row['ctime']);
    }

    public function create() {
        $Model  = new \Core\Model\Medoo();
        $sql    = str_replace('{table}', $this->getTableName(), $this->_create_table_sql);

        if ( ! $result = $Model->medoo()->exec( $sql ) ) 
            throw new \Exception('Create table failure.');

        $result = $Model->medoo()->insert($this->getTableName(), $this->_row);

        if ( $Model->medoo()->error()[2] ) 
            throw new \Exception($Model->medoo()->error()[2]);
    }

    public function remove() {
        $Model  = new \Core\Model\Medoo();
        if ( ! $result = $Model->medoo()->exec( "DELETE FROM request WHERE id = " . $this->_row['id'] ) ) 
            throw new \Exception('delete from table failure.');
    }
}
