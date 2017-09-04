<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(count($novel) > 0)
    <sitemap>
        <loc>{{ route('index.novel.list') }}</loc>
        <lastmod>{{ $novel->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif

    @if(count($chapter) > 0)
    <sitemap>
        <loc>{{ $chapter->url }}</loc>
        <lastmod>{{ $chapter->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif

    @if(count($user) > 0)
    <sitemap>
        <loc>{{ route('index') }}</loc>
        <lastmod>{{ $user->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
</sitemapindex>