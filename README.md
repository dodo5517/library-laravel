# 도서관 웹사이트 (Laravel)

> **기간:** 2024.11.18 ~ 2024.12.19  
> **개인 프로젝트**  
> 사용자가 온라인으로 도서 대출 예약을 신청하고, 도서 정보를 검색하여 확인할 수 있는 **도서관 관리 웹사이트**입니다.

---

## 화면 미리보기

### 메인
<table>
  <tr>
    <td><img width="500" src="https://github.com/user-attachments/assets/2ff943d5-94ac-4626-b6bb-45f709b2de50" /></td>
    <td><img width="500"src="https://github.com/user-attachments/assets/963623db-63ba-48bd-8f64-386b4c15838c" /></td>
  </tr>
</table>

### 관리자
<table>
  <tr>
    <td><img width="500"src="https://github.com/user-attachments/assets/c6b954d1-813b-4569-b2c8-86346da3410d" /></td>
    <td><img width="500" src="https://github.com/user-attachments/assets/26cc8136-1970-47fb-a5b6-27bdbeabf3b1" /></td>
  </tr>
</table>

---

## 데모

[데모 바로가기](https://library.kimdohyeon.dev/)

---

## Ⅰ 프로젝트 개요

이 프로젝트는 **Laravel PHP Framework**를 활용하여 개발된 웹 기반 도서관 시스템으로,  
도서 검색, 대출, 반납, 예약 등 기본적인 도서관 서비스 기능을 웹 환경에서 제공하는 것을 목표로 했습니다.  
관리자는 도서와 회원, 대출 요청을 효율적으로 관리할 수 있으며,  
사용자는 도서 검색부터 예약까지 온라인으로 간편하게 이용할 수 있습니다.

- **운영 체제:** Linux  
- **개발 도구:** PHP (Laravel), phpMyAdmin, Bootstrap, VSCode  
- **데이터베이스:** MariaDB  

---

## Ⅱ 개발 목적

- **사용자 편의성 향상:** 오프라인 방문 없이 도서 검색 및 대출 예약 가능  
- **관리 효율성 강화:** 도서, 회원, 카테고리, 대출 요청을 한눈에 관리할 수 있는 백오피스 구축  
- **Laravel 기반의 MVC 구조 이해 및 실무 감각 향상**  

---

## Ⅲ 주요 기능

###  사용자(User)
- 회원 로그인 / 로그아웃  
- 도서 검색 및 상세정보 조회  
- 도서 찜 기능 (즐겨찾기)  
- 도서 대출 예약 신청  
- 나의 예약 / 대출 내역 확인  

###  관리자(Admin)
- 도서 등록 / 수정 / 삭제  
- 사용자 관리 (회원 정보, 권한 관리)  
- 대출 요청 승인 / 반납 처리  
- 카테고리 관리 (장르, 주제 등)  
- 전체 대출 현황 및 통계 조회  

---

## Ⅳ 기술 스택

| 구분 | 사용 기술 |
|------|------------|
| **Framework** | Laravel 10 (PHP 8.x) |
| **Frontend** | Bootstrap 5, Blade Template |
| **Backend** | PHP, Laravel Routing / Controller / Eloquent ORM |
| **Database** | MariaDB |
| **Tool** | phpMyAdmin, VSCode |
| **OS** | Linux |

---

## Ⅴ 프로젝트 구조

/library  
├── app/  
│ ├── Http/  
│ │ ├── Controllers/  
│ │ │ ├── BookController.php  
│ │ │ ├── UserController.php  
│ │ │ ├── AdminController.php  
│ │ │ └── BorrowController.php  
│ ├── Models/  
│ │ ├── Book.php  
│ │ ├── User.php  
│ │ ├── Borrow.php  
│ │ └── Category.php  
│ └── Providers/  
│  
├── resources/  
│ ├── views/  
│ │ ├── books/  
│ │ ├── admin/  
│ │ └── auth/  
│ └── css/  
│  
├── routes/  
│ └── web.php  
│  
├── database/  
│ ├── migrations/  
│ ├── seeders/  
│ └── factories/  
│  
├── public/  
│ ├── css/  
│ ├── js/  
│ └── images/  
└── composer.json  

---

## Ⅵ 실행 방법

```bash
# 1. 프로젝트 클론
git clone https://github.com/yourusername/library-laravel.git
cd library-laravel

# 2. 의존성 설치
composer install

# 3. 환경 설정 파일 복사
cp .env.example .env

# 4. .env 파일 수정
# 자신의 데이터베이스 환경에 맞게 설정해야 합니다.
# (phpMyAdmin 또는 MariaDB 설정에 따라 다를 수 있습니다.)
nano .env

# 5. 애플리케이션 키 생성
php artisan key:generate

# 6. 데이터베이스 마이그레이션 및 시더 실행
php artisan migrate --seed

# 7. 서버 실행
php artisan serve
```

