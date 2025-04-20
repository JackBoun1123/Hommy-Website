<!-- Main content -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Giao diện chọn time</h2>
    <div class="row justify-content-center">
        <!-- Chọn ngày -->
        <?php
        if (!isset($_POST['chonngay']) && !isset($_POST['chongio'])) {
            $obj = new quanly();
            $options = '';
            $today = date('Y-m-d');
            $sql = "SELECT * FROM lichlamviec WHERE ngayDangKy >= '$today'";
            $arr = $obj->xuatdulieu($sql);
            for ($i = 0; $i < count($arr); $i++) {
                $options .= '<option value="' . $arr[$i]["ngayDangKy"] . '">' . $arr[$i]["ngayDangKy"] . '</option>';
            }

            // Lấy mã nhân viên môi giới ngẫu nhiên
            $sqlNhanVien = "SELECT maNVMG FROM nhanvienmoigioi ORDER BY RAND() LIMIT 1";
            $nhanVien = $obj->xuatdulieu($sqlNhanVien);
            $maNVMG = $nhanVien[0]["maNVMG"];

            // Lấy mã khách hàng từ session
            $maKhachHang = isset($_SESSION['maKH']) ? $_SESSION['maKH'] : '';

            echo '
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="card p-4 shadow-sm">
                    <h5 class="text-center mb-3">Chọn ngày</h5>
                    <form action="" method="POST" class="d-flex flex-column align-items-center">
                        <select name="STTchonngay" class="form-select mb-3" required>
                            <option value="">Chọn ngày</option>
                            ' . $options . '
                        </select>
                        <label for="gio">Chọn giờ:</label>
                        <input type="time" id="gio" name="gio" min="06:00" max="20:00" required>
                        <input type="hidden" name="manhanvien" value="' . $maNVMG . '">
                        <input type="hidden" name="makhachhang" value="' . $maKhachHang . '">
                        <button type="submit" name="chonngay" value="1" class="btn btn-primary">Chọn ngày</button>
                    </form>
                </div>
            </div>';
        }
        ?>

        <?php
        if (isset($_POST['chonngay'])) {
            $obj = new database();

            // Lấy dữ liệu từ POST
            $manhanvien = $_POST['manhanvien'];
            $makhachhang = $_POST['makhachhang'];
            $ngayDangKy = $_POST['STTchonngay'];
            $gio = $_POST['gio'];
            $mada = $_REQUEST['maduan']; // Giả định mã dự án là 1 (có thể thay đổi theo yêu cầu)
            
            // Câu lệnh SQL
            $sqlinsert = "INSERT INTO cuochen (ngayDienRa, thoiGian, maKH, maDA, maNhanVienMG) 
                          VALUES ('$ngayDangKy', '$gio', '$makhachhang', '$mada', '2')";

            // Thực thi câu lệnh SQL
            $result = $obj->themdulieu($sqlinsert);

            if ($result) {
                echo "<script>alert('Bạn đã hẹn lịch thành công!');</script>";
            } else {
                echo "<script>alert('Bạn đã hẹn lịch không thành công! Vui lòng thử lại.');</script>";
            }
        }
        ?>
    </div>
</div>

