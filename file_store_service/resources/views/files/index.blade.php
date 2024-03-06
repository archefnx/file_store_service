@extends('layouts.app')

@section('content')

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Docx</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ url('create') }}"
                        class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500"
                        aria-current="page">Добавить файл</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<form class="max-w-md mx-auto" method="get" action="{{ route('files.index') }}">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="search" name="search" id="search" value="{{ request('search') }}"
            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Поиск..."/>
        <button type="submit"
            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Поиск</button>
    </div>
</form>

<div class="relative sm:rounded-lg"
    style="padding-left: 5rem; padding-right: 5rem; padding-top: 1rem; padding-bottom: 5rem;">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Название
                </th>
                <th scope="col" class="px-6 py-3">
                    Размер (MB)
                </th>
                <th scope="col" class="px-6 py-3">
                    Расширение
                </th>
                <th scope="col" class="px-6 py-3">
                    Превью
                </th>
                <th scope="col" class="px-6 py-3">
                    Скачать
                </th>
                <th scope="col" class="px-6 py-3">
                    Действие
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $file->name ?? $file->original_name }}
                </th>
                <td class="px-6 py-4">
                    {{ round($file->size / 1024 / 1024, 2) }}
                </td>
                <td class="px-6 py-4">
                    {{ $file->extension }}
                </td>
                <td class="px-6 py-4">
                    @if (in_array($file->extension, ['jpg', 'jpeg', 'png', 'gif']))
                    <img class="w-10 h-10 rounded-full"
                        src="{{ asset('storage/uploads/' . $file->id . '_' . $file->original_name) }}"
                        alt="{{ $file->original_name }}">
                    @else
                    <img class="w-10 h-10 rounded-full" src="{{ asset('storage/default_file_image.png') }}" alt="file">
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('files.download', ['id' => $file->id]) }}"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Скачать</a>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('files.edit', ['id' => $file->id]) }}"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Редактировать</a>
                    <a href="{{ route('files.delete', ['id' => $file->id]) }}"
                        class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Удалить</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


