@extends('admin_layout')
@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">사용자 추가</h1>

    <form name="form1" method="post" action="{{ route('client.store') }}{{ $tmp }}">
	@csrf

        <div class="card shadow mb-4">
            <!-- User Details -->
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row" class="text-gray-800">번호</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">아이디<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="clientName" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                            @error('clientName') {{ $message }} @enderror
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">암호<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="password" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                            @error('password') {{ $message }} @enderror
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">전화번호</th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="tel1" size="3" maxlength="3" value="" class="form-control form-control-sm">-
                                <input type="text" name="tel2" size="4" maxlength="4" value="" class="form-control form-control-sm">-
                                <input type="text" name="tel3" size="4" maxlength="4" value="" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">이메일</th>
                        <td>
                            <div class="editInput d-inline-flex">
                            <input type="text" name="email" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">등급</th>
                        <td>
                            <div class="editInput">
                            <input type="radio" name="rank" value="0" checked>&nbsp;사용자&nbsp;&nbsp;
                            <input type="radio" name="rank" value="1">&nbsp;관리자
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="cardButtonDiv">
                    <input type="submit" value="저장" class="btn btn-primary">
                    <input type="button" value="뒤로가기" class="btn btn-secondary">
                </div>
            </div>
        </div>
    </form>
@endsection