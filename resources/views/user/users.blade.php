@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 id="a">Usuarios</h1>
            <form method="GET" action="{{ route('user.users') }}" id="buscador">
				<div class="row">
					<div class="form-group col">
						<input type="text" id="search" class="form-control" />
					</div>
					<div class="form-group col">
						<input type="submit" value="Buscar" class="btn btn-success"/>
					</div>
				</div>
            </form>
            <hr>
            @foreach ($users as $user)
            <div class="data-profile">
                @if ($user->image)
                    <div class="container-avatar">
                        <img class="avatar img_pub" src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="Imagen de usuario">
                    </div>
                @endif
                <div class="profile-info">
                    <h2>{{ '@'.$user->nick }}</h2>
                    <h3>{{ $user->name.' '.$user->surname }}</h3>
                    <p>Se unio {{ \FormatTime::LongTimeFilter($user->created_at) }}</p>
                    <a class="btn btn-success" href="{{ route('profile', ['id' => $user->id]) }}">Ver perfil</a>
                </div>
            </div>
            @endforeach
                <!-- PAGINACION -->
            <div class="clearfix"></div>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection