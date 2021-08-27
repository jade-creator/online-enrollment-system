<?php

namespace App\Traits;

trait WithSweetAlert
{
    public string $errorTitle = "Error!", $warningTitle = "Warning!", $successTitle = "Success!";
    public string $errorType = "error", $warningType = "warning", $successType = "success";

    public function modal(string $title, string $type, string $text)
    {
        return $this->dispatchBrowserEvent('swal:modal', [
            'title' => $title,
            'type' => $type,
            'text' => $text,
        ]);
    }

    public function error(string $text) { return
        $this->modal($this->errorTitle, $this->errorType, $text);
    }

    public function warning(string $text) { return
        $this->modal($this->warningTitle, $this->warningType, $text);
    }

    public function success(string $text) { return
        $this->modal($this->successTitle, $this->successType, $text);
    }

    public function confirmDelete(string $method, object $item, string $text)
    {
        return $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => $this->warningType,
            'title' => $this->warningTitle,
            'method' => $method,
            'text' => 'Deleting '.$text.' cannot be retrievable.',
            'item' => $item,
        ]);
    }
}
