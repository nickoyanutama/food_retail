<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "url" => "mysql:host=localhost:3306;dbname=food_retail",
            "username" => "root",
            "password" => ""
        ],
    ];
}
