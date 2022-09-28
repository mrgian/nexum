@extends('layouts.layout')

@section('content')

@include('layouts.header')

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <h5>{{ $user->username }}</h5>
                @if (Auth::user()->username == $user->username)
                    <div class="mt-5 text-center"><button onclick="location.href='{{ route('edit') }}'" class="btn btn-dark profile-button" type="button">Modifica profilo</button></div>
                @endif
            </div>
        </div>
        <div class="col-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Dati anagrafici</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-6"><label class="labels">Nome</label><h5>{{ $user->name }}</h5></div>
                    <div class="col-6"><label class="labels">Cognome</label><h5>{{ $user->surname }}</h5></div>
                </div>

                <div class="row mt-3">
                    @can('private', $user)
                        <div class="col-12 py-1"><label class="labels">Sesso</label>
                        @if ($user->sex == 'male')
                            <h5>Uomo</h5>
                        @else
                            <h5>Donna</h5>
                        @endif
                        </div>
                        <div class="col-12 py-1"><label class="labels">Data di nascita</label><h5>{{ $user->getBirthdate() }}</h5></div>
                        <div class="col-12 py-1"><label class="labels">Città</label><h5>{{ $user->city }}</h5></div>
                        <div class="col-12 py-1"><label class="labels">Indirizzo</label><h5>{{ $user->address }}</h5></div>
                    @endcan

                    @cannot('private', $user)
                    <div class="alert alert-danger" role="alert">
                        <p>I dati anagrafici, la biografia e la lista dei blog sono nascosti perchè {{ $user->name }} ha impostato il suo profilo come <b>privato</b>.<br>
                            Invia una richiesta di amicizia a {{ $user->name }} per vedere il resto del suo profilo.</p>
                    </div>
                    @endcannot
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="p-3 py-5">
                @can('private', $user)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Biografia</h4>
                    </div>
                    <p>{{ $user->bio }}</p>
                @endcan
            </div>
        </div>
    </div>
</div>

<hr/>

<div class="container rounded bg-white mt-5 mb-5" id="blogs">
    @can('private', $user)    
        <div class="col-8">
            @if (Auth::user()->username == $user->username)
                <h3>Lista dei tuoi blog</h3>
            @else
                <h3>Lista dei blog di {{ $user->name }} {{ $user->surname }}</h3>
            @endif

            <ul>
                @foreach ($user->getBlogs() as $blog)
                    <li><a href="{{ route('blog', ['blogname' => $blog->blogname ]) }}">{{ $blog->name }}</a></li>
                @endforeach
            </ul>
        </div>
    @endcan
</div>

@include('layouts.footer')

@endsection
