@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')

                <div class="card pub_image">
                    <div class="card-header">
                        @if ($image->user->image)
                            <div class="container-avatar">
                                <img class="avatar img_pub" src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" alt="Imagen de usuario">
                            </div>
                        @endif
                        <div class="data-user">
                            {{ $image->user->name.' '.$image->user->surname }}
                        </div>
                        <div class="nick_pub">
                            {{ '@'.$image->user->nick }}
                        </div>
                        
                    </div>

                    <div class="card-body">
                        <div class="div_img">
                            <img class="pub_img" src="{{ route('image.file', ['filename' => $image->image_path]) }}" alt="">
                        </div>
                        
                        <div class="description">
                            <p class="description-inline">{{ $image->description }}</p>
                            @if (Auth::user() && Auth::user()->id == $image->user_id)
                            <div class="actions">
                                <a class="btn-edit" href="{{ route('image.edit', ['id' => $image->id]) }}"><i class="fas fa-pen"></i></a>
                                <!-- Button trigger modal -->
<button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="btn-delete-pub fas fa-trash-alt"></i>
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ¿Estas seguro de eliminar esta publicacion?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a class="btn btn-danger" href="{{ route('image.delete', ['id' => $image->id]) }}">Eliminar</a>
        </div>
      </div>
    </div>
  </div>
                            </div>
                            @endif
                        </div>
                        <div class="date_pub">{{ \FormatTime::LongTimeFilter($image->created_at) }}</div>
                        <div class="likes">

                            <?php $user_like = false; ?>
                            @foreach ($image->likes as $like)
                                @if ($like->user->id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif
                            @endforeach
                               
                            @if ($user_like)
                                <i class="fas fa-heart fa-1x btn-like" data-id="{{ $image->id }}"></i>
                            @else
                                <i class="far fa-heart fa-1x btn-like" data-id="{{ $image->id }}"></i>
                            @endif
                            <span class="count_likes">{{ count($image->likes) }}</span>
                           
                        </div>
                        
                        <h3 class="com_detail">Comentarios ({{ count($image->comments) }})</h3>
                        <div class="img_comment_detail">
                            <form action="{{ route('comment.save') }}" method="POST">
                                @csrf
                                
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <p>
                                    <textarea name="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" ></textarea>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </p>
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                            @foreach ($image->comments as $comment)
                                <div class="comment">
                                    <div class="data-user">
                                        @if ($comment->user->image)
                                            <div class="container-avatar">
                                                <img class="avatar img_pub" src="{{ route('user.avatar', ['filename' => $comment->user->image]) }}" alt="Imagen de usuario">
                                            </div>
                                        @endif
                                        {{ $comment->user->name.' '.$comment->user->surname }}
                                    </div>
                                    <div class="nick_pub">
                                        {{ '@'.$comment->user->nick }}
                                    </div>
                                    <div class="date_pub">{{ \FormatTime::LongTimeFilter($comment->created_at) }}</div>
                                    <p>{{ $comment->content }}</p>
                                    @if (Auth::check() && ($comment->user_id == Auth::user()->id) || $comment->image->user_id == Auth::user()->id)
                                        <a class="btn-delete" href="{{ route('comment.delete', ['id' => $comment->id]) }}"><i class="fas fa-trash-alt"></i></a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection