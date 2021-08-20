<?php

namespace App\Traits;

trait WithSorting
{
    public string $sortBy = 'created_at', $sortDirection = 'desc';

    public function isAllowedSorts(string $field): bool
    {
        return in_array($field, $this->allowedSorts);
    }

    public function sortFieldSelected(string $field): void
    {
        $this->sortBy = $this->isAllowedSorts($field) ? $field : 'created_at';

        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'desc';

        $this->resetPage();
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'desc'
            ? 'asc'
            : 'desc';
    }
}
