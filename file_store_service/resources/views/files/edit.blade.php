@extends('layouts.app')

@section('content')
    <h2>Редактирование файла</h2>

    <!-- Форма редактирования файла -->
    <form method="post" action="{{ route('files.update', ['id' => $file->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Название файла:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $file->name) }}" />
        </div>

        <div class="form-group">
            <label for="file">Файл:</label>
            <input type="file" id="file" name="file" class="form-control-file" accept="uploads/*" />
        </div>

        <!-- Add more form fields as needed -->

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

    <button><a href="{{ url('/') }}">Cancel</a></button>

@endsection