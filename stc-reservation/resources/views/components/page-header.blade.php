@props(['title', 'description' => '', 'icon' => ''])

<div class="text-center mb-8">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
        @if($icon)
            <i class="bi bi-{{ $icon }} text-blue-600 me-2"></i>
        @endif
        {{ $title }}
    </h1>
    @if($description)
        <p class="text-gray-600">{{ $description }}</p>
    @endif
</div> 