<div class="container bg-white">
    <div class="p-4">
        @if (!empty($h3))
            <h3 class="text-center text-primary mb-2">{!! $h3 !!}</h3>
        @endif

        @if (!empty($h2))
            <h2 class="text-center mb-4">{!! $h2 !!}</h2>
        @endif

        <div class="row favorite-row">
            <!-- Using data $items & foreach -->
            @for ($i = 0; $i <= 2; $i++)
                <div class="col-md-4">
                    <favorite></favorite>
                </div>
            @endfor
        </div>

        <div class="text-center mb-5">
            <a href="{{ $moreUrl ?? 'javascript:;' }}" class="event-link">もっと見る</a> <small><i class="fa fa-chevron-right"></i></small>
        </div>
    </div>
</div>
