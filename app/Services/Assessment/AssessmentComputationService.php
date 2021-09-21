<?php

namespace App\Services\Assessment;

use App\Models;

class AssessmentComputationService
{
    /**
     * @throws \Exception
     */
    public function applyDiscount(float $subTotal = 0, ?bool $isPercentage = null, float $discountAmount = 0) : float
    {
        if (is_null($isPercentage)) return $subTotal;

        if ($isPercentage) {
            $discountAmount = ($discountAmount / 100) * $subTotal;
        }

        $grandTotal = $subTotal - $discountAmount;

        if ($grandTotal < 0) throw new \Exception('Discount amount exceeded grand total.');

        return $grandTotal;
    }

    /**
     * @throws \Exception
     */
    public function computeGrandTotal(string $additional, float $totalUnit = 0, array $fees = [], ?Models\Assessment $assessment = null) : float
    {
        if (is_null($assessment)) throw new \Exception('Assessment Not Found!');

        $runningTotal = $additional;

        foreach ($fees as $fee) {
            if (is_array($fee) && count($fee) == 2 && $fee[0] == TRUE) $runningTotal += $fee[1];
        }

        return $this->applyDiscount($runningTotal, $assessment->isPercentage, $assessment->discount_amount);
    }
}
