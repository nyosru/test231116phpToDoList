<?php

session_start();

// старт
require __DIR__ . '/../vendor/autoload.php';

// тут роутер и внутри запуск контроллеров
require __DIR__ . '/../router.php';