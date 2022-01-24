<?php
/**
 * FetchUrl Class
 *
 * Using this class can fetch the http status code of url
 */
class FetchUrl extends Thread {
    
    /**
     * UrlCaller instance
     * @type object
     * @access private
     */
    private $url_caller;
    
    public function __construct(UrlCaller $uc) {
       $this->url_caller =$uc;
    }
    
    /**
     * This method call by each worker
     * @access public
     * @return void
     */
    public function run() {
        $dbObj = DbAccess::getInstance();
        $available_job = $dbObj->getURLJob();
        if ($available_job) {
            $http_code = $this->url_caller::getUrl($available_job["url"]);
            $status = "DONE";
            if ($http_code != 200) {
                $status = "ERROR";
            }
            $dbObj->updateUrlStatus($available_job["id"], $status, $http_code);
            echo "Worker id : {$this->worker->getId()} response code : {$http_code} url : {$available_job["url"]} \n";
        }
    }

}