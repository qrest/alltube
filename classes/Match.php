<?php

class Match
{
    function __construct($regexp, $string) {
        preg_match('#'.$regexp.'#', $string, $this->matches);
    }
    
    function group($group) {
        return $this->matches[$group];
    }
}
?>
