<?php

namespace App\Http\Controllers;

use App\Models\Correccion;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use App\Models\Rubrica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RubricaController extends Controller
{
    /**
     * Muestra la lista de rúbricas.
     */
    public function index()
    {
        $rubricas = Rubrica::all();
        return view('rubricas.index', compact('rubricas'));
    }

    /**
     * Muestra el formulario para crear una nueva rúbrica.
     */
    public function create()
    {
        return view('rubricas.create');
    }

    /**
     * Guarda una nueva rúbrica en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'codigo' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'claridad' => 'required|boolean',
            'comentario' => 'required|boolean',
            'num_preguntas' => 'required|integer|min:1',
            'preguntas' => 'required|array|min:1',
            'preguntas.*.pregunta' => 'required|string',
            'preguntas.*.puntuacion' => 'required|integer|min:0',
        ]);

        // Recoger las preguntas en un formato adecuado
        $preguntas = $request->preguntas;

        // Crear una nueva rúbrica
        $rubrica = new Rubrica();
        $rubrica->curso_id = Auth::id();
        $rubrica->codigo = $request->codigo;
        $rubrica->titulo = $request->titulo;
        $rubrica->descripcion = $request->descripcion;
        $rubrica->claridad = $request->claridad;
        $rubrica->comentario = $request->comentario;
        $rubrica->num_preguntas = $request->num_preguntas;
        $rubrica->preguntas = json_encode($preguntas);  // Almacenar preguntas como JSON
        $rubrica->save();  // Guardar la rúbrica en la base de datos

        // Redirigir al listado de rúbricas o mostrar un mensaje de éxito
        return redirect()->route('rubricas.index')->with('success', 'Rúbrica creada correctamente.');
    }



    /**
     * Muestra los detalles de una rúbrica específica.
     */
    public function show(Rubrica $rubrica)
    {
        return view('rubricas.show', compact('rubrica'));
    }

    /**
     * Muestra el formulario para editar una rúbrica.
     */
    public function edit($id)
    {
        $rubrica = Rubrica::findOrFail($id);
        return view('rubricas.edit', compact('rubrica'));
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'codigo' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'claridad' => 'required|boolean',
            'comentario' => 'required|boolean',
            'num_preguntas' => 'required|integer|min:1',
            'preguntas' => 'required|array',
        ]);

        // Encontrar la rúbrica que se quiere actualizar
        $rubrica = Rubrica::findOrFail($id);

        // Asignar los valores del formulario a la rúbrica
        $rubrica->codigo = $request->input('codigo');
        $rubrica->titulo = $request->input('titulo');
        $rubrica->descripcion = $request->input('descripcion');
        $rubrica->claridad = $request->input('claridad');
        $rubrica->comentario = $request->input('comentario');
        $rubrica->num_preguntas = $request->input('num_preguntas');
        $rubrica->preguntas = json_encode($request->input('preguntas'));

        // Guardar la rúbrica actualizada
        $rubrica->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('rubricas.index')->with('success', 'Rúbrica actualizada correctamente');
    }

    /**
     * Elimina una rúbrica.
     */
    public function destroy(Rubrica $rubrica)
    {
        $rubrica->delete();
        return redirect()->route('rubricas.index')->with('success', 'Rúbrica eliminada.');
    }



    ////MIAU
    ///

    public function evaluarCodigo(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'codigo' => 'required|string',
            'alumno_id' => 'required|integer|exists:users,id',
            'curso_id' => 'required|integer|exists:cursos,id',
        ]);

        // Recuperar la rúbrica seleccionada
        $rubrica = Rubrica::findOrFail($id);
        $preguntas = json_decode($rubrica->preguntas, true);

        // Crear el mensaje para la API de OpenRouter
        $mensaje = "Por favor, evalúa el siguiente código según la rúbrica proporcionada:\n\n";
        $mensaje .= "Código del alumno:\n```\n" . $request->codigo . "\n```\n\n";
        $mensaje .= "Rúbrica:\n";
        foreach ($preguntas as $pregunta) {
            $mensaje .= "- " . $pregunta['pregunta'] . " (Puntuación máxima: " . $pregunta['puntuacion'] . ")\n";
        }
        $mensaje .= "\nProporciona una evaluación detallada para cada pregunta.";

        // URL de la API de OpenRouter
        $url = 'https://openrouter.ai/api/v1/chat/completions';

        // Datos que se enviarán en la solicitud
        $data = [
            'model' => 'deepseek/deepseek-r1:free',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $mensaje,
                ],
            ],
        ];

        // Encabezados de la solicitud
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer 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',
        ];

        // Enviar la solicitud HTTP POST a la API
        $response = Http::withHeaders($headers)->post($url, $data);

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Decodificar la respuesta JSON
            $responseData = $response->json();

            // Procesar la respuesta de la API
            $respuestaIA = $responseData['choices'][0]['message']['content'] ?? 'No se recibió una respuesta válida.';

            // Parsear la respuesta para generar una plantilla de corrección
            $correccion = $this->parsearRespuesta($respuestaIA, $preguntas);

            // Calcular la nota (sobre 10)
            $nota = $this->calcularNota($correccion['preguntas']);

            // Guardar la corrección en la base de datos
            $correccionGuardada = Correccion::create([
                'profesor_id' => Auth::id(), // ID del profesor autenticado
                'rubrica_id' => $rubrica->id,
                'alumno_id' => $request->alumno_id,
                'curso_id' => $request->curso_id, // ID del curso
                'nota' => $nota,
                'evaluacion_general' => json_encode($correccion['evaluacion_general']),
                'preguntas' => json_encode($correccion['preguntas']),
            ]);

            // Retornar la corrección
            return response()->json([
                'success' => true,
                'correccion' => $correccion,
                'nota' => $nota,
                'correccion_id' => $correccionGuardada->id,
            ]);
        } else {
            // Manejar el error en caso de que la solicitud no sea exitosa
            return response()->json([
                'success' => false,
                'error' => 'Error al comunicarse con la API de OpenRouter.',
            ], 500);
        }
    }

    private function calcularNota($preguntas)
    {
        $puntuacionTotal = 0;
        $puntuacionMaxima = 0;

        foreach ($preguntas as $pregunta) {
            $puntuacionTotal += $pregunta['puntuacion_obtenida'] ?? 0;
            $puntuacionMaxima += $pregunta['puntuacion_maxima'];
        }

        // Calcular la nota sobre 10
        return ($puntuacionTotal / $puntuacionMaxima) * 10;
    }

    private function parsearRespuesta($respuestaIA, $preguntas)
    {
        // Plantilla de corrección
        $correccion = [
            'evaluacion_general' => '',
            'preguntas' => [],
        ];

        // Extraer la evaluación general
        $correccion['evaluacion_general'] = $respuestaIA;

        // Asignar la respuesta de la IA a cada pregunta
        foreach ($preguntas as $index => $pregunta) {
            $correccion['preguntas'][] = [
                'pregunta' => $pregunta['pregunta'],
                'puntuacion_maxima' => $pregunta['puntuacion'],
                'respuesta' => $respuestaIA, // Aquí puedes personalizar cómo extraer la respuesta para cada pregunta
            ];
        }

        return $correccion;
    }

    public function responder(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*.puntuacion' => 'required|integer|min:0',
            'comentario_alumno' => 'nullable|string',
        ]);

        // Recuperar la rúbrica
        $rubrica = Rubrica::findOrFail($id);

        // Calcular la nota total
        $notaTotal = 0;
        $preguntas = json_decode($rubrica->preguntas, true);

        foreach ($request->respuestas as $index => $respuesta) {
            $puntuacionMaxima = $preguntas[$index]['puntuacion'];
            $puntuacionAlumno = $respuesta['puntuacion'];

            // Asegurarse de que la puntuación no exceda el máximo
            if ($puntuacionAlumno > $puntuacionMaxima) {
                return back()->withErrors(['respuestas.' . $index . '.puntuacion' => 'La puntuación no puede ser mayor que ' . $puntuacionMaxima]);
            }

            $notaTotal += $puntuacionAlumno;
        }

        // Guardar la respuesta en la base de datos
        $respuestaAlumno = Respuesta::create([
            'rubrica_id' => $rubrica->id,
            'alumno_id' => Auth::id(),
            'respuestas' => json_encode($request->respuestas),
            'comentario_alumno' => $request->comentario_alumno,
            'nota' => $notaTotal,
        ]);

        return redirect()->route('rubricas.show', $rubrica->id)->with('success', 'Respuesta enviada correctamente.');
    }
    public function mostrarFormularioRespuesta($id)
    {
        $rubrica = Rubrica::findOrFail($id);
        return view('rubricas.responder', compact('rubrica'));
    }


    public function guardarRespuesta(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*.puntuacion' => 'required|string',
        ]);

        // Recuperar la rúbrica
        $rubrica = Rubrica::findOrFail($id);

        // Guardar la respuesta en la base de datos
        $respuestaAlumno = Respuesta::create([
            'rubrica_id' => $rubrica->id,
            'alumno_id' => Auth::id(),
            'respuestas' => json_encode($request->respuestas),
        ]);

        // Formatear las preguntas y respuestas para la IA
        $preguntas = json_decode($respuestaAlumno->respuestas, true);
        $mensajeParaIA = "Evalúa las siguientes respuestas del alumno y proporciona una nota numérica del 1 al 10 basada en la claridad y precisión de las respuestas. Responde únicamente con la evaluación y la nota en el siguiente formato:\n\n";
        $mensajeParaIA .= "**Evaluación:** [Texto breve de la evaluación]\n";
        $mensajeParaIA .= "**Nota:** [Nota del 1 al 10]\n\n";
        $mensajeParaIA .= "Preguntas y respuestas del alumno:\n";

        foreach ($preguntas as $index => $pregunta) {
            $mensajeParaIA .= "Pregunta " . ($index + 1) . ": " . $pregunta['pregunta'] . "\n";
            $mensajeParaIA .= "Respuesta del alumno: " . $pregunta['puntuacion'] . "\n\n";
        }

        // Realizar la petición a la API de OpenRouter
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
// si no funciona es porque la key ha expirado, asi es que, sacar una nueva
            'Authorization' => 'Bearer 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',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-r1:free',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $mensajeParaIA,
                ],
            ],
        ]);

        // Verificar si la petición fue exitosa
        if ($response->successful()) {
            $respuestaIA = $response->json();

            // Extraer la evaluación y la nota de la respuesta de la IA
            $evaluacionCompleta = $respuestaIA['choices'][0]['message']['content'] ?? 'No se recibió una evaluación válida.';

            // Extraer la evaluación y la nota usando expresiones regulares
            preg_match('/\*\*Evaluación:\*\* (.*?)\n/', $evaluacionCompleta, $matchesEvaluacion);
            preg_match('/\*\*Nota:\*\* (\d+)/', $evaluacionCompleta, $matchesNota);


            $evaluacion = $matchesEvaluacion[1] ?? 'Evaluación no disponible';
            $nota = $matchesNota[1] ?? 0; // Si no se encuentra la nota, se asigna 0
            $nota = max(1, min(10, (int)$nota));
            // Guardar la corrección en la base de datos
            $correccion = Correccion::create([
                'respuesta_id' => $respuestaAlumno->id,
                'evaluacion' => $evaluacion,
                'nota' => $nota,
            ]);

            return redirect()->route('cursos.show', $rubrica->curso_id)->with('success', 'Respuesta y corrección enviadas correctamente.');
        } else {
            // Manejar el error en caso de que la petición no sea exitosa
            logger('Error en la petición a la API:', ['error' => $response->body()]);
            return redirect()->route('cursos.show', $rubrica->curso_id)->with('error', 'Error al enviar la respuesta a la IA.');
        }
    }
}

/*

curl -X POST http://192.168.56.5/api/evaluar-codigo \
  -H "Content-Type: application/json" \
  -d '{
    "codigo": "two plus two"
  }'
 * */
