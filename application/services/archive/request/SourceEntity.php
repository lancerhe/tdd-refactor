<?php
/**
 * Source archive entity.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-19
 */
namespace Service\Archive\Request;

class SourceEntity {

    public function __construct($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
        $this->_row = $row;
    }

    public function remove() {
        $Model_Archive = new \Model_Archive();
        $Model_Archive->removeById($this->_row['id']);
    }
}