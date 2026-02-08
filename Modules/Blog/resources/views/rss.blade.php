<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Blog VERTEXSEMAGRI</title>
        <description>Blog oficial da Secretaria Municipal de Agricultura de Coração de Maria - BA</description>
        <link>{{ url('/') }}</link>
        <atom:link href="{{ route('blog.rss') }}" rel="self" type="application/rss+xml" />
        <language>pt-BR</language>
        <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>
        <generator>VERTEXSEMAGRI Blog</generator>

        @foreach($posts as $post)
        <item>
            <title>{{ htmlspecialchars($post->title) }}</title>
            <description><![CDATA[
                @if($post->excerpt)
                    {!! htmlspecialchars($post->excerpt) !!}
                @else
                    {!! htmlspecialchars(Str::limit(strip_tags($post->content), 300)) !!}
                @endif
            ]]></description>
            <link>{{ route('blog.show', $post->slug) }}</link>
            <guid isPermaLink="true">{{ route('blog.show', $post->slug) }}</guid>
            <pubDate>{{ $post->published_at->toRfc2822String() }}</pubDate>
            @if($post->author)
            <author>{{ htmlspecialchars($post->author->email) }} ({{ htmlspecialchars($post->author->name) }})</author>
            @endif
            <category>{{ htmlspecialchars($post->category->name) }}</category>
        </item>
        @endforeach
    </channel>
</rss>
