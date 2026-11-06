<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email'=>'investigadora@udh.edu.pe'], ['name'=>'Investigadora UDH','password'=>'password','role'=>'investigadora','active'=>true]);
        User::updateOrCreate(['email'=>'docente@udh.edu.pe'], ['name'=>'Docente Illathupa','password'=>'password','role'=>'docente','active'=>true]);
        User::updateOrCreate(['email'=>'estudiante@udh.edu.pe'], ['name'=>'Estudiante de demostración','password'=>'password','role'=>'estudiante','active'=>true]);

        $samples = [
            ['title'=>'Descomponemos un problema','description'=>'Aprende a dividir un problema complejo en partes pequeñas y manejables.','dimension'=>'descomposicion','instructions'=>'Lee cada pregunta y selecciona la alternativa que mejor resuelve el problema.'],
            ['title'=>'Detectives de patrones','description'=>'Reconoce semejanzas, regularidades y elementos que se repiten.','dimension'=>'patrones','instructions'=>'Observa la secuencia y encuentra la regla que se repite.'],
            ['title'=>'Abstraemos lo importante','description'=>'Identifica la información relevante y deja de lado los detalles secundarios.','dimension'=>'abstraccion','instructions'=>'Selecciona la información necesaria para resolver la situación.'],
            ['title'=>'Diseñamos algoritmos','description'=>'Ordena instrucciones claras para alcanzar un objetivo.','dimension'=>'algoritmico','instructions'=>'Analiza el orden de los pasos y selecciona la secuencia correcta.'],
        ];
        foreach ($samples as $i => $sample) {
            $activity = Activity::firstOrCreate(['title'=>$sample['title']], $sample + ['published'=>true]);
            if ($activity->questions()->count() === 0) {
                $activity->questions()->create([
                    'statement' => ['¿Cuál es el primer paso para resolver un problema grande?','¿Qué permite reconocer un patrón?','¿Qué significa abstraer?','¿Qué característica tiene un algoritmo?'][$i],
                    'options' => [
                        ['Dividirlo en partes pequeñas','Ignorar el problema','Elegir al azar','Repetir sin analizar'],
                        ['Identificar regularidades','Cambiar todos los datos','Eliminar la secuencia','Responder al azar'],
                        ['Conservar lo relevante','Guardar cada detalle','Evitar analizar','Repetir instrucciones'],
                        ['Tiene pasos ordenados y finitos','No tiene objetivo','Es una acción improvisada','No necesita instrucciones']
                    ][$i],
                    'correct_option' => 0,
                    'feedback_correct' => '¡Muy bien! Has identificado correctamente el concepto.',
                    'feedback_incorrect' => 'Vuelve a revisar la explicación de esta dimensión y analiza cada alternativa.'
                ]);
            }
        }
    }
}
