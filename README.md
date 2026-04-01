# CycleTrust — Mua bán xe đạp thể thao cũ

**Đồ án UTH** — Nền tảng rao vặt xe đạp thể thao đã qua sử dụng, tập trung minh bạch thông tin và trải nghiệm người dùng.

## Mô tả

CycleTrust được xây dựng bằng **PHP thuần (Native)**, kết nối cơ sở dữ liệu qua **PDO** (prepared statements), giao diện **Bootstrap 5** và **Font Awesome**. Dự án gồm đăng ký / đăng nhập, đăng tin xe (upload ảnh), danh sách có phân trang, trang chi tiết và quản lý tin đăng cơ bản.

## Yêu cầu môi trường

- PHP 8.x (khuyến nghị 8.1+)
- MySQL hoặc MariaDB
- Apache với mod_rewrite (hoặc máy chủ tương đương), ví dụ **XAMPP**
- Extension PHP: `pdo_mysql`, `fileinfo` (khuyến nghị cho upload ảnh)

## Hướng dẫn cài đặt (cho Giảng viên / người chấm)

### 1. Clone mã nguồn

```bash
git clone <URL-repository-GitHub-của-sinh-viên>.git
cd CycleTrust
```

Thay `<URL-repository-GitHub-của-sinh-viên>` bằng URL thật (HTTPS hoặc SSH) do nhóm cung cấp.

### 2. Cấu hình web server

- Đặt thư mục dự án vào `htdocs` (XAMPP) hoặc document root tương ứng.
- Trỏ trình duyệt tới thư mục chứa `index.php`, ví dụ:  
  `http://localhost/CycleTrust/`

### 3. Tạo database và import dữ liệu mẫu

1. M mở **phpMyAdmin** (hoặc MySQL CLI).
2. Tạo database tên: **`cycle_trust`** (utf8mb4 nếu được hỏi).
3. Chọn database `cycle_trust` → tab **Import**.
4. Chọn file: **`database/database.sql`** trong thư mục dự án.
5. Thực hiện import và kiểm tra không báo lỗi.

File dump mặc định dùng tên database `cycle_trust` (thống nhất với `config/config.php`).

### 4. Cấu hình kết nối PHP (nếu cần)

Mở `config/config.php` và chỉnh cho đúng môi trường local:

- `BASE_URL` (ví dụ: `http://localhost/CycleTrust/`)
- `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`

Mặc định thường dùng với XAMPP: `root`, mật khẩu rỗng.

### 5. Quyền thư mục upload

Đảm bảo thư mục `public/uploads/` (và các thư mục con như `bikes/`, `products/` nếu có) cho phép ghi khi chạy đăng tin có upload ảnh.

---

## Tài khoản mặc định trong file SQL mẫu

Trong **`database/database.sql`**, bảng `users` có **dữ liệu mẫu**:

| Username | Email   | Vai trò (`role`) | Ghi chú |
|----------|---------|------------------|---------|
| `pain1`  | `p@p.com` | `user`         | Mật khẩu lưu dạng **bcrypt** trong dump; không kèm plain-text. |

**Không có tài khoản `admin` riêng được seed sẵn** trong file dump này (chỉ enum `admin`/`user` trên cột `role`).

**Gợi ý cho giảng viên:**

- Dùng chức năng **Đăng ký** trên website để tạo user mới và đăng nhập, hoặc
- Trong phpMyAdmin tạo user mới / cập nhật cột `password` bằng hash từ `password_hash()` trong PHP.

## Cấu trúc thư mục (rút gọn)

```
CycleTrust/
├── config/           # Cấu hình, PDO
├── database/         # File SQL dump (import vào cycle_trust)
├── includes/         # Header, footer, hàm dùng chung
├── modules/          # Xử lý auth, bike, ...
├── pages/            # Các trang nội dung (router include)
├── public/           # CSS, JS, uploads (public)
├── index.php         # Điểm vào, router đơn giản
└── README.md
```

## Tác giả / môn học

Đồ án **UTH** — CycleTrust.

---

*Nếu có thắc mắc kỹ thuật khi chạy thử (404, lỗi PDO, import SQL), sinh viên nên kiểm tra `BASE_URL`, tên database `cycle_trust`, và log lỗi PHP/Apache.*
