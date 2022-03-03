<?php

namespace App\Scaffolding;

use JetBrains\PhpStorm\NoReturn;

class Helpers
{
    #[NoReturn] public static function dd():void {
        exit(0);
    }

    public static function logToConsole(string $content):void {
        $date = date("D M  j H:i:s Y");
        file_put_contents("php://stdout", "[$date] \033[106m[Bierwart]\033[0m $content\n");
    }
}