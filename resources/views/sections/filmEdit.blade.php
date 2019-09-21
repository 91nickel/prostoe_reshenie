@extends('main')

@section('content')
    <section class="container content">
        <div class="row">
            <h3>Редактировать фильм</h3>
        </div>
        <div class="row">
            <div class="col">
                {{--            @dd($film)--}}
                <form
                    action="{{ route('films.update', $film->id) }}"
                    method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="row">
                        <label> Название
                            <input type="text" name="name" value="{{$film->name}}" class="form-control">
                        </label>
                        <label> Год
                            <input type="text" name="year" value="{{$film->year}}" class="form-control">
                        </label>
                        <input type="submit" value="save">
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h4>Активные теги</h4>
                @foreach($activeTags as $item)
                    <form
                        action="{{route('filmTagLinks.destroy', $item->link_id)}}"
                        method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="film_id" value="{{$film->id}}">
                        <input type="hidden" name="id" value="{{$item->link_id}}">
                        <input type="submit" value="#{{$item->tag_name}} - Удалить">
                    </form>
                @endforeach
            </div>
            <div class="col">
                <h4>Неактивные теги</h4>
                @foreach($noActiveTags as $item)
                    <div class="row">
                        <form
                            action="{{ route('filmTagLinks.store') }}"
                            method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                    <input type="hidden" name="film_id" value="{{$film->id}}" class="form-control">
                                    <input type="hidden" name="tag_id" value="{{$item->id}}" class="form-control">
                                <input type="submit" value="#{{$item->name}} - Добавить">
                            </div>
                        </form>


                    </div>

                @endforeach
            </div>
        </div>
    </section>
    {{--    @dd($activeTags, $noActiveTags)--}}
@endsection
