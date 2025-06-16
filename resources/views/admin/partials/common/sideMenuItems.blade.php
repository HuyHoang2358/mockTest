@php
    $pageExists = false;
    foreach ($pageTags as $tag) {
        if (array_key_exists($page, $tag)) {
            $pageExists = true;
            $pageData = $tag[$page]; // Store the matched page data
            break;
        }
    }
    $firstElement = reset($pageTags);
    $firstKey = key($firstElement);
    $firstValue = $firstElement[$firstKey];
    //dd($firstValue);
@endphp

<li>
    <a href="{{ !array_key_exists('route', $firstValue) || ($firstValue['route'] == '') ? '#' : route($firstValue['route']) }}" class="side-menu {{($firstElement && $pageExists) ? 'side-menu--active' : ''}}">
        <div class="side-menu__icon"> <i data-lucide="{{ $firstValue['icon'] }}"></i> </div>
        <div class="side-menu__title">
            {{ $firstValue['display'] }}
            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
        </div>
    </a>
    <ul class="{{$pageExists ? 'side-menu__sub-open' : ''}}">
        @foreach($pageTags as $index => $tags)
            @if ($loop->first)
                @continue
            @endif
            @php
                $key = key($tags); // Get the key of the current item
                $item = $tags[$key]; // Get the value (array) associated with the key
            @endphp
            <li class="pl-4">
                <a href="{{ !array_key_exists('route', $item) || ($item['route'] == '') ? '#' : route($item['route']) }}" class="side-menu {{isset($page) ? $page == $key? 'side-menu--active' : '' : ''}}">
                    <div class="side-menu__icon"> <i data-lucide="{{ $item['icon'] }}"></i> </div>
                    <div class="side-menu__title"> {{ $item['display'] }} </div>
                </a>
            </li>
        @endforeach
    </ul>
</li>
