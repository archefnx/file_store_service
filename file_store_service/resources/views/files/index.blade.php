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
                <th>New name</th>
                <th>Название</th>
                <th>Размер (MB)</th>
                <th>Расширение</th>
                <th>Скачать</th>
                <th>Редактировать</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $file->name ?? "Default name" }}</td>
                    <td>{{ $file->original_name }}</td>
                    <td>{{ $file->size }}</td>
                    <td>{{ $file->extension }}</td>
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