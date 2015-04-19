<?php
/**
 * Archive model.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-19
 */
class Model_Archive extends \Core\Model\Medoo {

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

    public function fetchRequestsBeforeCtime($ctime, $limit) {
        return $this->medoo()
            ->query("SELECT * FROM request WHERE ctime < $ctime ORDER BY ctime ASC LIMIT $limit")
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createTableIfNotExist($table) {
        $sql = str_replace('{table}', $table , $this->_create_table_sql);

        if ( ! $result = $this->medoo()->exec($sql) ) 
            throw new \Exception('Create table failure.');
    }
}