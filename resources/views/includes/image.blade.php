<div class="card pub_image">
    <div class="card-header">
        @if ($image->user->image)
            <div class="container-avatar">
                <img class="avatar img_pub" src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" alt="Imagen de usuario">
            </div>
        @endif
        <div class="data-user">
            <a href="{{ route('profile', ['id' => $image->user->id]) }}" >{{ $image->user->name.' '.$image->user->surname }}</a>
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
            <a href="{{ route('image.detail', ['id' => $image->id]) }}">
                <p>{{ $image->description }}</p>
            </a>
        </div>
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
        <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-warning btn-comments">Comentarios ({{ count($image->comments) }})</a>
        <div class="date_pub">{{ \FormatTime::LongTimeFilter($image->created_at) }}
        </div>
    </div>
</div>