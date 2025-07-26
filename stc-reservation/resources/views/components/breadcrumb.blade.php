@props(['items' => []])

@if(count($items) > 0)
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-600">
        @foreach($items as $index => $item)
            <li>
                @if($index < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="hover:text-blue-600 transition">
                        {{ $item['title'] }}
                    </a>
                @else
                    <span class="text-gray-800 font-medium">{{ $item['title'] }}</span>
                @endif
            </li>
            @if($index < count($items) - 1)
                <li><i class="bi bi-chevron-right"></i></li>
            @endif
        @endforeach
    </ol>
</nav>
@endif 