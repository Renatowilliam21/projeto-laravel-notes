<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{


    public function login(){

        return view('login');

    }

    public function loginSubmit(Request $request){


    //form validation

        $request->validate(

        //rules
            ['text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16'
            ],
            //error messages
            [
                'text_username.required' => 'O Username é Obrigatório',
                'text_username.email' => 'O Username deve ser um email válido',
                'text_password.required' => 'Um Password é Obrigatório',
                'text_password.required' => 'Um Password é Obrigatório',
                'text_password.min' => 'Um password deve ter pelo menos :min caracteres',
                'text_password.max' => 'Um password deve ter no máximo :max caracteres',
            ]



        );

        //get user input

        $username = $request ->input('text_username');
        $password = $request ->input('text_password');

        //Check if users exists

        $user = User::where('username', $username)
                        ->where('deleted_at', NULL)
                        ->first();

                        if(!$user){

                            return redirect()
                                ->back()
                                ->withInput()
                                ->with('loginError', 'Nome de usuário ou Senha incorretos');
                        }

                        if(!password_verify($password,$user->password)){

                            return redirect()
                                ->back()
                                ->withInput()
                                ->with('loginError', 'Nome de usuário ou Senha incorretos');
                        }

                    //update last login

                    $user->last_login = date('Y-m-d H:i:s');
                    $user->save();

                    //Login User

                    session([

                        'user' =>[
                            'id' => $user->id,
                            'username' => $user->username
                        ]
                    ]);

                //echo 'Login Efetuado com Sucesso!!';

                 //Redirect to home

                 return redirect()->to('/');


//                print_r($user);

        //get all users from the database

        //$users = User::all()->toArray();

        //as na object instance of the model's class
/*
        $userModel = new User();
        $users = User::all()->toArray();
        echo '<pre>';
        print_r($users);

        //echo 'OK!';
*/
        // text database conect
/*
        try{

        DB::connection()->getPdo();
        echo 'Connection is OK!!';

        }catch(\PDOException $e){

        echo "Connection failed: " . $e->getMessage();

        }

        echo 'FIM!!';*/
    }







    public function logout(){

        session()->forget('user');
        return redirect()->to('/login');


    }
}
