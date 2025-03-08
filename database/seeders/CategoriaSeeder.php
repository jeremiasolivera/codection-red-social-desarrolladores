<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Desarrollo Web', 'descripcion' => 'Todo sobre desarrollo web'],
            ['nombre' => 'Ciberseguridad', 'descripcion' => 'Protección de sistemas e información'],
            ['nombre' => 'DevOps', 'descripcion' => 'Integración y entrega continua'],
            ['nombre' => 'Front End', 'descripcion' => 'Desarrollo de interfaces - Javascript - React JS - Vue JS - Blade'],
            ['nombre' => 'Back End', 'descripcion' => 'Lógica y bases de datos - Django - Laragon'],
            ['nombre' => 'Linux', 'descripcion' => 'Sistema operativo Linux y sus aplicaciones'],
            ['nombre' => 'Project Manager', 'descripcion' => 'Coordinar equipos y liderar proyectos'],
            ['nombre' => 'Redes', 'descripcion' => 'Diseñar, implementar y administrar redes de comunicación de datos sobre diferentes medios y dispositivos de transmisión'],
            ['nombre' => 'Inteligencia Artificial', 'descripcion' => 'computadoras y máquinas que pueden razonar, aprender y actuar de una manera que normalmente requeriría inteligencia humana'],
            ['nombre' => 'Ingeniería de software', 'descripcion' => ' ramas de las ciencias de la computación que estudia la creación de software confiable y de calidad'],

        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
