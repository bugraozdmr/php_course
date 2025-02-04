<?php

declare(strict_types=1);

require_once './../bootstrap.php';

loadSchema(
    db_connect(),
    DB_DIR . 'schema.sql'
);