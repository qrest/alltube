<?php
class UnistraIE extends Extractor
{
    const _VALID_URL = 'http://utv\.unistra\.fr/(?:index|video)\.php\?id_video\=(?P<id>\d+)';

    function extract($url)
    {
        $mobj = self::match(self::_VALID_URL, $url);
        $video_id = $mobj->group('id');
        $webpage = self::_download_webpage($url, $video_id);
        $files = self::findall('file\s*:\s*"([^"]+)"', $webpage);
        $quality = self::qualities(array('SD', 'HD'));
        $formats = array();
        
        foreach ($files as $file_path) {
            $format_id = self::endsWith($file_path, '-HD.mp4') ? 'HD' : 'SD';
            $formats[$format_id] = array(
                'url'=>'http://vod-flash.u-strasbg.fr:8080'.$file_path,
                'format_id'=>$format_id,
                'quality'=>$quality($format_id)
            );
        }
        $title = utf8_encode(self::_html_search_regex('<title>UTV - (.*?)</', $webpage, 'title'));
        $description = utf8_encode(self::_html_search_regex('<meta name="Description" content="(.*?)"', $webpage, 'description'));
        $thumbnail = self::_search_regex('image: "(.*?)"', $webpage, 'thumbnail');
        
        return array(
            'id'=>$video_id,
            'title'=>$title,
            'description'=>$description,
            'thumbnail'=>$thumbnail,
            'formats'=>$formats
        );
    }
}

?>
