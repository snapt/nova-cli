<?php

return [
    'key' => trim(@file_get_contents(getenv("HOME") . '/.nova-api-key')),
];
