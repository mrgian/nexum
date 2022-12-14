@extends('layouts.layout')

@section('content')

    @include('layouts.header')

    <div class="container rounded bg-white mt-5 mb-5">
        <div class="col-8">
            <h1>{{ $blog->name }}</h3>
                <h3>{{ $blog->topic }}</h3>
        </div>

        @cannot('isFriend', $blog->getOwner())
            <div class="alert alert-danger" role="alert">
                <p>Il contenuto di questo blog non è visibile perchè l'autore di questo blog non è fra i tuoi <b>amici</b>.<br>
                    Invia una richiesta di amicizia a <a
                        href="{{ route('user', ['username' => $blog->owner]) }}">{{ $blog->getOwner()->name }}
                        {{ $blog->getOwner()->surname }}</a> per vedere questo blog.</p>
            </div>
        @endcannot

        @can('isFriend', $blog->getOwner())
            <div class="row">
                <div class="col-8">
                    @cannot('isStaff')
                        <div class="card m-2">
                            <div class="card-body">
                                {{ Form::open(['id' => 'formNewPost']) }}
                                {{ Form::label('text', 'Scrivi un nuovo post:', ['class' => 'form-label h5', 'for' => 'formNewPostBody']) }}
                                {{ Form::textarea('text', '', ['class' => 'form-control', 'id' => 'formNewPostBody', 'rows' => 3]) }}
                                <button id="buttonPost" onClick="newPost()"
                                    url="{{ route('newPost', ['blogname' => $blog->blogname]) }}" class="btn btn-dark btn-lg my-3"
                                    type="button">Invia</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    @endcannot

                    @foreach ($blog->getPosts() as $post)
                        <div class="card m-2">
                            <div class="card-body">
                                <a href="{{ route('user', ['username' => $post->author]) }}">
                                    <h5 class="card-title">{{ $post->getAuthor()->name }} {{ $post->getAuthor()->surname }}
                                    </h5>
                                </a>
                                <p class="text-muted">postato il {{ $post->getCreationDate() }} alle
                                    {{ $post->getCreationTime() }}</p>
                                <p class="card-text">{{ $post->text }}</p>

                                @can('editPost', $post)
                                    <button data-bs-toggle="modal" data-bs-target="#editModal" type="button"
                                        class="btn btn-dark">Modifica</button>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteModal" type="button"
                                        class="btn btn-danger">Elimina</button>
                                @endcan

                                @can('isStaff')
                                    <button data-bs-toggle="modal" data-bs-target="#staffDeleteModal" type="button"
                                        class="btn btn-danger">Elimina</button>
                                @endcan
                            </div>
                        </div>

                        <div class="p-2" id="alertPlaceholder"></div>

                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    {{ Form::open(['id' => 'formEditPost']) }}
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Modifica post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ Form::label('text', 'Nuovo contenuto del post:', ['class' => 'form-label', 'for' => 'formEditPostBody']) }}
                                        {{ Form::textarea('text', $post->text, ['class' => 'form-control', 'id' => 'formEditPostBody', 'rows' => 3]) }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                        <button id="buttonEditPost" onClick="editPost()"
                                            url="{{ route('editPost', ['blogname' => $blog->blogname, 'postid' => $post->id]) }}"
                                            type="button" class="btn btn-success">Modifica</button>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Rimuovi post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Sei sicuro di voler rimuovere il post?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                        <button id="buttonDeletePost" onClick="deletePost()"
                                            url="{{ route('deletePost', ['blogname' => $blog->blogname, 'postid' => $post->id]) }}"
                                            type="button" class="btn btn-danger">Elimina</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="staffDeleteModal" tabindex="-1" aria-labelledby="staffDeleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staffDeleteModalLabel">Rimuovi post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="form-group m-2">
                                        <label for="message-text" class="col-form-label">Inserisci il motivo della rimozione:</label>
                                        <textarea class="form-control" id="message-text"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                        <button id="buttonStaffDeletePost" onClick="staffDeletePost()"
                                            url="{{ route('staffDeletePost', ['blogname' => $blog->blogname, 'postid' => $post->id]) }}"
                                            type="button" class="btn btn-danger">Elimina</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Informazioni sul blog</h3>
                            <div class="p-2">
                                <h5>Creato da: </h5><a
                                    href="{{ route('user', ['username' => $blog->owner]) }}">{{ $blog->getOwner()->name }}
                                    {{ $blog->getOwner()->surname }}</a>
                            </div>
                            <div class="p-2">
                                <h5>Data di creazione: </h5>
                                <p>{{ $blog->getCreationDate() }}</p>
                            </div>
                            @can('isUser', $blog->getOwner())
                                <div>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteBlogModal" type="button" class="btn btn-large btn-danger">Elimina intero blog</button>
                                </div>
                            @endcan

                            @can('isStaff')
                                <div>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteBlogModal" type="button" class="btn btn-large btn-danger">Elimina intero blog</button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-labelledby="deleteBlogModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteBlogModalLabel">Elimina blog</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Sei sicuro di voler eliminare il blog?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                <button id="buttonDeleteBlog" onClick="deleteBlog()"
                                    url="{{ route('deleteBlog', ['blogname' => $blog->blogname]) }}"
                                    dest="{{ route('bloglist') }}"
                                    type="button" class="btn btn-danger">Elimina</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>


    @include('layouts.footer')

@endsection
