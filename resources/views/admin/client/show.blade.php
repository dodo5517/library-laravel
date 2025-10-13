@extends('admin_layout')
@section('content')
<?
    $tel1=trim(substr($row->tel,0,3));
    $tel2=trim(substr($row->tel,3,4));
    $tel3=trim(substr($row->tel,7,4));
    $tel = $tel1."-".$tel2."-".$tel3;
    $rank = $row->rank==0 ? '사용자':'관리자';
?>
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">사용자 상세페이지</h1>
  <div class="card shadow mb-4">
        <!-- User Details -->
        <div class="card-body">
            <div class="detail">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="row" class="text-gray-800">번호</th>
                    <td>{{ $row->id }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">아이디</th>
                    <td>{{ $row->clientName }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">암호</th>
                    <td>{{ $row->password }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">전화번호</th>
                    <td>{{ $tel }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">이메일</th>
                    <td>{{ $row->email }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">등급</th>
                    <td>{{ $rank }}</td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="cardButtonDiv">
                <a href="{{ route('client.edit', $row->id) }}{{ $tmp }}"><button class="btn btn-primary">수정</button></a>
                <form action="{{ route('client.destroy', $row->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onClick="return confirm('삭제할까요 ?');">삭제</button>
                </form>
                <input type="button" value="뒤로가기" class="btn btn-secondary" onClick="history.back();">
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection