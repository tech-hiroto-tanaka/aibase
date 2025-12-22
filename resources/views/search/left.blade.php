<div class="col-md-4 border-right search-left py-5">
    <div class="search-filters p-4">
        <h5 class="title-line mb-3">
            <div>案件検索</div>
            <span>案件検索</span>
        </h5>

        <div class="d-flex align-items-center mb-3">
            <input type="text" class="form-control py-3" placeholder="キーワード検索">

            <div class="flex-shrink-0 ms-3 text-primary">
                <i class="fa fa-search fa-2x"></i>
            </div>
        </div>

        <div class="search-filter-box p-3">
            <!-- bootstrap 5 collapse not working -->
            @foreach ($filters as $filter)
                <div class="py-3">
                    <div class="box-title d-flex align-items-center pb-2 fw-bold">
                        <div class="flex-grow-1">{{ $filter }}</div>
                        <i class="flex-shrink-0 ms-2 fa fa-chevron-circle-down text-primary" style="font-size: 1.5em"
                            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $filter }}"></i>
                    </div>

                    <div class="box-values mt-2 collapse" id="collapse-{{ $filter }}">
                        @foreach ($values as $item)
                            <div class="form-check mb-2">
                                <input class="form-check-input rounded-0" type="checkbox" value=""
                                    id="{{ $filter . '_' . $item }}">
                                <label class="form-check-label" for="{{ $filter . '_' . $item }}">
                                    {{ $item }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div style="background-color: rgb(248, 248, 248)" class="py-4">
            <div class="text-center mb-3 fw-bold">該当案件数</div>
            <div class="text-center d-flex justify-content-center align-items-end">
                <h1 class="mb-0">5</h1>
                <span class="fw-bold">件</span>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn rounded-0 btn-search w-100 py-2">条件をクリア</button>
            <button class="btn rounded-0 btn-search w-100 py-2">検索</button>
        </div>
    </div>
</div>


@section('javascript')
    <script type="text/javascript">
        $(document).on('click', '[data-bs-toggle="collapse"]', function() {
            if (!$(this).attr('data-bs-target')) {
                return;
            }
            const $collapse = $(`${$(this).attr('data-bs-target')}`);

            if ($collapse.is(':visible')) {
                $(this).css({
                    transition: '0.2s',
                    transform: 'rotate(0deg)'
                });
                $(this).closest('.box-title').removeClass('open');
            } else {
                $(this).css({
                    transition: '0.2s',
                    transform: 'rotate(180deg)'
                });
                $(this).closest('.box-title').addClass('open');
            }

            $collapse.slideToggle(200);
        })
    </script>
@endsection
