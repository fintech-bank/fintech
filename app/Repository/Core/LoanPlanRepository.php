<?php

namespace App\Repository\Core;

use App\Models\Core\LoanPlan;

class LoanPlanRepository
{
    public function call()
    {
        return LoanPlan::query();
    }
}
