<?php

namespace App\Core;

use App\Scaffolding\DB;

class BeverageController
{
    public static function getDrinksOverview() {
        $db = new DB();
        $db->query("SELECT bev.id, bev.name, bev.size, type.price FROM beverage bev INNER JOIN drink_type type ON bev.id_drink_type = type.id");
        return $db->get();
    }

    public static function createBeverageMovement() {
        $db = new DB();
        $db->query("SELECT bev.id, bev.name, bev.size, type.price FROM beverage bev INNER JOIN drink_type type ON bev.id_drink_type = type.id");
        return $db->get();
    }
}