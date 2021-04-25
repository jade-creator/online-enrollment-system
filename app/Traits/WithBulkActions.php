<?php

namespace App\Traits;

trait WithBulkActions
{
    public bool $selectPage = false;
    public bool $selectAll = false;
    public array $selected = [];

    public function renderingWithBulkActions()
    {
        if ($this->selectAll) $this->pluckRows($this->rowsQuery);
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage(bool $value)
    {
        if ($value) return $this->pluckRows($this->rows);

        $this->updatedSelected();
        $this->selected = []; 
    }

    public function pluckRows($data)
    {
        $this->selected = $data->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function selectAll() { $this->selectAll = true; }

    public function isSelected(int $value) { return in_array($value, $this->selected); }
}