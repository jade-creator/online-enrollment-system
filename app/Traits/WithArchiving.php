<?php

namespace App\Traits;

use App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait WithArchiving
{
    protected $modelsPath = "Models\\";
    public string $isArchived = '0';

    /**
     * @throws \Exception
     */
    public function hasArchiveColumn(string $column)
    {
        $validColumns = ['archived_at', 'released_at'];

        if (! in_array($column, $validColumns)) throw new \Exception('Archiving feature is not yet allowed!');
    }

    public function getModelClass(string $modelName) { return
        app("App\Models\\$modelName");
    }

    public function updateModel(string $modelClass, $model, string $column, $value = NULL)
    {
        $modelClass = $this->getModelClass($modelClass);
        return $modelClass::where('id', $model['id'])->update([
            $column => $value
        ]);
    }

    public function updateModels(string $modelClass, string $column, $value = NULL)
    {
        $modelClass = $this->getModelClass($modelClass);
        return $modelClass::whereIn('id', $this->selected)->update([$column => $value]);
    }

    public function archivingQuery($query, string $column)
    {
        return $query->when($this->isArchived == '1', function ($query) use ($column) {
                $query->whereNotNull($column);
            })
            ->when($this->isArchived == '0', function ($query) use ($column) {
                $query->whereNull($column);
            });
    }

    public function archive(string $modelClass, $model, string $column)
    {
        try {
            $this->hasArchiveColumn($column);
            $this->updateModel($modelClass, $model, $column, now());

            session()->flash('alert', [
                'type' => 'success',
                'message' => $modelClass.' has been archived.',
            ]);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }

        return $this->emit('alert');
    }

    public function unarchive(string $modelClass, $model, string $column)
    {
        try {
            $this->hasArchiveColumn($column);
            $this->updateModel($modelClass, $model, $column);

            session()->flash('alert', [
                'type' => 'success',
                'message' => $modelClass.' has been unarchived.',
            ]);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }

        return $this->emit('alert');
    }

    public function unarchiveAll(string $modelClass, string $column)
    {
        try {
            $this->hasArchiveColumn($column);
            $this->updateModels($modelClass, $column);

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'All records are unarchived.',
            ]);

        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }

        $this->emitSelf('DeselectPage', FALSE);
    }

    public function archiveAll(string $modelClass, string $column)
    {
        try {
            $this->hasArchiveColumn($column);
            $this->updateModels($modelClass, $column, now());

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'All records are archived.',
            ]);

        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }

        $this->emitSelf('DeselectPage', FALSE);
    }

    public function updatingIsArchived()
    {
        $this->resetPage();
        $this->emitSelf('DeselectPage', FALSE);
    }
}
