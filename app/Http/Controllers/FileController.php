<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Download a file
     *
     * @param File $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(File $file)
    {
        return response()->download(storage_path('app/' . $file->path));
    }

    /**
     * Display the contents of a file
     *
     * @param File $file
     * @return bool|string
     */
    public function show(File $file)
    {
        return $file->contents();
    }
}
