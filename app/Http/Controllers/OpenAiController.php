<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpenAiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function corregirRespuesta(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        // Validar los datos de entrada
        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*.pregunta' => 'required|string',
            'respuestas.*.puntuacion' => 'required|integer|min:0',
        ]);

        // Obtener la rúbrica
        $rubrica = Rubrica::findOrFail($id);

        // Leer las respuestas del alumno
        $respuestas = $request->respuestas;

        // Crear un prompt para OpenAI con las respuestas del alumno
        $prompt = "A continuación te proporciono las respuestas de un alumno a una rúbrica. Por favor, corrígelas y proporciona una puntuación del 1 al 10, así como comentarios y detalles de la corrección:\n\n";
        foreach ($respuestas as $index => $respuesta) {
            $prompt .= "Pregunta: " . $rubrica->preguntas[$index]['pregunta'] . "\n";
            $prompt .= "Respuesta del alumno: " . $respuesta['pregunta'] . "\n";
            $prompt .= "Puntuación del alumno: " . $respuesta['puntuacion'] . "\n\n";
        }

        // Crear cliente de OpenAI
        $client = Client::create(env('OPENAI_API_KEY'));

        try {
            // Realizar solicitud a la API de OpenAI
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo', // O usa 'gpt-4' si tienes acceso
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente útil que corrige rúbricas educativas.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            // Obtener la respuesta de OpenAI
            $respuestaCorregida = $response['choices'][0]['message']['content'];

            // Extraer la puntuación y los comentarios
            $puntuacion = $this->extraerPuntuacion($respuestaCorregida);
            $comentarios = $this->extraerComentarios($respuestaCorregida);

            // Crear una nueva corrección en la base de datos
            $correccion = Correccion::create([
                'alumno_id' => Auth::id(), // ID del alumno autenticado
                'rubrica_id' => $rubrica->id,
                'puntuacion' => $puntuacion,
                'comentarios' => $comentarios,
                'detalles_correccion' => json_encode(['respuesta' => $respuestaCorregida]),
            ]);

            // Devolver la respuesta corregida y la corrección creada
            return response()->json([
                'respuesta_corregida' => $respuestaCorregida,
                'correccion' => $correccion,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la API: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Método para extraer la puntuación de la respuesta de OpenAI.
     */
    private function extraerPuntuacion($respuesta)
    {
        // Aquí puedes implementar lógica para extraer la puntuación (ej: buscar un número del 1 al 10)
        preg_match('/\b(\d{1,2})\b/', $respuesta, $matches);
        return $matches[1] ?? 0; // Devuelve 0 si no se encuentra una puntuación
    }

    /**
     * Método para extraer los comentarios de la respuesta de OpenAI.
     */
    private function extraerComentarios($respuesta)
    {
        // Aquí puedes implementar lógica para extraer los comentarios
        return $respuesta; // Por defecto, devuelve toda la respuesta como comentarios
    }

}
