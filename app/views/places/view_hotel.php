<?php require_once '../app/views/inc/header.php'; ?>

<div style="max-width: 1100px; margin: 30px auto; padding: 20px; font-family: 'Segoe UI', Arial, sans-serif;">
    
    <?php if(isset($_GET['msg'])): ?>
        <?php 
            $msg_text = ""; $msg_bg = "#d4edda"; $msg_color = "#155724"; $msg_border = "#c3e6cb";
            if($_GET['msg'] == 'success') {
                $msg_text = ($data['lang'] == 'lo') ? "ສົ່ງຄຳຄິດເຫັນສຳເລັດແລ້ວ!" : "Gửi bình luận thành công!";
            } elseif($_GET['msg'] == 'booked') {
                $msg_text = ($data['lang'] == 'vi') ? "Đặt phòng thành công! Chúng tôi sẽ liên hệ sớm." : "Booking successful!";
            }
        ?>
        <?php if($msg_text != ""): ?>
            <div id="status-alert" style="background: <?= $msg_bg ?>; color: <?= $msg_color ?>; padding: 15px; border-radius: 8px; border: 1px solid <?= $msg_border ?>; margin-bottom: 20px; font-weight: bold;">
                📢 <?= $msg_text ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div style="margin-bottom: 30px;">
    <h1 style="color: #333; margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
        🏨 <?= htmlspecialchars($data['place']['name_' . $data['lang']] ?? ($data['place']['name'] ?? 'Unnamed Hotel')); ?>
    </h1>
    <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
        <div style="color: #f39c12; font-size: 1.3rem;">
            <?php 
                $star_count = $data['place']['star_rating'] ?? 5;
                for($i = 1; $i <= 5; $i++) echo ($i <= $star_count) ? '★' : '☆';
            ?>
        </div>
        
        <div style="background: #e74c3c; color: white; padding: 8px 25px; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);">
            <?php 
                $price = $data['place']['price_range'] ?? 0;
                echo number_format($price, 0, ',', '.'); 
            ?> 
            <?= ($data['lang'] == 'vi') ? 'VNĐ/đêm' : 'Kip/Night'; ?>
        </div>
    </div>
</div>
    
    <div style="display: flex; gap: 40px; flex-wrap: wrap; align-items: flex-start;">
        <div style="flex: 1.5; min-width: 350px;">
            <img src="<?= URLROOT; ?>/public/img/places/<?= $data['place']['image_main']; ?>" style="width: 100%; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            
            <div style="margin-top: 30px; line-height: 1.8; color: #444;">
                <h3 style="color: #f39c12; border-left: 5px solid #f39c12; padding-left: 15px;"><?= $data['text']['intro']; ?></h3>
                <p><?= nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']] ?? '')); ?></p>
                <p><strong>📍 <?= $data['text']['address']; ?>:</strong> <?= htmlspecialchars($data['place']['addr_' . $data['lang']] ?? ''); ?></p>
            </div>

           <div style="background: #fff; padding: 25px; border-radius: 15px; border: 2px solid #f39c12; margin-top: 30px; box-shadow: 0 10px 25px rgba(243, 156, 18, 0.1);">
    <h3 style="margin-top: 0; color: #f39c12; display: flex; align-items: center; gap: 10px;">
        🛏️ <?= ($data['lang'] == 'vi') ? 'Đặt phòng khách sạn' : 'Hotel Booking'; ?>
    </h3>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <form action="<?= URLROOT; ?>/place/book" method="POST">
            <input type="hidden" name="place_id" value="<?= $data['place']['id']; ?>">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="font-size: 0.85rem; color: #666; font-weight: bold;">Người đặt:</label>
                    <input type="text" name="name" value="<?= $_SESSION['user_name']; ?>" readonly style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; box-sizing: border-box;">
                </div>
                <div>
                    <label style="font-size: 0.85rem; color: #666; font-weight: bold;">Số điện thoại:</label>
                    <input type="tel" name="phone" required placeholder="Nhập số điện thoại" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="font-size: 0.85rem; color: #666; font-weight: bold;">Ngày nhận phòng:</label>
                    <input type="date" name="checkin" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="font-size: 0.85rem; color: #666; font-weight: bold;">Ngày trả phòng:</label>
                    <input type="date" name="checkout" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="font-size: 0.85rem; color: #666; font-weight: bold;">Số khách:</label>
                    <input type="number" name="guests" min="1" value="1" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
            </div>

            <button type="submit" style="width: 100%; padding: 18px; background: #f39c12; color: white; border: none; font-weight: bold; border-radius: 10px; cursor: pointer; font-size: 1.1rem; text-transform: uppercase; transition: 0.3s; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);"
                    onmouseover="this.style.background='#d35400'" onmouseout="this.style.background='#f39c12'">
                GỬI YÊU CẦU ĐẶT PHÒNG
            </button>
        </form>
    <?php else: ?>
        <div style="text-align: center; padding: 20px; border: 1px dashed #ccc; border-radius: 10px;">
            <p>Vui lòng <strong>đăng nhập</strong> để đặt phòng.</p>
            <a href="<?= URLROOT; ?>/user/login" style="color: #f39c12; font-weight: bold; text-decoration: none;">🔑 Đăng nhập ngay</a>
        </div>
    <?php endif; ?>
</div>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <div style="position: sticky; top: 100px;">
                <h3 style="margin-top: 0;">🗺 <?= $data['text']['location']; ?></h3>
                <div style="width: 100%; height: 400px; border-radius: 15px; overflow: hidden; border: 1px solid #ddd;">
                    <iframe width="100%" height="100%" frameborder="0" src="https://maps.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>&hl=<?= $data['lang']; ?>&z=15&output=embed"></iframe>
                </div>
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>" target="_blank" style="display: block; margin-top: 15px; text-align: center; background: #f39c12; color: white; padding: 15px; text-decoration: none; border-radius: 10px; font-weight: bold;">🚀 <?= $data['text']['direction']; ?></a>
            </div>
        </div>
    </div>

    <div style="margin-top: 40px;">
        <?php require_once '../app/views/inc/comment_box.php'; ?>
    </div>
    
    <hr style="margin: 60px 0; border: 0; border-top: 1px solid #eee;">
    ...
</div>