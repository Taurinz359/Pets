<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function preview(Request $request, Response $response, $args)
    {
        $test = __DIR__ . '/../../../SurveyForm/src/templates/survey_form.php';
        return $response;
    }
}