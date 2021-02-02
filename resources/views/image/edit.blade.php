@extends('layouts.app');
@section('content');

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')

            <div class="card">
                <div class="card-header">Editar publicacion</div>
                <div class="card-body">
                    <form action="{{ route('image.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                            <div class="form-group row">
                                    <label class="col-md-3 form-label text-md-right" for="image_path">Imagen</label>
                                <div class="col-md-7">
                                    @if ($image->image_path)
                                        <div class="container-avatar">
                                            <img class="img-edit" src="{{ route('image.file', ['filename' => $image->image_path]) }}" alt="Imagen de la publicacion">
                                        </div>
                                    @endif
                                    <input type="file" name="image_path" class="form-control">

                                    @if ($errors->has('image_path'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image_path') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                    <label class="col-md-3 form-label text-md-right" for="description">Descripcion</label>
                                <div class="col-md-7">
                                    <textarea name="description" class="form-control" required>{{ $image->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-3">
                                    <input type="submit" class="btn btn-primary" value="Actualizar">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection