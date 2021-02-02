@extends('layouts.app');
@section('content');

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')

            <div class="card">
                <div class="card-header">Subir nueva image</div>
                <div class="card-body">
                    <form action="{{ route('image.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group row">
                                    <label class="col-md-3 form-label text-md-right" for="image_path">Imagen</label>
                                <div class="col-md-7">
                                    <input type="file" name="image_path" class="form-control" required>

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
                                    <textarea name="description" class="form-control" required></textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-3">
                                    <input type="submit" class="btn btn-primary" value="Subir imagen">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection