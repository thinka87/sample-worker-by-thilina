<?php

/**
 * UrlCaller Class
 *
 * Using this class can send a http get request and retrieve the status code without body content
 */
class UrlCaller {

    const RETURNTRANSFER = true;
    const HEADER = true;
    const FOLLOWLOCATION = true;
    const ENCODING = "";
    const AUTOREFERER = true;
    const CONNECTTIMEOUT = 120;
    const TIMEOUT = 120;
    const MAXREDIRS = 10;
    const NOBODY = true;  //ignore the body

    private static $instance = null;

    /**
     * To get a PDO instance if not exist
     * @type object
     * @access private
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UrlCaller();
        }
        return self::$instance;
    }

    /**
     * Send a http get call to given URL
     * @access public
     * @param string $url
     * return http code ,Upon failure returns exception
     * @return int|Eexception
     */
    public static function getUrl($url) {

        try {
            $ch = curl_init();
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => self::RETURNTRANSFER,
                CURLOPT_HEADER => self::HEADER,
                CURLOPT_FOLLOWLOCATION => self::FOLLOWLOCATION,
                CURLOPT_ENCODING => self::ENCODING,
                CURLOPT_AUTOREFERER => self::AUTOREFERER,
                CURLOPT_CONNECTTIMEOUT => self::CONNECTTIMEOUT,
                CURLOPT_TIMEOUT => self::TIMEOUT,
                CURLOPT_MAXREDIRS => self::MAXREDIRS,
                CURLOPT_NOBODY => self::NOBODY
            );
            curl_setopt_array($ch, $options);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $httpCode;
        } catch (Exception $e) {
            echo "Error ocurred :" . $e->getMessage();
        }
    }

}

?>