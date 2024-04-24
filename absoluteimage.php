<?php
// Absoluteimage extension, experimental

class YellowAbsoluteimage {
    const VERSION = "0.9.1";
    public $yellow;         //access to API

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    
    // Handle page content in HTML format
    public function onParseContentHtml($page, $text) {
        $output = null;
        if (!preg_match("/draft/i", $page->get("status"))) {
            $scheme = $this->yellow->system->get("coreServerScheme");
            $address = $this->yellow->system->get("coreServerAddress");            
                $callback = function ($matches) use ($thisCompatible, $scheme, $address) {
                    $url = $matches[1];
                    $url = $this->yellow->lookup->normaliseUrl($scheme, $address, $matches[1], false);
                    return "<img src=\"$url\""; // HTML-Tag für das Bild mit absoluter URL
                };
                $output = preg_replace_callback("/<img src=\"(.*?)\"/i", $callback, $text);
            }
        return $output;
    }
}