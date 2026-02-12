<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 text-gray-900">
        <ul class="flex flex-wrap text-sm font-medium text-center justify-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <a href="/" class="{{ Route::CurrentRouteNamed('posts.byCategory') ?
                'inline-block px-4 py-2 rounded-lg hover:text-gray-900
                        hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' :
                'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' }}"
                    aria-current="page">All</a>
            </li>
            @foreach($categories as $category)
            <li class="me-2">
                    <a href="{{ route('posts.byCategory', $category) }}"
                        class="{{ Route::CurrentRouteNamed('posts.byCategory') &&
                            request()->route('category')?->id === $category->id ?
                            'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' :
                            'inline-block px-4 py-2 rounded-lg hover:text-gray-900
                        hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                        {{$category->name}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
