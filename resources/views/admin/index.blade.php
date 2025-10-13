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
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h6 class="m-0 font-weight-bold text-primary">인기 도서</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>제목</th>
                                            <th>작가</th>
                                            <th style="white-space: nowrap;">도서 상태</th>
                                            <th>찜 횟수</th>
                                            <th>도서 상태</th>
                                        </tr>
                                    </thead>
@foreach($popularList as $book)
<?
    if($book['status']==0) { $status = '대출 불가능'; }
    elseif($book['status']==1) { $status = '대출 가능'; }
    elseif($book['status']==2) { $status = '예약중'; }
?>
                                    <tbody>
                                        <tr>
                                            <th>{{$book->id}}</th>
                                            <th><a href="{{ route('book.show', $book->id) }}">{{$book->title}}</a></th>
                                            <th>{{$book->author}}</th>
                                            <th>{{$book->genre}}</th>
                                            <th>{{$book->wishlist_count}}</th>
                                            <th>{{$status}}</th>
                                        </tr>
                                    </tbody>
@endforeach
                                </table>
                            </div>
                        </div>
                    </div>
@endsection