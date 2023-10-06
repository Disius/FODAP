<?php

namespace App\Http\Controllers;

use App\Models\FileFT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

class WordController extends Controller
{
    public function extractDataFromWord(Request $request)
    {
        // Recuperando el modelo
        $file = FileFT::find($request->id);
        // Ruta al documento Word
        $resultado = substr($file->path, 9, 29);


        $path = public_path('/storage/FTupload'.$resultado);

        $word = IOFactory::load($path);

        return response()->json([
            'file' => $file,
            'resultado' => $resultado,
            'path' => $path,
            'word' => $word
        ]);

    }
}
