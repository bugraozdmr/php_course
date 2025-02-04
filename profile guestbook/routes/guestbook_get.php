<?php

$messages = getMessages(pdo: db_connect());

// test cases (errors & exceptions) - works
// echo $hey;
// throw new Exception('This is a test exception');

renderView(view: 'guestbook_get', data: ['messages' => $messages]);