@extends("layout")
@section("content")
<?
    $countBorrowedBooks = count($borrowedBooksData);
    $countWishlist = count($wishlist);
?>
<div class="container">
        <!-- User Info Section -->
        <aside class="user-info">
            <h3>내 정보</h3>
            <p>이름: {{$client->clientName}}</p>
            <p>이메일: {{$client->email}}</p>
            <hr>
            <p>대출 가능한 도서 수: {{$totalLoanAvailable-$countBorrowedBooks}}</p>
            <p>대출한 도서 수: {{$countBorrowedBooks}}</p>
            <p>찜한 도서 수: {{$countWishlist}}</p>
        </aside>

        <!-- Content Section -->
        <main class="content">
            <!-- Borrowed Books -->
            <div class="section">
                <h2>내가 대출한 도서</h2>
                <div class="book-list">
@foreach($borrowedBooksData as $borrowedBook)
                    <div class="book-card" onClick="window.location.href='{{ route('book.detail', $borrowedBook['book_id']) }}';"
                        style="cursor:pointer;">
                        <div class="book-image">
                        @if($borrowedBook['pic'])
                            @php
                                $pic = json_decode($borrowedBook['pic'], true); 
                            @endphp
                            <img src="{{ asset('/storage/product_img/'. $pic['path']) }}"
                                class="img-fluid img-thumbnail mymargin5">
                        @endif
                        </div>
                        <div class="book-info">
                            <p><b style="color:#2F4F4F;">{{$borrowedBook['title']}}</b></p>
                            <p><strong>반납 기한:</strong> {{$borrowedBook['due_date']}}
                            <?
                                if($borrowedBook['due_date'] < now() ){
                                    echo "(연체됨) </br><font color='red'>책을 반납해주세요.</font>";
                                }
                            ?>
                            </p>
                        </div>
                    </div>
@endforeach
                </div>
            </div>
<?
    if($borrowRequestBooksData){
?>
            <div class="section">
                <h2>내가 예약한 도서</h2>
                <div class="book-list">
@foreach($borrowRequestBooksData as $borrowRequestBook)
                    <div class="book-card" onClick="window.location.href='{{ route('book.detail', $borrowRequestBook['book_id']) }}';"
                        style="cursor:pointer;">
                        <div class="book-image">
                        @if($borrowRequestBook['pic'])
                            @php
                                $pic = json_decode($borrowRequestBook['pic'], true); 
                            @endphp
                            <img src="{{ asset('/storage/product_img/'. $pic['path']) }}"
                                class="img-fluid img-thumbnail mymargin5">
                        @endif
                        </div>
                        <div class="book-info">
                            <p><b style="color:#2F4F4F;">{{$borrowRequestBook['title']}}</b></p>
                            <?
                                $requestDate = \Carbon\Carbon::parse($borrowRequestBook['request_date']);
                                $date = $requestDate->addDays(3);
                            ?>
                            <p><strong>예약 기한:</strong> {{ $date->format('Y-m-d') }}</p>
                            <p><font color='blue'>예약일로부터 3일 안에 대출해주세요.</font></p>
                        </div>
                    </div>
                    <div class="delete-section">
                        <form action="{{ route('book.requestCancel', $borrowRequestBook['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="delete-button" type="submit" onClick="return confirm('취소할까요 ?');">취소</button>
                        </form>
                    </div>
@endforeach
                </div>
            </div>
<?
    }
?>
            <!-- Wishlist -->
            <div class="section">
                <h2>내가 찜한 도서</h2>
                <div class="book-list">
@foreach($wishlist as $wish)
                    <div class="book-card" onClick="window.location.href='{{ route('book.detail', $wish['book_id']) }}';"
                        style="cursor:pointer;">
                        <div class="book-image">
                        @if($wish['pic'])
                            @php
                                $pic = json_decode($wish['pic'], true); 
                            @endphp
                            <img src="{{ asset('/storage/product_img/'. $pic['path']) }}"
                                class="img-fluid img-thumbnail mymargin5">
                        @endif
                        </div>
                        <div class="book-info">
                        <p><b style="color:#2F4F4F;">{{ $wish['wishTitle'] }}</b></p>
                        <p>{{ $wish['author'] }}</p>
                        <p>
                        <?
                            if($wish['status']==0) echo "<font color='#8B0000'>대출중</font>";
                            elseif($wish['status']==1) echo "<font color='#1E90FF'>대출 가능</font>";
                            elseif($wish['status']==2) echo "<font color='#8B0000'>예약중</font>";
                        ?>
                        </p>
                        </div>
                    </div>
                    <div class="delete-section">
                        <form action="{{ route('book.wishDestroy', $wish['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="delete-button" type="submit" onClick="return confirm('삭제할까요 ?');">삭제</button>
                        </form>
                    </div>
@endforeach
                </div>
            </div>
        </main>
    </div>
</body>
@endsection