<?php
require_once 'autoload.php';
class Video
{
    function __construct($url) {
        global $extractorsMap;
        $host = parse_url($url, PHP_URL_HOST);
        $extractor = new $extractorsMap[$host]($url);
        $this->webpage_url=$url;
        $info = $extractor->extract($url);
        foreach ($info as $property=>$value) {
            $this->$property = $value;
        }
        $best = 0;
        foreach ($this->formats as $format) {
            if ($format['quality'] > $best) {
                $best = $format['quality'];
            }
        }
        foreach ($this->formats as &$format) {
            $format['ext'] = pathinfo($format['url'], PATHINFO_EXTENSION);
            if ($format['quality'] == $best) {
                $this->url = $format['url'];
            }
        }
        $this->ext = pathinfo($this->url, PATHINFO_EXTENSION);
    }
}

?>
