<?php
/**
 * Archive request service.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive;

use Service\Archive\Request\Handler;
use Service\Archive\Request\HandlerCounter;

class Request {

    protected $_limit = 0;

    protected $_archive_time = 0;

    protected $_success = 0;

    protected $_failure = 0;
    
    public function setLimit($limit) {
        $this->_limit = $limit;
    }

    public function setPassDays($days) {
        $this->_archive_time = (time() - 86400 * $days);
    }

    public function archive() {
        $requests = ( new \Model_Archive() )->fetchRequestsBeforeCtime($this->_archive_time, $this->_limit);

        foreach ($requests as $request) {
            $Handler = new Handler();
            $Handler = new HandlerCounter($Handler);
            $result = $Handler->archive($request);
            if ( $result ) 
                $this->_success ++ ;
            else
                $this->_failure ++ ;
        }

        file_put_contents("/tmp/archiveresult.log", "success:{$this->_success}; failure: {$this->_failure}"  . PHP_EOL, FILE_APPEND);
    }
}