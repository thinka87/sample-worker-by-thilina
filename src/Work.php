<?php
/**
 * Work Class
 *
 * Create a work object extending PHP Worker class
 */
class Work extends Worker {

    private $id;
    //Get a uniquer worker ID
    public function __construct(WorkerId $obj) {
        $this->id = $obj->getWorkerId();
    }
    
    /**
     * return an unique worker id
     * @access public
     * @return int
     */
    public function getId() {
        return $this->id;
    }

}

