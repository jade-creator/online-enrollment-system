<?php

namespace App\Traits;

trait WithSweetAlert
{
    public string $errorTitle = "Error!", $warningTitle = "Warning!", $successTitle = "Success!", $infoTitle = 'Notice!';
    public string $errorType = "error", $warningType = "warning", $successType = "success", $infoType = 'info';

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

    public function info(string $text) { return
        $this->modal($this->infoTitle, $this->infoType, $text);
    }

    public function confirm(string $method, string $text, object $item = null)
    {
        return $this->dispatchBrowserEvent('swal:confirm', [
            'type' => $this->warningType,
            'title' => $this->warningTitle,
            'method' => $method,
            'text' => $text,
            'item' => $item,
        ]);
    }

    public function confirmDelete(string $method, object $item, string $text) //TODO: replace it with confirm method.
    {
        return $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => $this->warningType,
            'title' => $this->warningTitle,
            'method' => $method,
            'text' => 'Deleting '.$text.' cannot be retrievable.',
            'item' => $item,
        ]);
    }

    public function sessionFlashAlert(string $flash = 'alert', string $type = '', string $message = '', bool $fade = TRUE)
    {
        session()->flash( $flash, [
            'type' => $type,
            'message' => $message,
        ]);

        if ($fade) $this->emit('alert');
    }
}
