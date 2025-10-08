<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-category-list></x-category-list>
            <x-post-list :posts="$posts"></x-post-list>             
        </div>
    </div>
</x-app-layout>