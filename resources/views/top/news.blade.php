<div class="container bg-white py-5">

    <h3 class="text-center mt-5 mb-2 text-primary">NEWS</h3>
    <h2 class="text-center mb-5">お知らせ</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="top-news-list">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            @for ($i = 0; $i <= 2; $i++)
                                <tr>
                                    <td>2020.xx.xx</td>
                                    <td><span class="badge bg-warning text-black px-3"
                                            style="border-radius: 30px">お知らせ</span></td>
                                    <td style="width: 60%">HPをオープンしました。</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="javascript:;">もっと見る</a> <small><i class="fa fa-chevron-right"></i></small>
            </div>
        </div>
    </div>


</div>
