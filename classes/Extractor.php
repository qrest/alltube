<?php
require_once 'Match.php';

abstract class Extractor
{
    const _VALID_URL = '';
    
    static $qualities = array();
    
    abstract function extract($url);
    
    function match($regexp, $string)
    {
        return new Match($regexp, $string);
    }
    
    function _download_webpage($url, $video_id)
    {
        return file_get_contents($url);
    }
    
    function findall($regexp, $string)
    {
        preg_match_all('#'.$regexp.'#', $string, $matches);
        return $matches[1];
    }
    
    function startsWith($haystack, $needle)
    {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
    
    function endsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== false;
    }

    function _search_regex($regexp, $string)
    {
        preg_match('#'.$regexp.'#', $string, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
    }
    
    function _html_search_regex($regexp, $string)
    {
        return self::_search_regex($regexp, $string);
    }
    
    function qualities($quality_ids)
    {
        self::$qualities = $quality_ids;
        $q = function ($qid) {
            return array_search($qid, self::$qualities);
        };
        return $q;
    }
}

?>
