<?php

namespace controller;

class twig
{

    public $twig;

    function __CONSTRUCT()
    {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');
    $this->twig = new \Twig\Environment($loader, [
        //'cache' => __DIR__.'/../templates_cache',
        ]);
    }
}