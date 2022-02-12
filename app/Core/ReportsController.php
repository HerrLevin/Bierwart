<?php

namespace App\Core;

use App\Scaffolding\Response;

class ReportsController
{
    public static function generateReport() {
        $balancesRecentMonth = AccountController::parseBalances('first day of -1 month');
        $balancesThisMonth = AccountController::parseBalances('first day of this month');

        Response::json(data: [
            'lastMonth' => $balancesRecentMonth,
            'thisMonth' => $balancesThisMonth
        ]);
    }
}