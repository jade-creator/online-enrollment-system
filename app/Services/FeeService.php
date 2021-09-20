<?php

namespace App\Services;

use App\Models\Fee;

class FeeService
{
    public function store(Fee $fee) : Fee
    {
        $fee->save();

        return $fee;
    }

    public function update(Fee $fee) : Fee
    {
        $fee->update();

        return $fee;
    }

    /**
     * @throws \Exception
     */
    public function destroy(Fee $fee) : Fee
    {
        $fee->delete();

        return $fee;
    }
}
