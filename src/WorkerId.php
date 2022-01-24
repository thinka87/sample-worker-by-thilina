<?php

/**
 * WorkerId Class
 *
 * Using this class can generate an unique workerid
 */
class WorkerId extends Thread {

    /**
     * To store new workerid
     * @type int
     * @access private
     */
    private $workerid;

    /**
     * return a unique worker id
     * @access public
     * @return int
     */
    public function getWorkerId() {

        $this->synchronized(function () {
            ++$this->workerid;
        });
        return $this->workerid;
    }
}

?>
