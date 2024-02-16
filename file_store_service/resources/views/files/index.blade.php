@extends('layouts.app')

@section('content')
    <h2>Список файлов</h2>

    <!-- Поиск по названию файлов -->
    <form method="get" action="{{ route('files.index') }}">
        <div class="form-group">
            <label for="search">Поиск:</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Найти</button>
    </form>

    <a href="{{ url('create') }}">Add file</a>

    <!-- Таблица со списком файлов -->
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Размер (MB)</th>
                <th>Расширение</th>
                <th>Превью</th>
                <th>Скачать</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $file->name ?? $file->original_name }}</td>
                    <td>{{ round($file->size / 1024 / 1024, 2) }}</td>
                    <td>{{ $file->extension }}</td>
                    <td>
                        @if (in_array($file->extension, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/uploads/' . $file->id . '_' . $file->original_name) }}" alt="{{ $file->original_name }}" style="width: 50px; height: 50px;">
                        @else
                            <img src="{{ asset('storage/default_file_image.png') }}" alt="file" style="width: 50px; height: 50px;">
                        @endif
                    </td>
                    <td><a href="{{ route('files.download', ['id' => $file->id]) }}" class="btn btn-primary">Скачать</a></td>
                    <td><a href="{{ route('files.edit', ['id' => $file->id]) }}" class="btn btn-warning">Редактировать</a></td>
                    <td>
                        <!-- Модальное окно подтверждения удаления -->
                        <div class="modal fade" id="confirmDeleteModal{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $file->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-footer">
                                        <a href="{{ route('files.delete', ['id' => $file->id]) }}" class="btn btn-danger">Удалить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Пагинация -->
    {{ $files->links() }}