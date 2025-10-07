<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Cien Años de Soledad',
                'author' => 'Gabriel García Márquez',
                'isbn' => '9780307474728',
                'published_year' => 1967,
                'available_copies' => 3,
                'total_copies' => 5,
            ],
            [
                'title' => 'El Principito',
                'author' => 'Antoine de Saint-Exupéry',
                'isbn' => '9780156012195',
                'published_year' => 1943,
                'available_copies' => 2,
                'total_copies' => 4,
            ],
            [
                'title' => 'Don Quijote de la Mancha',
                'author' => 'Cervantes',
                'isbn' => '9780451524935',
                'published_year' => 1605,
                'available_copies' => 1,
                'total_copies' => 3,
            ],
            [
                'title' => 'La Sombra del Viento',
                'author' => 'Carlos Ruiz Zafón',
                'isbn' => '9788408172177',
                'published_year' => 2001,
                'available_copies' => 4,
                'total_copies' => 6,
            ],
            [
                'title' => 'Pedro Páramo',
                'author' => 'Juan Rulfo',
                'isbn' => '9789684115166',
                'published_year' => 1955,
                'available_copies' => 2,
                'total_copies' => 3,
            ],
            [
                'title' => 'Rayuela',
                'author' => 'Julio Cortázar',
                'isbn' => '9788437604947',
                'published_year' => 1963,
                'available_copies' => 3,
                'total_copies' => 5,
            ],
            [
                'title' => 'Ficciones',
                'author' => 'Jorge Luis Borges',
                'isbn' => '9788420665725',
                'published_year' => 1944,
                'available_copies' => 2,
                'total_copies' => 4,
            ],
            [
                'title' => 'Como Agua Para Chocolate',
                'author' => 'Laura Esquivel',
                'isbn' => '9780385420174',
                'published_year' => 1989,
                'available_copies' => 4,
                'total_copies' => 6,
            ],
            [
                'title' => 'Los Detectives Salvajes',
                'author' => 'Roberto Bolaño',
                'isbn' => '9788433967879',
                'published_year' => 1998,
                'available_copies' => 2,
                'total_copies' => 3,
            ],
            [
                'title' => 'El Amor en los Tiempos del Cólera',
                'author' => 'Gabriel García Márquez',
                'isbn' => '9780307389732',
                'published_year' => 1985,
                'available_copies' => 3,
                'total_copies' => 5,
            ],


        ]);
    }
}
