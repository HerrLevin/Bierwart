<?php

namespace App\Core;

use App\Adapters\Response;

class ReportsController
{
    public static function generateReport() {
        $balancesRecentMonth = AccountController::parseBalances('first day of -1 month');
        $balancesThisMonth = AccountController::parseBalances('first day of this month');

        $suff = AccountController::parseDrinksForAccounts("first day of this month",
            "first day of -1 month");

        Response::json(data: [
            'lastMonth' => $balancesRecentMonth,
            'thisMonth' => $balancesThisMonth,
            'gesoffen'  => $suff
        ]);
    }
}