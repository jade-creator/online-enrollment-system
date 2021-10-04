<?php

namespace App\Services;

use App\Models\File;
use App\Models\User;

class FileService
{
    public function store(User $user, array $files) : array
    {
        if (! empty($files)) {
            foreach ($files as $file) {
                $file->store('public/files');

                $user->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'hashed_name' => $file->hashName(),
                ]);
            }
        }

        return $files;
    }

    public function destroy(File $file) : File
    {
        $file->delete();

        return $file;
    }
}
