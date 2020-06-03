@if (is_string($item))
    <li class="header">{{ $item }}</li>
@else
    <li class="@if (isset($item['submenu'])) treeview @endif {{ $item['class'] or '' }} {{ Request::is($item['url'] ?? '') ? 'active' : '' }}">
        <a href="{{ url($item['url'] ?? '') }}"
           @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
        >
            <i class="fa fa-fw fa-{{ $item['icon'] or 'circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
            <span>{{ $item['text'] }}</span>
            @if (isset($item['label']))
                <span class="pull-right-container">
                    @if (is_array($item['label']))
                        @foreach ($item['label'] as $label)
                            <span class="label label-{{ $label['label_color'] or 'primary' }} pull-right">{{ $label['label'] }}</span>
                        @endforeach
                    @else
                        <span class="label label-{{ $item['label_color'] or 'primary' }} pull-right">{{ $item['label'] }}</span>
                    @endif
                </span>
            @elseif (isset($item['submenu']))
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            @endif
        </a>
        @if (isset($item['submenu']))
            <ul class="treeview-menu {{ $item['submenu_class'] or '' }}">
                @each('layout.partials.sidebar.menu-item', $item['submenu'], 'item')
            </ul>
        @endif
    </li>
@endif