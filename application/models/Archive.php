<?php
/**
 * Archive model.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-19
 */
class Model_Archive extends \Core\Model\Medoo {

    public function fetchRequestsBeforeCtime($ctime, $limit) {
        return $this->medoo()
            ->query("SELECT * FROM request WHERE ctime < $ctime ORDER BY ctime ASC LIMIT $limit")
            ->fetchAll(\PDO::FETCH_ASSOC);
    }
}