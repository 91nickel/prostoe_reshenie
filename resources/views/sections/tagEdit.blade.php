@extends('main')

@section('content')
    <div class="content container">
        <h2>Редактирование тега</h2>
        <div class="row">
            <div class="col">
                <form
                    action="{{route('tags.update', $tag->id)}}"
                    method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <label> Название
                        <input type="text" name="name" value="{{$tag->name}}" class="form-control">
                    </label>
                    <input type="submit" value="save">
                </form>
            </div>
        </div>
    </div>
@endsection
