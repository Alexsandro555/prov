@if ($breadcrumbs->count())
    <ol class="breadcrumb hidden-sm-and-down">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url() && $loop->remaining)
                <li class="breadcrumb__item"><a href="{{ $breadcrumb->url() }}">{{ $breadcrumb->title() }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title() }}</li>
            @endif
        @endforeach
    </ol>
@endif
