@extends('admin_layout')
@section('content')
<style>
    #dataTable tbody tr {
    height: 20px; /* 원하는 높이로 설정 */
}
</style>
<script>
    function find_text() {
        document.getElementById("form1").action = "{{ route('admin.book.index') }}";
        document.getElementById("form1").submit();
    }
</script>
                    <div class="search-container">
                        <form id="form1" method="get">
                            <div class="search-options">
                                <input type="text" style="margin-left:20px;" name="text1" class="search-input" value="{{ $text1 }}" 
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
                                <h6 class="m-0 font-weight-bold text-primary">도서</h6>
                                <a href="{{ route('book.create') }}"><button class="btn btn-primary">추가</button></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>제목</th>
                                            <th>작가 /</br>카테고리</th>
                                            <th>장르</th>
                                            <th>출판일자</th>
                                            <th>줄거리</th>
                                            <th style="white-space: nowrap;">도서상태</th>
                                            <th>사진</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
@foreach($list as $row)
<?
    if($row['status']==0) { $status = '거절'; }
    elseif($row['status']==1) { $status = '대출 가능'; }
    elseif($row['status']==2) { $status = '예약중'; }
    $summary = \Str::limit($row->summary, 20, '...');
?>
                                    <tbody>
                                        <tr>
                                            <th>{{$row->id}}</th>
                                            <th><a href="{{ route('book.show', $row->id) }}{{ $tmp }}">{{$row->title}}</a></th>
                                            <th>{{$row->author}} / {{$row->category_name}}</th>
                                            <th>{{$row->genre}}</th>
                                            <th>{{$row->published_date}}</th>
                                            <th>{{$summary}}</th>
                                            <th>{{$status}}</th>
                                            <th>
                                                @if($row->pic)
                                                    @php
                                                        $pic = json_decode($row->pic, true); 
                                                    @endphp
                                                    {{ $pic['title'] ?? '파일 없음' }}
                                                @else
                                                    파일 없음
                                                @endif
                                            </th>
                                            <th>
                                                <div class="buttonGroup">
                                                <a href="{{ route('book.edit', $row->id) }}{{ $tmp }}"><button>✎</button></a>
                                                <form action="{{ route('book.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onClick="return confirm('삭제할까요 ?');">✖</button>
                                                </form>
                                                </div>
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
                            {{ $list->links('mypagination')}}
                        </div>
                    </div>
@endsection