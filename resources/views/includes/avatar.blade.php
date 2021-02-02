@if (Auth::user()->image)
    <div class="container-avatar">
        <img class="avatar" src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" alt="Imagen de usuario">
    </div>
@endif