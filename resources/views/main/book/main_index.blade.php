@extends('layout')
@section('content')

<script>
		function find_text()
		{
			document.getElementById("form1").action = "{{ route('book.main_index', ['category_id' => $category_id ] ) }}";
            document.getElementById("form1").submit();
		}
</script>

<body>
    <form id="form1" method="get">
        <!-- 검색창 -->
        <div class="search-bar">
            <select name="searchOption" id="search-option" class="search-option">
                <option value="all" {{ $searchOption == 'all' ? 'selected' : '' }}>통합</option>
                <option value="title" {{ $searchOption == 'title' ? 'selected' : '' }}>제목</option>
                <option value="author" {{ $searchOption == 'author' ? 'selected' : '' }}>작가</option>
            </select>
            <input type="text" name="text1" value="{{ $text1 }}" 
                onKeydown="if (event.keyCode == 13) { find_text(); }" placeholder="검색어를 입력해주세요">
            <button type="button" onClick="find_text();" >검색</button>
        </div>
    </form>

    <!-- 메인 콘텐츠 -->
    <div class="library-container">
        <?
            $title = $category_id == 1 ? "국내 도서" : "외국 도서";
        ?>
        <h2>{{$title}}</h2>
        <div class="library-book-list">
@foreach($list as $row)
        <div class="library-book-item" onClick="window.location.href='{{ route('book.detail', $row->id) }}{{ $tmp }}';"
            style="cursor:pointer;">
        @if($row->pic)
            @php
                $pic = json_decode($row->pic, true); 
            @endphp
            <img src="{{ asset('/storage/product_img/'. $pic['path']) }}"
                class="img-fluid img-thumbnail mymargin5">
        @else
            <img src="https://via.placeholder.com/80x100">
        @endif
            <div class="library-book-info">
                <p><strong>{{$row->title}}</strong></p>
                <p><strong>작가: </strong>{{$row->author}}</p>
                <p><strong>출판일자: </strong>{{$row->published_date}}</p>
                <p><strong>상태: </strong>
                <?
                    if($row->status==0) echo "<font color='#8B0000'>대출중</font>";
                    elseif($row->status==1) echo "<font color='#1E90FF'>대출 가능</font>";
                    elseif($row->status==2) echo "<font color='#8B0000'>예약중</font>";
                ?>
                </p>
            </div>
        </div>
@endforeach
        </div>
        <div class="row">
            <div class="col">
                {{ $list->links('mypagination')}}
            </div>
        </div>
    </div>
</body>

@endsection