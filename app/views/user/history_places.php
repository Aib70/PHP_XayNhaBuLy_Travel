<div style="max-width: 1100px; margin: 50px auto; min-height: 400px; padding: 20px; font-family: 'Segoe UI', Tahoma, sans-serif;">
    <?php $lang = $_SESSION['lang'] ?? 'vi'; ?>
    
    <h2 style="color: #004a7c; border-bottom: 2px solid #f39c12; padding-bottom: 10px;">
        📍 <?= ($lang == 'lo') ? 'ປະຫວັດການຈອງສະຖານທີ່' : (($lang == 'en') ? 'Place Bookings' : 'Lịch sử đặt địa danh'); ?>
    </h2>

    <div style="margin-top: 30px;">
        <?php if(!empty($data['bookings'])): ?>
            <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background: #004a7c; color: white; text-align: left;">
                        <th style="padding: 15px;"><?= ($lang == 'lo') ? 'ສະຖານທີ່' : (($lang == 'en') ? 'Destination' : 'Địa danh'); ?></th>
                        <th style="padding: 15px;"><?= ($lang == 'lo') ? 'ວັນທີທ່ຽວ' : (($lang == 'en') ? 'Visit Date' : 'Ngày tham quan'); ?></th>
                        <th style="padding: 15px;"><?= ($lang == 'lo') ? 'ເບີໂທລະສັບ' : (($lang == 'en') ? 'Phone' : 'Số điện thoại'); ?></th>
                        <th style="padding: 15px;"><?= ($lang == 'lo') ? 'ສະຖານະ' : (($lang == 'en') ? 'Status' : 'Trạng thái'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['bookings'] as $res): ?>
                        <tr style="border-bottom: 1px solid #eee; transition: 0.3s;" onmouseover="this.style.backgroundColor='#f1f8ff'" onmouseout="this.style.backgroundColor='transparent'">
                            
                            <td style="padding: 15px; font-weight: bold; color: #333;">
                                <?= !empty($res['place_name']) ? htmlspecialchars($res['place_name']) : '<span style="color:#999; font-weight:normal;"><i>(Chưa xác định)</i></span>'; ?>
                            </td>

                            <td style="padding: 15px;">
                                <?= ($res['booking_date']) ? date('d/m/Y', strtotime($res['booking_date'])) : '---'; ?>
                            </td>

                            <td style="padding: 15px; color: #555;">
                                <?= htmlspecialchars($res['phone']) ?>
                            </td>

                            <td style="padding: 15px;">
                                <?php 
                                    $status = $res['status'] ?? 'pending';
                                    // Thiết lập màu sắc theo trạng thái
                                    $bg = ($status == 'confirmed') ? '#e8f5e9' : '#fff3e0';
                                    $color = ($status == 'confirmed') ? '#2e7d32' : '#e65100';
                                    $icon = ($status == 'confirmed') ? '✅' : '⌛';

                                    if($lang == 'lo') {
                                        $status_text = ($status == 'confirmed') ? 'ຢືນຢັນແລ້ວ' : 'ກຳລັງກວດສອບ';
                                    } elseif($lang == 'en') {
                                        $status_text = ($status == 'confirmed') ? 'Confirmed' : 'Pending';
                                    } else {
                                        $status_text = ($status == 'confirmed') ? 'Đã xác nhận' : 'Đang xử lý';
                                    }
                                ?>
                                <span style="background: <?= $bg ?>; color: <?= $color ?>; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;">
                                    <?= $icon ?> <?= $status_text ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 80px; background: #f9f9f9; border-radius: 15px; border: 2px dashed #ddd;">
                <p style="font-size: 1.2rem; color: #999;">
                    <?= ($lang == 'lo') ? 'ທ່ານຍັງບໍ່ມີປະຫວັດການຈອງເທື່ອ.' : (($lang == 'en') ? 'No booking history found.' : 'Bạn chưa có lịch sử đặt địa danh nào.'); ?>
                </p>
                <a href="<?= URLROOT; ?>/place/all" style="display: inline-block; margin-top: 15px; background: #f39c12; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s;">
                    <?= ($lang == 'lo') ? 'ໄປສຳຫຼວດເລີຍ' : (($lang == 'en') ? 'Explore Now' : 'Khám phá ngay 🚀'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>