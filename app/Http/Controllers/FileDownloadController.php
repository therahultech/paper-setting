<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public function download(Request $request, $file)
    {
        // Validate the signed URL
        if (!$request->hasValidSignature()) {
            abort(403, 'Unauthorized or expired link');
        }

        // Define the file path
        $filePath = "public/uploads/{$file}";

        // Check if the file exists
        if (!Storage::exists($filePath)) {
            abort(404, 'File not found');
        }

        // Serve the file for download
        return Storage::download($filePath);
    }
}

