<?php

function addFlashMessage(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}

function getFlashMessages(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}