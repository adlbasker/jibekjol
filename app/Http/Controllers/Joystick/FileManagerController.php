<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Joystick\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileManagerController extends Controller
{
    public function filemanager(Request $request, $lang)
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

        $path = $request->get('path', '/');

        // Prevent path traversal
        $path = str_replace('..', '', $path);
        $path = trim($path, '/');

        $disk = Storage::build(['driver' => 'local', 'root' => public_path('files')]);

        $directories = $disk->directories($path);
        $files = $disk->files($path);

    	return view('joystick.filemanager.index', compact('directories', 'files', 'path'));
    }

    public function frameFilemanager(Request $request, $lang)
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

        $path = $request->get('path', '/');

        // Prevent path traversal
        $path = str_replace('..', '', $path);
        $path = trim($path, '/');

        $disk = Storage::build(['driver' => 'local', 'root' => public_path('files')]);

        $directories = $disk->directories($path);
        $files = $disk->files($path);

        return view('joystick.filemanager.index-for-frame', compact('directories', 'files', 'path'));
    }

    public function filemanagerMkdir(Request $request, $lang)
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

        $path = $request->get('path', '/');
        $path = str_replace('..', '', $path);
        $newDir = $request->get('new_dir');

        if ($newDir) {
            $disk = Storage::build(['driver' => 'local', 'root' => public_path('files')]);
            $disk->makeDirectory(trim($path . '/' . $newDir, '/'));
        }

        return redirect()->back();
    }

    public function filemanagerUpload(Request $request, $lang)
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

        $path = $request->get('path', '/');
        $path = str_replace('..', '', $path);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            
            $disk = Storage::build(['driver' => 'local', 'root' => public_path('files')]);
            // storeAs usually accepts path, filename, options(disk)
            // But we can just use putFileAs since we have the disk object
            $disk->putFileAs($path, $file, $fileName);
        }

        return redirect()->back();
    }

    public function filemanagerDelete(Request $request, $lang)
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

        $path = $request->get('path', '/');
        $path = str_replace('..', '', $path);
        $item = $request->get('item');
        $itemPath = trim($path . '/' . $item, '/');

        $disk = Storage::build(['driver' => 'local', 'root' => public_path('files')]);

        if ($request->get('type') === 'dir') {
            $disk->deleteDirectory($itemPath);
        } else {
            $disk->delete($itemPath);
        }

        return redirect()->back();
    }

    public function frame()
    {
    	return view('joystick.filemanager.frame');
    }
}
