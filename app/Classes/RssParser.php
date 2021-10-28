<?php 

namespace App\Classes;
use App\Models\Podcast;

class RssParser 
{
    /**
     * Create a new RssParser instance.
     *
     * @return void
     */
    public function __construct() 
    {
        return "construct function was initialized.";
    }
    
    /**
     * Retrieve feed, parse the information, then call the Podcast model to save it.
     *
     * @param string $url - the url to get, parse and store.
     * 
     * @param bool $store when true, results from get and parse will be stored to the database.
     * 
     * @return bool true or string error
     */
    public function getAndParseFeed($url, $store = true)
    {
        $return = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($response === false || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return $err;                                                                        // return error
        } else {
            $return = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);     // Set data for store
            // $podcast = new Podcast();
            if ($store == true) {
                Podcast::store($url, $return);                                                  // Store information in Podcast model
            }
        }
        return true;
    }
}
