<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Image;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){

        //Validacion
        $validate = $this->validate($request, [
            'description' => 'required'
        ]);

        //Recogiendo los datos
        $image_path = $request->file('image_path');
        $type = $image_path->getMimeType();
        
        if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type == 'image/jpg'){
            $description = $request->input('description');

        //Asignar valores al objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        //Subir imagen
       if($image_path){
           $image_path_name = time().$image_path->getClientOriginalName();
           Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with([
            'message' => 'Foto subida correctamente'
        ]);
        }else{
            return redirect()->route('image.create')->with(['message' => 'Envie una imagen porfavor']);
        }
        

    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image = Image::find($id);
        
        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id){
            //Eliminar comentarios
            if($comments && count($comments) > 0){
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            //Eliminar likes
            if($likes && count($likes) > 0){
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            //Eliminar ficheros de imagen 
            Storage::disk('images')->delete($image->image_path);
            //Eliminar registro de la imagen
            $image->delete();
            $message = array('message', 'La imagen ha borrado correctamente');
        }else{
            $message = array('message', 'La imagen no se ha borrado');
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', ['image' => $image]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        $image_id = $request->input('image_id');
        $description = $request->input('description');

        $validate = $this->validate($request, [
            'description' => 'required'
        ]);

        //Recogiendo los datos
        $image_path = $request->file('image_path');

        $valid = 0;
        
        if($image_path != null){
            $type = $image_path->getMimeType();
            if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type == 'image/jpg'){
                $valid = 0;
            }else{
                $valid = 1;
            }
        }

        if($valid == 0){

            $description = $request->input('description');

        //Asignar valores al objeto
        $user = \Auth::user();
        $image = Image::find($image_id);
        $image->user_id = $user->id;
        $image->description = $description;

        //Subir imagen
       if($image_path != null){
           $image_path_name = time().$image_path->getClientOriginalName();
           Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        //Actualizar BBDD
        $image->update();

        return redirect()->route('image.detail', ['id' => $image_id])->with(['massage' => 'Publicacion actualizada correctamente']);
        
        }else{
            return redirect()->route('image.edit')->width(['message' => 'Suba una imagen valida porfavor']);

        }
        
    }
}
