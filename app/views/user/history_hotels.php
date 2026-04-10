<div style="max-width: 1100px; margin: 50px auto; padding: 20px; font-family: 'Segoe UI', Tahoma, sans-serif;">
    <h2 style="color: #004a7c; border-bottom: 2px solid #f39c12; padding-bottom: 10px;">
        🏨 Lịch sử đặt khách sạn của tôi
    </h2>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <thead>
            <tr style="background: #004a7c; color: white; text-align: left;">
                <th style="padding: 15px;">Khách sạn</th>
                <th style="padding: 15px;">Ngày nhận</th>
                <th style="padding: 15px;">Ngày trả</th>
                <th style="padding: 15px;">Số khách</th>
                <th style="padding: 15px;">Trạng thái</th>
                <th style="padding: 15px;">Thao tác</th> </tr>
        </thead>
        <tbody>
            <?php if(!empty($data['bookings'])): ?>
                <?php foreach($data['bookings'] as $res): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; font-weight: bold;"><?= $res['place_name'] ?></td>
                        <td style="padding: 15px;"><?= date('d/m/Y', strtotime($res['checkin'])) ?></td>
                        <td style="padding: 15px;"><?= date('d/m/Y', strtotime($res['checkout'])) ?></td>
                        <td style="padding: 15px; text-align: center;"><?= $res['guests'] ?></td>
                        
                        <td style="padding: 15px;">
                            <?php if ($res['status'] == 'pending'): ?>
                                <span style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 20px; font-size: 12px; border: 1px solid #ffeeba;">Chưa duyệt</span>
                            <?php else: ?>
                                <span style="background: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 20px; font-size: 12px;">Đã xác nhận</span>
                            <?php endif; ?>
                        </td>

                        <td style="padding: 15px;">
                            <?php if ($res['status'] == 'pending'): ?>
                                <a href="<?= URLROOT ?>/user/cancel_booking/<?= $res['id'] ?>" 
                                   style="background: #ff4d4d; color: white; padding: 5px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold;"
                                   onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt này không?')">
                                   Hủy đơn
                                </a>
                            <?php else: ?>
                                <span style="color: #6c757d; font-style: italic; font-size: 12px;">
                                    <i class="fa fa-lock"></i> Không thể hủy
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: #999;">Bạn chưa có lịch sử đặt phòng nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>