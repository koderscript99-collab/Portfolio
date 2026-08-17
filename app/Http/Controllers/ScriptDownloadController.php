<?php

namespace App\Http\Controllers;

use App\Models\Script;
use Illuminate\Support\Facades\Storage;

class ScriptDownloadController extends Controller
{
    public function download(Script $script)
    {
        abort_unless($script->user_id === auth()->id(), 403);
        abort_unless($script->isReleased(), 403, 'This file has not been released yet.');

        return Storage::disk('local')->download($script->file_path, $script->title.'.zip');
    }
}