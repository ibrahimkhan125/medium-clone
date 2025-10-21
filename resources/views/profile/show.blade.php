<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1">
                        <h1 class="font-bold text-4xl">{{ $user->name }}</h1>
                        <x-post-list :posts="$posts"></x-post-list>
                    </div>
                    <div
                        class="w-[320px] px-8 border-1"
                        x-data="followersTracker(
                        {{ $user->id }},
                        {{ $user->followers->count() }},
                        {{ $user->isFollowedBy(Auth::user()) ? 'true' : 'false' }})"
                    >
                        <img src="{{$user->imageUrl()}}" alt="{{$user->name}}"
                            class="w-24 h-24 rounded-full inline-block">
                        <h4 class="font-bold pt-4"> {{ $user->name }} </h4>
                                <p
                                    x-text="FollowersCount <= 1 ? FollowersCount + ' Follower' : FollowersCount + ' Followers' ">
                                </p>
                                @if(Auth()->user() && Auth()->user()->id !== $user->id)
                                    <button @click="follow()" class="mt-2 text-white rounded-full px-6 py-2"
                                        x-text="following ?  'Unfollow' : 'Follow' " :class="following ? 'bg-red-500 hover:bg-red-700'
                                        : 'bg-green-500 hover:bg-green-700' ">
                                    </button>
                                @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
