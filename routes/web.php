<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UserController@getIndex');

Route::post('/salvar_usuario', 'UserController@registrarUsuario');
Route::post('/login', 'UserController@loginUsuario');

Route::get('/minha_conta', 'UserController@minhaContaView');
Route::get('/minha_agenda', 'ProfessorController@agendaProfessor');
//Route::get('add-disponibilidade-true', 'ProfessorController@minhaAgendaAlert');

Route::get('/logout', 'UserController@logout');

Route::get('/get/static_materias', 'MateriaController@getStaticMaterias');

Route::post('/save_profile', 'UserController@saveProfile');
Route::post('/save_professor_materias', 'MateriaController@saveProfessorMaterias');
Route::post('/add_disponibilidade', 'DisponibilidadeController@addDisponibilidade');

Route::get('/agendar_aula', 'AlunoController@viewAgendarAula');
Route::get('/agendar_materia/{materia?}', 'AlunoController@viewAgendaPorMateria');
Route::get('/disponibilidadePorDiaHorario/', 'DisponibilidadeController@getDisponibilidadePorDiaHorario');
Route::get('/disponibilidadeById/{id?}', 'DisponibilidadeController@getDisponibilidadeById');

Route::post('/post/agenda_aula', 'AgendadoController@agendaAula');

Route::get('/get/agendadoPorId', 'AgendadoController@getAgendadoById');
Route::post('/cancela_aula', 'AgendadoController@cancelaAula');
Route::post('/cancela_disponibilidade', 'DisponibilidadeController@cancelaDisponibilidade');
Route::get('/agenda_aluno', 'AlunoController@AgendaAluno');

Route::get('/teste', 'AlunoController@teste');

Route::post('/send_email', 'UserController@sendEmail');

Route::post('send_password', 'UserController@sendPassword');

Route::get('/nova-senha/', 'UserController@formNovoPassword');
Route::post('/submit-nova-senha', 'UserController@definirPassword');

Route::get('/admin', 'AdminController@todasAulas');
Route::get('/admin-disponibilidades', 'AdminController@todasDisponibilidades');
Route::get('/admin-alunos', 'AdminController@alunos');
Route::get('/admin-professores', 'AdminController@professores');
Route::get('/admin_agenda_aluno/{alunoId?}', 'AdminController@agendaAluno');
Route::get('/admin_agenda_professor/{professorId?}', 'AdminController@agendaProfessor');