@extends('main')

@section('content')
    <div class="content container">
        @if(isset($_GET['error']))
            <div class="row">
                <div class="col">При выполнении запроса возникла ошибка: {{$_GET['error']}}</div>
            </div>
            @unset($_GET['error'])
        @endif
        @if(empty($tags))
            <div class="row">
                <div class="col">Теги не найдены</div>
            </div>
        @else
            <h2>Теги</h2>
            @foreach($tags as $tag)
                <div class="row">
                    <div class="col">#{{$tag->name}}</div>
                    <div class="col"><a href="{{route('tags.edit',$tag->id)}}">Edit</a></div>
                    <div class="col">
                        <form
                            action="{{ route('tags.destroy',$tag->id) }}"
                            method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="submit" value="Delete">
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="row">

            <div class="col"><br>Добавить новый тег</div>
        </div>
        <div class="row">
            <div class="col">
                <form
                    action="{{route('tags.store')}}"
                    method="POST">
                    {{ csrf_field() }}
                    <label> Название
                        <input type="text" name="name" value="" class="form-control">
                    </label>
                    <input type="submit" value="save">
                </form>
            </div>
        </div>
    </div>
@endsection
