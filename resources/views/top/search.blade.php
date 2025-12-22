<div style="background-color: #f8f8f8">
    <div class="container">
        <div class="p-4">
            <h3 class="text-center text-primary mb-2">SEARCH</h3>
            <h2 class="title-line text-center mb-5">
                <div>案件を検索する</div>
                <span>案件を検索する</span>
            </h2>

            <div class="row mb-5">
                <div class="col-md-4">
                    <select name="s1" id="s1" class="form-select py-2">
                        <option value="">ジャンル</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="s1" id="s1" class="form-select py-2">
                        <option value="">スキルワード</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="s1" id="s1" class="form-select py-2">
                        <option value="">エリア（都道府県）</option>
                    </select>
                </div>
            </div>

            <div class="top-banner-button text-center mb-5">
                <a href="{{ 'javascript:;' }}" class="btn bg-primary text-white">
                    この条件で検索する <span class="rarr">&rarr;</span>
                </a>
                <div class="mt-2">該当件数：1000件</div>
            </div>

            <h2 class="text-center fw-bold mb-4">詳細条件検索</h2>

            <div class="search-detail pb-5 bg-white">
                <div class="search-detail-col">
                    <div class="th text-center py-3 selected border-right">
                        <div class="th-text border-right py-1 px-3">ジャンルで探す</div>
                    </div>
                </div>

                <div class="search-detail-col">
                    <div class="th text-center py-3 border-right">
                        <div class="th-text border-right py-1 px-3">エリアで探す</div>
                    </div>
                </div>

                <div class="search-detail-col">
                    <div class="th text-center py-3 border-right">
                        <div class="th-text border-right py-1 px-3">スキルワードで探す</div>
                    </div>
                </div>

                <div class="search-detail-col">
                    <div class="th text-center py-3 border-right">
                        <div class="th-text border-right py-1 px-3">希望単価で探す</div>
                    </div>
                </div>

                <div class="search-detail-col">
                    <div class="th text-center py-3 border-right">
                        <div class="th-text border-right py-1 px-3 no-border">特徴で探す</div>
                    </div>
                </div>
                @for ($i = 0; $i < 5; $i++)
                        <div class="td p-2 ms-4">
                            <small><i class="fa fa-chevron-right me-2"></i></small>
                            <span>Java</span>
                        </div>
                        <div class="td p-2 ms-4">
                            <small><i class="fa fa-chevron-right me-2"></i></small>
                            <span>.NET (VB/C#)</span>
                        </div>
                    @endfor
            </div>
        </div>
    </div>
</div>
