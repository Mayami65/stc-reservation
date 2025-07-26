@props(['href', 'icon', 'title', 'description', 'iconColor' => 'blue'])

@php
$iconColorClasses = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'red' => 'bg-red-100 text-red-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
];
$iconClass = $iconColorClasses[$iconColor] ?? $iconColorClasses['blue'];
@endphp

<a href="{{ $href }}" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
    <div class="flex items-center">
        <div class="p-3 {{ $iconClass }} rounded-full">
            <i class="bi bi-{{ $icon }} text-xl"></i>
        </div>
        <div class="ml-4">
            <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
            <p class="text-gray-600 text-sm">{{ $description }}</p>
        </div>
    </div>
</a> 