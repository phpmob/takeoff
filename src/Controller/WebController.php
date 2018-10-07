<?php

declare(strict_types=1);

namespace Chang\Standard\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('web/index.html.twig');
    }

    public function testAction(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            return Response::create('POST!');
        }

        return Response::create('Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>Ok Test<br>');
    }
}
