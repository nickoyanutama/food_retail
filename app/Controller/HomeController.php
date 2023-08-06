<?php

namespace FoodRetail\Controller;

class HomeController
{
    public function index()
    {

        header('location: ../app/Documentation/index.php');
    }

    public function api()
    {
        header('location: ../app/Documentation/api.php');
    }
}
