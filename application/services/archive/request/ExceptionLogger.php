<?php
/**
 * Exception Logger
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-19
 */
namespace Service\Archive\Request;

class ExceptionLogger {

    protected $_Exception;

    protected $_output_file = "/tmp/archive.log";

    public function setOutputFile($file) {
        $this->_output_file = $file;
    }

    public function setException($Exception) {
        $this->_Exception = $Exception;
    }

    public function process() {
        file_put_contents($this->_output_file, date("Y-m-d") . ":" . $this->_Exception->getMessage() . PHP_EOL, FILE_APPEND);
    }
}