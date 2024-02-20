<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function store(Request $request)
    {

        return $request->file('imagenes');
        if($request->hasFile('imagenes'))
        {
            $file = $request->file('imagenes');
            $filename = $file->getClientOriginalName();
            $foldername = uniqid() . "-". now()->timestamp;
            $file->store('public/productos/tmp/' .$foldername. $filename);

            TemporaryFile::create([
                'folder' => $foldername,
                'filename' => $filename
            ]);

            return $foldername;
        }
    }
}
