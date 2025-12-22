<div class="col-md-8 search-right py-5">
    <div class="search-results p-4 pt-0">
        <div class="d-flex align-items-center pb-3 search-result-title">
            <h3 class="fw-bold flex-grow-1 mb-0">一覧【検索結果】</h3>
            <div class="flex-shrink-0">新着順</div>
            <div class="flex-shrink-0 ms-5">
                <i class="fa fa-chevron-circle-down text-primary" style="font-size: 1.5em"></i>
            </div>
        </div>

        <div class="search-result-list py-4">
            <div class="row favorite-row">
                @for ($i = 0; $i <= 5; $i++)
                    <div class="col-md-6">
                        {{-- <favorite></favorite> --}}
                    </div>
                @endfor
            </div>

            <!-- Laravel public paginate view will custom for all -->
            <div class="d-flex justify-content-center mt-5">
                <a href="javascript:;" class="fw-bold mx-3">1</a>
                <a href="javascript:;" class="mx-3">2</a>
                <a href="javascript:;" class="mx-3">3</a>
                <a href="javascript:;" class="mx-3">4</a>
                <a href="javascript:;" class="mx-3">5</a>
            </div>
        </div>
    </div>
</div>
