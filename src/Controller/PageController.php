<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    public function contact(): Response
    {
        return $this->render('page/contact.html.twig');
    }

    public function english(): Response
    {
        return $this->render('page/english.html.twig');
    }
}
