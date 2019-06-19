<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\User;
use App\Professor;
use App\Aluno;
use App\Mail\ContatoEmail;
use App\Mail\SendPassword;

class UserController extends Controller
{

	public function getIndex(){		
		//Test if someone is logged in and return the corresponding body
		if (Auth::user() == null) {
			return view ('index')->with('extension', 'visitor/main-body');
		}
		if (Auth::user()->user_type == "professor") {
			return view ('index')->with('extension', 'professor/professor-main-body');
		}else{
			return view ('index')->with('extension', 'aluno/aluno-main-body');
		}
	}

 	public function registrarUsuario(){
 		$email = Request::all()['email'];
 		$password = Request::all()['password'];

 		//create the user
 		$user = User::create([
 							'email' => $email,
 							'password' => bcrypt($password),
 							'user_type' => Request::all()['user_type']
 							]);

		if (Request::all()['user_type'] == "professor") {
			return $this->registrarProfessor($user, $email, $password);
		}else if (Request::all()['user_type'] == "aluno") {
			return $this->registrarAluno($user, $email, $password);
		}
	}

	private function registrarProfessor($user, $email, $password){		
		Professor::create(['user_id' => $user->id]);

		//try to login and return the result
		//The response content must be a string
		return $this->loginUsuario($email, $password);
		if (Auth::attempt(['email' => $email, 'password' => $password])){
			return 'true';
		}else{
			return 'false';
		}
	}

	private function registrarAluno($user, $email, $password){
		Aluno::create(['user_id' => $user->id]);

		//try to login and return the result
		//The response content must be a string
		if (Auth::attempt(['email' => $email, 'password' => $password])){
			return 'true';
		}else{
			return 'false';
		}
	}

	public function loginUsuario(){
		$email = Request::all()['email'];
		$password = Request::all()['password'];		

		//The response content must be a string
		if (Auth::attempt(['email' => $email, 'password' => $password])){
			return 'true';
		}else{
			return 'false';
		}
	}

	public function minhaContaView(){		
		if (Auth::user()->user_type == "professor") {
			$professor = Professor::where('user_id', Auth::user()->id)
									->with('user')
									->with('materia')
									->first();
			$body = 'professor/professor-main-body';			
			return view('/minha_conta')->with('user', $professor)->with('body', $body);
		}

		if (Auth::user()->user_type == "aluno") {
			$aluno = Aluno::where('user_id', Auth::user()->id)
								->with('user')
								->first();
								
			$body = 'aluno/aluno-main-body';
			//Precisa passar uma array vazia para o html aceitar
			$aluno->materia = [];			
			return view('/minha_conta')->with('user', $aluno)->with('body', $body);
		}		
	}

	public function logout(){
		Auth::logout();

		return redirect('/');
	}

	public function saveProfile(){
		$data = Request::all();
		//Make the upgrade and change the password
		if (isset($data['data']['novaSenha'])) {
			if ($this->checkPassword($data['data']['venhaSenha'], Auth::user()->email)) {
				User::where('email', Auth::user()->email)
					->first()
					->update([
							'nome' => $data['data']['nome'],
							'sobrenome' => $data['data']['sobrenome'],
							'password' => bcrypt($data['data']['novaSenha']),
							]);
			}else{
				return "wrongPassword";
			}
		}

		User::where('email', Auth::user()->email)
					->first()
					->update([
							'sobrenome' => $data['data']['sobrenome'],
							'nome' => $data['data']['nome']
							]);

		return "true";	
	}

	private function checkPassword($password, $email){
		return Auth::validate(['email' => $email, 'password' => $password]);
	}

	public function sendEmail(){		
		$contato = ['nome' => Request::all()['nome'], 'email' => Request::all()['email'], 'mensagem' => Request::all()['mensagem']];

		\Mail::to('escolatempobh@gmail.com')->send(new ContatoEmail($contato));

		return 'true';
	}

	public function sendPassword(){
		$email = Request::all()['email'];
		$user = User::where('email', $email)->first();
		
		\Mail::to($user->email)->send(new SendPassword($user));
	}

	public function formNovoPassword(){
		return view('/nova_senha')->with('email', Request::all()['email'])->with('token', Request::all()['token'])->with('extension', 'visitor/main-body');
	}

	public function definirPassword(){
		$user = User::where('email', Request::all()['email'])->first();


		if ($user->remember_token != Request::all()['token']) {
			//Colocar o erro de fraude aqui
		}

		$user->update(['password' => bcrypt(Request::all()['password'])]);

		return redirect('/');
	}
}