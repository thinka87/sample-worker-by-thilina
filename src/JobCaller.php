<?php
/**
 * JobCaller Class
 *
 * Using this class can execute all jobs via workers creating a workers pool
 */
class JobCaller {

     /**
     * Create a workers pool and run tasks
     * @access public
     * @param int $num_of_workers
     * @return void
     */
    public static function executeJobs($num_of_workers) {
        //create workers pool and dynamically load workers instance
        $pool = new Pool($num_of_workers, 'Work', [new WorkerId()]);

        $dbObj = DbAccess::getInstance();   //Get db access instance
        $urlCaller= UrlCaller::getInstance(); //Get UrlCaller instance to pass into FetchUrl class
        //$dbObj->resetAll();  //for testing
        $available_jobs = $dbObj->getAvailableJobCount(); //get available job count
        
        if($available_jobs == 0){
            echo "New Jobs not found";
            return;
        }
        
        //Create worker pool and  assign task to workers
        for ($i = 1; $i <= $available_jobs; $i++) {
            $pool->submit(new FetchUrl($urlCaller));
        }
        while ($pool->collect());
        $pool->shutdown();
    }

}
