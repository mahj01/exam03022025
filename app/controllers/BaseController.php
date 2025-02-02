<?php

namespace app\controllers;

use Flight;

class BaseController
{
   
    public function render($content, $template, $title, $data = [], $message = null, $error = null)
    {
        Flight::view()->set($data);
        $content = Flight::view()->fetch($content);

        Flight::render($template, [
            'title' => $title,
            'content' => $content,
            'message' => $message,
            'error' => $error,
        ]);
    }
}
