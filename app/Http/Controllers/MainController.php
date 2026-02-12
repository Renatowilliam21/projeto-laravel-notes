<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{


public function index(){

//load user's

$id = session('user.id');
//$user = User::find($id)->toArray();
$notes = User::find($id)->notes()->get()->toArray();


return view('home', ['notes' => $notes]);

}

public function newNote(){

return view('new_note');


}

public function newNoteSubmit(Request $request){

    echo "Estou criando uma nota com este método";

}

public function editNote($id){

$id = Operations::decryptId($id);
echo "ESTOU EDITANDO A NOTA CUJO O ID É $id";

}

public function deleteNote($id){


$id = Operations::decryptId($id);

echo "ESTOU DELETANDO A NOTA CUJO O ID É $id";


}






}
