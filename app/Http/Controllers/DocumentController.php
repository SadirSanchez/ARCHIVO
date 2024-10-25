<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("Documents/index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'originDependency' => 'required|string',
            'typeDocument' => 'required|string',
            'name' => 'required|string',
            'documentNumber'=> 'required|string',
            'retentionTime' => 'required|integer',
            'dateElaboration' => 'required|date',
            'totalInventory' => 'required|string',
            'physicalLocation' => 'required|string|max:1000',
            'pdfFile' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            // Retornar los errores en formato JSON
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Código 422: Unprocessable Entity
        }

        // Crear el documento
        $document = Document::create($request->except('pdfFile'));

        if ($request->hasFile('pdfFile')) {
            $pdfPath = $request->file('pdfFile')->store('documents', 'public');
            $document->pdf_file_path = $pdfPath; // Guardamos la ruta en la base de datos
            $document->save();
        }

        // Respuesta en formato JSON
        return response()->json(['message' => 'Documento creado correctamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function getDocuments()
    {
        $documents = Document::latest()->get();

        return response() ->json($documents, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
