@extends('layouts.app')

@section('content')
    <h2>Создание файла</h2>

    <!-- Форма создания файла -->
    <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Название файла:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" />
        </div>

        <div class="form-group">
            <label for="file">Файл:</label>
            <input type="file" id="file" name="file" class="form-control-file" accept="image/*" required />
        </div>

        <!-- Add more form fields as needed -->

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
    <button><a href="{{ url('/') }}">Cancel</a></button>
@endsection