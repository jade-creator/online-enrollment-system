<?php

namespace App\Http\Livewire\Partials;

use App\Models\File;
use App\Models\User;
use App\Services\FileService;
use App\Traits\WithSweetAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploadComponent extends Component
{
    use WithFileUploads, WithSweetAlert;

    public User $user;
    public $files = [];

    protected $listeners = ['removeFile'];

    public function render() { return
        view('livewire.partials.file-upload-component');
    }

    public function download(File $file)
    {
        try {
            return response()->download(storage_path('app/public/files/' . $file->hashed_name));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function removeConfirm(File $file) { return
        $this->confirm('removeFile', 'Are you sure you want this deleted?', $file);
    }

    public function removeFile(File $file)
    {
        try {
            (new FileService())->destroy($file);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => $file->file_name.' has been deleted.',
            ]);
            return redirect(route('user.personal.profile.view', $this->user->id));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function save()
    {
        $this->validate([
            'files.*' => 'required|max:1024|mimes:jpg,png,pdf,docx,csv,txt',
        ]);

        try {
            (new FileService())->store($this->user, $this->files);

            session()->flash('swal:modal', [
                'title' => $this->successTitle,
                'type' => $this->successType,
                'text' => 'File has been uploaded.',
            ]);
            return redirect(route('user.personal.profile.view', $this->user->id));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
