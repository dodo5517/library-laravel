@extends('admin_layout')
@section('content')
<script>
    function find_text() {
        document.getElementById("form1").action = "{{ route('admin.borrowedBook.index') }}";
        document.getElementById("form1").submit();
    }
</script>
                    <div class="search-container">
                        <form id="form1" method="get">
                            <div class="search-options">
                                <select name="searchOption" class="search-select">
                                    <option value="book" {{ $searchOption == 'book' ? 'selected' : '' }}>도서</option>
                                    <option value="user" {{ $searchOption == 'user' ? 'selected' : '' }}>사용자</option>
                                </select>
                                <input type="text" name="text1" class="search-input" value="{{ $text1 }}" 
                                    onKeydown="if (event.keyCode == 13) { find_text(); }" placeholder="검색어를 입력하세요" />
                                <button type="button" onClick="find_text();" class="search-button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h6 class="m-0 font-weight-bold text-primary">반납 관리</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <th>번호</th>
                                            <th>사용자</th>
                                            <th>도서</th>
                                            <th>대출 일자</th>
                                            <th>반납 기한</th>
                                            <th>반납 일자</th>
                                            <th>📚</th>
                                        </tr>
                                    </thead>
@foreach($bookList as $row)
<?
    $returned_date = $row['returned_date'] ? $row['returned_date'] :'반납 안 함';
    
    // 오늘 날짜와 비교하여 연체 여부를 판단
    if ($row['due_date'] < date('Y-m-d') || $row['due_date'] < $row['returned_date']) {
        $returned_date .= " (연체됨)";
    }
?>
                                    <tbody>
                                        <tr>
                                            <th>{{$row['id']}}</th>
                                            <th><a href="{{ route('client.show', $row['client_id']) }}{{ $tmp }}">{{$row['clientName']}}</a></th>
                                            <th><a href="{{ route('book.show', $row['book_id']) }}{{ $tmp }}">{{$row['bookTitle']}}</a></th>
                                            <th>{{$row['borrow_date']}}</th>
                                            <th>{{$row['due_date']}}</th>
                                            <th>{{$returned_date}}</th>
                                            <th>
                                                <?
                                                    if (!$row['returned_date']) {
                                                        echo "
                                                            <div class='buttonGroup'>
                                                                <a href='" . route('admin.borrowedBook.returnBook', $row['id']) . $tmp . "'>
                                                                    <button>반납하기</button>
                                                                </a>
                                                            </div>";
                                                    }
                                                ?>
                                            </th>
                                        </tr>
                                    </tbody>
@endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{ $bookList->links('mypagination')}}
                        </div>
                    </div>
@endsection