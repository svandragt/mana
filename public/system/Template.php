<?php
// PHP 5 - http://stackoverflow.com/questions/62617/whats-the-best-way-to-separate-php-code-and-html
class Template {
    private $args;
    private $file;

    public function __get($name) {
        return $this->args[$name];
    }

    public function __construct($file, $args = array()) {
        $this->file = $file;
        $this->args = $args;
    }

    public function render() {
        include THEME_DIR . "views" . DIRECTORY_SEPARATOR . $this->file;
    }
}
