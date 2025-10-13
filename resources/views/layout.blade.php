<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>도서관</title>
    <link  href="{{ asset('my/css/layout.css') }}" rel="stylesheet">
    <link  href="{{ asset('my/css/bookIndex.css') }}" rel="stylesheet">
    <link  href="{{ asset('my/css/myBook.css') }}" rel="stylesheet">
    <link  href="{{ asset('my/css/loginModal.css') }}" rel="stylesheet">
    <link  href="{{ asset('my/css/pagination.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo"><a href="{{ route('main.index') }}">도서관</a></div>
            <div class="menu">
            @if (session()->get("rank")==1)
                <a href="{{ route('admin.index') }}" style="color: red">관리자 페이지</a>
            @endif
                <a href="{{ route('book.main_index', ['category_id' => 1]) }}">국내도서</a>
                <a href="{{ route('book.main_index', ['category_id' => 2]) }}">외국도서</a>
            @if (!session()->exists("clientName"))
                <a onclick="openModal()">로그인</a>
            @else
                <a href="{{ route('book.indexMyBook', ['id' => session('id')]) }}">내 도서</a>
                <a href="{{ url('client/logout') }}">로그아웃</a>
            @endif
            </div>
        </div>
    </header>
    @yield('content')


    <!-- 로그인 모달 -->
    <div class="overlay" id="loginModal">
        <div class="modal">
            <div class="header">
                <h2>로그인</h2>
            </div>
            <form method="POST" action="{{ url('client/check') }}">
            @csrf
                <input type="text" name="clientName"  placeholder="아이디" required>
                <input type="password" name="password" placeholder="비밀번호" required>
                <div class="button-container">
                    <button type="submit">로그인</button>
                    <button type="button" class="close" onclick="closeModal()">닫기</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2024 인터 도서관. All Rights Reserved.
    </footer>

    <script>
        // 모달 열기
        function openModal() {
            document.getElementById('loginModal').classList.add('active');
        }

        // 모달 닫기
        function closeModal() {
            document.getElementById('loginModal').classList.remove('active');
        }

        // 오버레이 배경 클릭 시 모달 닫기
        window.onclick = function(event) {
            if (event.target === document.getElementById('loginModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
