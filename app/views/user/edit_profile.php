<?php require_once '../app/views/inc/header.php'; ?>

<div style="max-width: 500px; margin: 50px auto; padding: 30px; background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); font-family: 'Segoe UI', sans-serif;">
    <h2 style="text-align: center; margin-bottom: 25px;">📝 Chỉnh sửa thông tin</h2>
    
    <form action="<?= URLROOT ?>/user/edit_profile" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Họ và tên:</label>
            <input type="text" name="fullname" value="<?= $data['user']['fullname'] ?>" required 
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
        </div>
        
        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Số điện thoại:</label>
            <input type="text" name="phone" value="<?= $data['user']['phone'] ?>" required
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
        </div>

        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" value="<?= $data['user']['email'] ?>" required
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
        </div>

        <div>
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Mật khẩu mới (Để trống nếu không đổi):</label>
            <input type="password" name="password" placeholder="********"
                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 15px;">
            <button type="submit" style="flex: 2; padding: 13px; background: #28a745; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                Lưu thay đổi
            </button>
            <a href="<?= URLROOT ?>/user/profile" style="flex: 1; padding: 13px; background: #6c757d; color: white; text-decoration: none; text-align: center; border-radius: 8px; font-weight: bold; transition: 0.3s;">
                Quay lại
            </a>
        </div>
    </form>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>