{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}

@component('mail::message')
# {{ $post->title }}

{{ Str::limit($post->body, 120) }}

@component('mail::button', ['url' => route('post.show',
        [
            'username' => $post->user->username,
            'post' => $post->slug
        ])
    ])
Read Full Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
