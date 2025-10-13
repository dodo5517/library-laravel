@extends('admin_layout')
@section('content')
<script>
    function find_text() {
        document.getElementById("form1").action = "{{ route('admin.category.index') }}";
        document.getElementById("form1").submit();
    }
</script>
                    <div class="search-container">
                        <form id="form1" method="get">
                            <div class="search-options">
                                <input type="text" name="text1" style="margin-left:20px;" class="search-input" value="{{ $text1 }}" 
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
                                <h6 class="m-0 font-weight-bold text-primary">카테고리</h6>
                                <a href="{{ route('category.create') }}{{ $tmp }}"><button class="btn btn-primary">추가</button></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="border-collapse: separate;">
                                    <thead>
                                        <tr>
                                            <th>번호</th>
                                            <th>이름</th>
                                            <th></th>
                                        </tr>
                                    </thead>
@foreach($list as $row)
                                    <tbody>
                                        <tr>
                                            <th>{{$row->id}}</th>
                                            <th><a href="{{ route('category.show', $row->id) }}{{ $tmp }}">{{$row->name}}</a></th>
                                            <th class="buttonGroup">
                                                <a href="{{ route('category.edit', $row->id) }}{{ $tmp }}"><button>✎</button></a>
                                                <form action="{{ route('category.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onClick="return confirm('삭제할까요 ?');">✖</button>
                                                  </form>
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