@extends('admin_layout')
@section('content')
<script>
    function find_text() {
        document.getElementById("form1").action = "{{ route('admin.log.index') }}";
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
                                <h6 class="m-0 font-weight-bold text-primary">대출 로그</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <th>번호</th>
                                            <th>아이디</th>
                                            <th>도서</th>
                                            <th>요청 시간</th>
                                            <th>대출 요청</th>
                                            <th></th>
                                        </tr>
                                    </thead>
@foreach($log as $row)
<?
    if($row['status']==0) { $status = '거절'; }
    elseif($row['status']==1) { $status = '대출 승인'; }
    elseif($row['status']==2) { $status = '예약 신청'; }
    elseif($row['status']==3) { $status = '예약 취소'; }
?>
                                    <tbody>
                                        <tr>
                                            <th>{{$row['id']}}</th>
                                            <th><a href="{{ route('client.show', $row['client_id']) }}{{ $tmp }}">{{$row['clientName']}}</a></th>
                                            <th><a href="{{ route('book.show', $row['book_id']) }}{{ $tmp }}">{{$row['bookTitle']}}</a></th>
                                            <th>{{$row['request_date']}}</th>
                                            <th>{{$status}}</th>
                                            <th>
                                            <?
                                                if($row['status']==2) {
                                                    echo
                                                    "<div class='buttonGroup'>
                                                        <a href='" . route('admin.borrowedBook.approve', $row['id']) . $tmp . "'>
                                                            <button>대출 승인</button>
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
                            {{ $log->links('mypagination')}}
                        </div>
                    </div>
@endsection