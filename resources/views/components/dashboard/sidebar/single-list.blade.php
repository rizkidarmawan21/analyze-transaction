@props(['active', 'label', 'url'])

@php
    $classes =
        $active ?? false
            ? 'group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 bg-graydark dark:bg-meta-4'
            : 'group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4';
@endphp
<li>
    <a {{ $attributes->merge(['class' => $classes]) }} href="{{ $url }}">
        {{ $slot }}
    </a>
</li>
