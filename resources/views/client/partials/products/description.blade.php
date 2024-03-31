<div class="product-info-tab bg-white rounded-2 overflow-hidden pt-6 mt-4">
    <ul class="nav nav-tabs border-bottom justify-content-center gap-5 pt-info-tab-nav">
        <li><a href="#description" class="active" data-bs-toggle="tab">Mô tả</a></li>
        <li><a href="#vedio" data-bs-toggle="tab">Đánh giá</a></li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active px-4 py-5" id="description">
            @if ($product->description)
                {!! $product->description !!}
            @else
                <div class="text-dark text-center border py-2">Không có nội dung
                </div>
            @endif
        </div>

        <div class="tab-pane fade px-4 py-5" id="vedio">

            đánh giá


        </div>


       
    </div>
    </div>
