<?php

use Illuminate\Database\Seeder;
use App\Materia;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('MateriasTableSeeder');
    }
}

class MateriasTableSeeder extends Seeder{

	public function run(){
		Materia::create(['id'=> 1, 'nome' => 'Matematica']);
		Materia::create(['id'=> 2, 'nome' => 'Português']);
		Materia::create(['id'=> 3, 'nome' => 'Geografia']);
		Materia::create(['id'=> 4, 'nome' => 'Física']);
		Materia::create(['id'=> 5, 'nome' => 'Biologia']);
		Materia::create(['id'=> 6, 'nome' => 'História']);
		Materia::create(['id'=> 7, 'nome' => 'Química']);
	}
}
