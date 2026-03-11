<div style="max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 20px rgba(0,0,0,0.1); font-family: sans-serif;">
    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 10px;">Chi tiết Đặt chỗ #<?php echo $data['booking']['id']; ?></h2>
    
    <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($data['booking']['user_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($data['booking']['user_email']); ?></p>
    <p><strong>Số điện thoại:</strong> <span style="color: #007bff; font-size: 1.2rem;"><?php echo htmlspecialchars($data['booking']['phone']); ?></span></p>
    <p><strong>Địa danh:</strong> <?php echo htmlspecialchars($data['booking']['place_name']); ?></p>
    <p><strong>Ngày dự kiến:</strong> <?php echo date('d/m/Y', strtotime($data['booking']['booking_date'])); ?></p>
    <p><strong>Gửi lúc:</strong> <?php echo date('H:i d/m/Y', strtotime($data['booking']['created_at'])); ?></p>
    
    <hr>
    <a href="<?php echo URLROOT; ?>/admin/bookings" style="text-decoration: none; color: #666;">⬅ Quay lại danh sách</a>
</div>