<?php

if (! defined('BASE_DIR')) {
    exit('No direct script access allowed');
}
printf("<div class='%s %s'>", $this->controller, $this->model);

switch (count((array)$this->contents)) {
    case 0:
        // no content - new installation
        printf(
            "<p> Please <a href='%s'>add content</a> to <code>%s</code>.</p>",
            href('/admin/new'),
            'whatever'
        );
        break;

    default:
        $include = __DIR__ . DIRECTORY_SEPARATOR . $this->controller . ".php";
        include $include;
        break;
}

print( "</div>" );
