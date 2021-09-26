<?php

namespace App\Services;

use App\Models\Fee;

class FeeService
{
    public function find(Fee $fee) : ?Fee
    {
        return Fee::where([
            'program_id' => $fee->program_id,
            'category_id' => $fee->category_id,
        ])->first();
    }

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
