<?
if (defined('COMMENT')){ $comment = COMMENT; }
if (!empty($this->options->Show) && in_array('Comment', $this->options->Show) && defined('COMMENT')){
    $this->need($comment);
}
?>