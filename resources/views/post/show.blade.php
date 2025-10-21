<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <!-- Post Title -->
                <h4 class="text-3xl font-bold">{{ $post->title }}</h4>
                <!-- Author Info -->
                <div class="mt-6 flex gap-4">
                    <img src="{{$post->user->imageUrl()}}" alt="{{$post->user->name}}"
                        class="w-12 h-12 rounded-full inline-block">
                    <div>
                        <div class="flex">
                            <p class="text-gray-600">
                                By <span class="font-semibold">
                                    <a class="hover:underline"
                                        href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a>
                                </span>
                                &middot;&nbsp;
                                <div
                                    x-data="followersTracker(
                                        {{ $post->user->id }},
                                        {{ $post->user->followers->count() }},
                                        {{ $post->user->isFollowedBy(Auth::user()) ? 'true' : 'false' }})"
                                >
                                    <a
                                        class="cursor-pointer"
                                        :class="following ? 'text-red-500 hover:text-red-700' : 'text-green-500 hover:text-green-700' "
                                        x-text="following ? 'Unfollow' : 'Follow' " @click="follow()"
                                        >
                                    </a>
                                </div>
                            </p>
                        </div>
                        <p class="text-gray-500 text-sm">
                            {{$post->readTimeEstimation()}} min read &middot;
                            {{$post->postCreatedAt()}}
                        </p>
                    </div>
                </div>
                <!-- clap section -->
                <x-clap-button />
                <!-- Post Image -->
                <div class="mt-10">
                    <img src="{{$post->imageUrl()}}" alt="{{ $post->title }}" class="w-full h-auto rounded">
                </div>
                <!-- Post Content -->
                <div class="mt-10">
                    <p>{{ $post->content }}</p>
                </div>
                <!-- Post Category -->
                <div class="mt-6">
                    <span class="bg-gray-300 rounded-2xl px-4 py-2">{{$post->category->name}}</span>
                </div>
                <!-- clap section -->
                <x-clap-button />
            </div>
        </div>
    </div>
</x-app-layout>
