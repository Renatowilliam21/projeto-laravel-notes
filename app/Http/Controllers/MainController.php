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
$notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();


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


public function editNoteSubmit(Request $request){

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

    // check if note_id exists

    if($request->note_id == null){

    return redirect()->route('home');
    }


    // decrypt note_id

    $id = Operations::decryptId($request->note_id);

    // load note

    $note = Note::find($id);

    // update note

    $note->title = $request->text_title;
    $note->text = $request->text_note;
    $note->save();

    //redirect to home

   return redirect()->route('home');


}

public function deleteNote($id){


$id = Operations::decryptId($id);

//load note
$note = Note::find($id);

// show delete note confirmation

return view('delete_note', ['note'=> $note]);


}


public function deleteNoteConfirm($id){

//check if $id is encrypeted
$id = Operations::decryptId($id);

// load note
$note = Note::find($id);

//1. hard delete

//$note->delete();

//2.soft delete

//$note->deleted_at = date('Y:m:d H:i:s');
//$note->save();

//3. soft delete(property in Model)
$note->delete();

//4. hard delete(property in Model)
//$note->forcedelete();



//redirect to home


return redirect()->route('home');
}



}
