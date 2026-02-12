<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="post" action="{{ route("post.store") }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-4 flex justify-center items-center">
                        <h4 class="text-3xl font-bold">Create Post</h4>
                    </div>
                    <div class="mt-4">

                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus autocomplete="choose your image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" name="title"
                            :value="old('title')" autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-textarea-label for="content" :value="__('Content')" />
                        <x-text-area id="content" class="block mt-1 w-full" name="content"
                         autofocus autocomplete="content">{{ old('content') }}</x-text-area>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-textarea-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class='border-gray-300 focus:border-indigo-500
focus:ring-indigo-500 rounded-md shadow-sm w-full'>
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}" @selected(old('category_id') == $category['id'])>{{Str::trim($category['name'])}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <!-- Published at -->
                    <div class="mt-4">
                        <x-input-label for="published_at" :value="__('Published at')" />
                        <x-text-input type="datetime-local" id="published_at" class="block mt-1 w-full" name="published_at"
                            :value="old('published_at')" autofocus autocomplete="published_at" />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>
                    <x-primary-button class="mt-4">
                        {{ __('Create') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
