@extends('main')

@section('content')

    <section class="container content">
        <div class="row">
            <div class="col">
                @if(count($films) < 1)
                    Фильмы не найдены
                @else
                    <h2>Фильмы</h2>
                @endif
            </div>
        </div>
        @if(count($films) != 0)
            <div class="row">
                <div class="col">Название фильма</div>
                <div class="col">Год</div>
                <div class="col">Теги</div>
                <div class="col">Редактировать</div>
                <div class="col">Удалить</div>
            </div>
        @endif

        @foreach($films as $tag)
            <div class="row"><h4>{{$tag['tag']}}</h4></div>
            @if(count($tag['children']) > 0)
                @foreach($tag['children'] as $film)
                    <div class="row">
                        <div class="col">{{$film->name}}</div>
                        <div class="col">{{$film->year}}</div>
                        <div class="col">
                            @if(!empty($filmsTags[$film->id]['tags']))

                                @foreach($filmsTags[$film->id]['tags'] as $tag)

                                    #{{$tag->name.' '}}

                                @endforeach

                            @endif
                        </div>
                        <div class="col">
                            <a href="{{route('films.edit',$film->id)}}">Edit</a>
                        </div>
                        <div class="col">
                            <form
                                action="{{ route('films.destroy',$film->id) }}"
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="submit" value="Х">
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Фильмов в этой категории нет</p>
            @endif
        @endforeach

        <div class="row">
            <h3>Добавить фильм</h3>
        </div>
        <div class="row">
            <div class="col">
                <form
                    action="{{ route('films.store') }}"
                    method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <label> Название
                            <input type="text" name="name" value="" class="form-control">
                        </label>
                        <label> Год
                            <input type="text" name="year" value="" class="form-control">
                        </label>
                        <input type="submit" value="save">
                    </div>
                </form>

            </div>
        </div>
    </section>


@endsection
