@extends('layout')
@section('content')
<?
    $status = $row->status==1 ? '대출 가능':'대출 불가능';
?>
<body>
    @if(session('success'))
        <script type="text/javascript">
            alert("{{ session('success') }}");  // 세션의 success 메시지를 alert로 출력
            history.go(0);
        </script>
    @endif

    @if(session('error'))
    <script type="text/javascript">
        alert("{{ session('error') }}");  // 세션의 error 메시지를 alert로 출력
        history.go(0);
    </script>
    @endif

    <div class="book-details">
        <div class="book-image">                    
            @if($row->pic)
                @php
                    $pic = json_decode($row->pic, true); 
                @endphp
                <img src="{{ asset('/storage/product_img/'. $pic['path']) }}"
                    style="max-width:250px;" class="img-fluid img-thumbnail mymargin5">
            @endif
        </div>
        <div class="book-info">
            <h1>{{$row->title}}</h1>
            <p>작가: {{$row->author}}</p>
            <p>장르: {{$row->genre}}</p>
            <p>출판일자: {{$row->published_date}}</p>
            <p>도서 상태: 
            <?
                if($row->status==0) echo "<font color='#8B0000'>대출중</font>";
                elseif($row->status==1) echo "<font color='#1E90FF'>대출 가능</font>";
                elseif($row->status==2) echo "<font color='#8B0000'>예약중</font>";
            ?>
            </p>
            <div class="bookButton">
                <a href="{{ route('book.borrow',['client_id' => session('id'), 'book_id'=> $row->id]) }}" class="borrow-button">예약하기</a>
                <a href="{{ route('book.wish',['client_id' => session('id'), 'book_id'=> $row->id]) }}" class="wish-button">찜하기</a>
            </div>
        </div>
    </div>

    <div class="book-description">
        <h2>책 소개</h2>
        <p>{{$row->summary}}</p>
    </div>
</body>

@endsection
