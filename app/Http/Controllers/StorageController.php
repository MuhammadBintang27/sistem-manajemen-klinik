<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageController extends Controller
{
    /**
     * Serve private files (authenticated only)
     */
    public function privateFile(Request $request): StreamedResponse
    {
        $path = $request->query('path');

        if (!$path) {
            abort(404);
        }

        // Ensure user is authenticated
        if (!auth()->check()) {
            abort(401);
        }

        // Validate path doesn't contain ../ or other directory traversal attempts
        if (strpos($path, '..') !== false || strpos($path, './') === 0) {
            abort(403);
        }

        // Check if file exists
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }
}
