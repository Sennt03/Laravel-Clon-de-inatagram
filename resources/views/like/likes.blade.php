@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>Imagenes que te gustan</h1>
            @foreach ($likes as $like)
                    @include('includes.image', ['image' => $like->image])
            @endforeach

            <!-- PAGINACION -->
            <div class="clearfix"></div>
            {{ $likes->links() }}
        </div>
    </div>
</div>
@endsection