<?php

declare(strict_types=1);

function renderView(string $view, array $data = []) : void
{
    // extract($data);
    include TEMPLATES_DIR . '/header.php';
    include TEMPLATES_DIR . '/' . $view . '.php';
    include TEMPLATES_DIR . '/footer.php';
}


