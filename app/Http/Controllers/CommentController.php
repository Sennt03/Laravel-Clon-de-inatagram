<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){

        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'required'
        ]);

        $user = \Auth::user();
        $content = $request->input('content');
        $image_id = $request->input('image_id');

        $comment = new Comment();

        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        $comment->save();

        return redirect()->route('image.detail', ['id' => $image_id])->with(['message' => 'Comentario publicado correctamente']);
        
    }

    public function delete($id){
        //User identificado
        $user = \Auth::user();

        //Id del comentario
        $comment = Comment::find($id);

        //Comprobar si soy el dueño del comentario
        if($user && ($comment->user_id == $user->id) || $comment->image->user_id == $user->id){
            $comment->delete();

            return redirect()->route('image.detail', ['id' => $comment->image->id])->with(['message' => 'Comentario eliminado correctamente']);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])->with(['message' => 'Error al eliminar']);
        }
    }
}
