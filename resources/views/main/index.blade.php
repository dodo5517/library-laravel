@extends('layout')
@section('content')
<script>
    function find_text() {
        document.getElementById("form1").action = "{{ route('search') }}";
        document.getElementById("form1").submit();
    }
</script>
    <!-- 검색창 -->
    <form id="form1" method="get">
        <div class="search-bar">
            <select name="searchOption" id="search-option" class="search-option">
                <option value="all">통합</option>
                <option value="title">도서</option>
                <option value="author">작가</option>
            </select>

            <input name="text1" type="text" placeholder="검색어를 입력해주세요">
            <button class="search-button" onClick="find_text();" >검색</button>
        </div>
    </form>

    <div class="carousel">
        <button class="prev">〈</button>
            <img src="{{ asset('/my/img/slide1.jpg') }}" alt="slide1" class="carousel-image" />
        <button class="next">〉</button>
    </div>

    <section class="popular-books">
        <h2>인기도서</h2>
        <div class="book-list">
        @foreach ($popularList as $book)
            @if ($book->wishlist_count > 0)
                <div class="book" onClick="window.location.href='{{ route('book.detail', $book->id) }}';">
                @if($book->pic)
                    @php
                        $pic = json_decode($book->pic, true); 
                    @endphp
                    <img src="{{ asset('/storage/product_img/'. $pic['path']) }}"
                        class="img-fluid img-thumbnail mymargin5">
                @endif
                    <div class="book-info">
                        <p style="font-weight:900; color:#555;">{{ $book->title }}</p>
                        <p><strong>작가:</strong> {{ $book->author }}</p>
                        <p><strong>장르:</strong> {{ $book->genre }}</p>
                        <p><strong>도서 상태:</strong> 
                        <?
                            if($book->status==0) echo "<font color='#8B0000'>대출중</font>";
                            else echo "<font color='#1E90FF'>대출 가능</font>";
                        ?>
                        </p>
                        <p><strong>찜 횟수:</strong> {{ $book->wishlist_count }}</p>
                    </div>
                </div>
            @endif
        @endforeach
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const images = [
            "{{ asset('/my/img/slide1.jpg') }}", // 두 번째 이미지 경로
            "{{ asset('/my/img/slide2.jpg') }}", // 세 번째 이미지 경로
            "{{ asset('/my/img/slide3.jpg') }}", // 첫 번째 이미지 경로
        ];

        let currentIndex = 0;
        const carouselImage = document.querySelector(".carousel-image");
        const prevButton = document.querySelector(".prev");
        const nextButton = document.querySelector(".next");

        function updateImage(index) {
            carouselImage.src = images[index];
            carouselImage.alt = images[index];
        }

        prevButton.addEventListener("click", () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateImage(currentIndex);
        });

        nextButton.addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % images.length;
            updateImage(currentIndex);
        });

        // 초기 이미지 설정
        updateImage(currentIndex);
    });
    </script>
@endsection