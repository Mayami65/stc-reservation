@props(['type' => 'info', 'icon' => '', 'dismissible' => false])

@php
$typeClasses = [
    'success' => 'bg-green-50 border-green-200 text-green-700',
    'error' => 'bg-red-50 border-red-200 text-red-700',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
    'info' => 'bg-blue-50 border-blue-200 text-blue-700',
];

$iconClasses = [
    'success' => 'bi-check-circle text-green-600',
    'error' => 'bi-exclamation-triangle text-red-600',
    'warning' => 'bi-exclamation-triangle text-yellow-600',
    'info' => 'bi-info-circle text-blue-600',
];

$defaultIcons = [
    'success' => 'check-circle',
    'error' => 'exclamation-triangle',
    'warning' => 'exclamation-triangle',
    'info' => 'info-circle',
];

$alertClass = $typeClasses[$type] ?? $typeClasses['info'];
$iconToUse = $icon ?: $defaultIcons[$type];
$iconClass = $iconClasses[$type] ?? $iconClasses['info'];
@endphp

<div {{ $attributes->merge(['class' => "border rounded-lg p-4 {$alertClass}"]) }}>
    <div class="flex items-start">
        @if($iconToUse)
            <div class="flex-shrink-0">
                <i class="bi bi-{{ $iconToUse }} {{ $iconClass }} text-xl"></i>
            </div>
            <div class="ml-3 flex-1">
                {{ $slot }}
            </div>
        @else
            {{ $slot }}
        @endif
        
        @if($dismissible)
            <div class="flex-shrink-0 ml-4">
                <button type="button" class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>
        @endif
    </div>
</div> 