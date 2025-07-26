@props(['title', 'icon' => '', 'headerColor' => 'blue'])

@php
$headerColorClasses = [
    'blue' => 'bg-gradient-to-r from-blue-600 to-blue-700 text-white',
    'green' => 'bg-gradient-to-r from-green-600 to-green-700 text-white',
    'purple' => 'bg-gradient-to-r from-purple-600 to-purple-700 text-white',
    'red' => 'bg-gradient-to-r from-red-600 to-red-700 text-white',
    'gray' => 'bg-gray-50 text-gray-800 border-b border-gray-200',
];
$headerClass = $headerColorClasses[$headerColor] ?? $headerColorClasses['blue'];
@endphp

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    @if($title)
        <div class="{{ $headerClass }} p-6">
            <h3 class="text-lg font-semibold flex items-center">
                @if($icon)
                    <i class="bi bi-{{ $icon }} me-2"></i>
                @endif
                {{ $title }}
            </h3>
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div> 