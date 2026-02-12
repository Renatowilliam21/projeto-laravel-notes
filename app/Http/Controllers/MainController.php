<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\Void_;

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

    // Validate request

    $request->validate(

        //rules
            ['text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000'
            ],
            //error messages
            [
                'text_title.required' => 'Um Título é Obrigatório',
                'text_title.min' => 'Um Título deve ter pelo menos :min caracteres',
                'text_title.max' => 'Um Título deve ter no máximo :max caracteres',

                'text_note.required' => 'A inserção de uma nota é Obrigatória',
                'text_note.min' => 'Uma nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'Uma nota deve ter no máximo :max caracteres',
            ]



        );

        echo "A validação deu certo";

    // get user id


    $id = session('user.id');

    // create a new note

    $note = new Note();
    $note->user_id=$id;
    $note->title = $request->text_title;
    $note->text = $request->text_note;
    $note->save();

    // redirect  to home

    return redirect()->route('home');

}

public function editNote($id){

$id = Operations::decryptId($id);


//load note

$note = Note::find($id);


//show edit note view

return View('edit_note', ['note' => $note]);



}

public function deleteNote($id){


$id = Operations::decryptId($id);

echo "ESTOU DELETANDO A NOTA CUJO O ID É $id";


}






}
