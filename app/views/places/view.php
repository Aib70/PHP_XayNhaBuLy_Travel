<?php require_once '../app/views/inc/header.php'; ?>

<div style="max-width: 1100px; margin: 30px auto; padding: 20px; font-family: 'Segoe UI', Arial, sans-serif;">
    
    <?php if(isset($_GET['msg'])): ?>
        <?php 
            $msg_text = ""; $msg_bg = "#d4edda"; $msg_color = "#155724"; $msg_border = "#c3e6cb";
            if($_GET['msg'] == 'booked') {
                $msg_text = ($data['lang'] == 'lo') ? "ການຈອງຂອງທ່ານສຳເລັດແລ້ວ!" : (($data['lang'] == 'en') ? "Booking successful!" : "Đặt chỗ thành công!");
                $msg_bg = "#e3f2fd"; $msg_color = "#0d47a1"; $msg_border = "#bbdefb";
            } elseif($_GET['msg'] == 'success') {
                $msg_text = ($data['lang'] == 'lo') ? "ສົ່ງຄຳຄິດເຫັນສຳເລັດແລ້ວ!" : "Gửi bình luận thành công!";
            } elseif($_GET['msg'] == 'deleted') {
                $msg_text = "Đã xóa bình luận!"; $msg_bg = "#f8d7da"; $msg_color = "#721c24"; $msg_border = "#f5c6cb";
            }
        ?>
        <?php if($msg_text != ""): ?>
            <div id="status-alert" style="background: <?= $msg_bg ?>; color: <?= $msg_color ?>; padding: 15px; border-radius: 8px; border: 1px solid <?= $msg_border ?>; margin-bottom: 20px; font-weight: bold; position: sticky; top: 100px; z-index: 999;">
                📢 <?= $msg_text ?>
            </div>
            <script>
                setTimeout(() => { document.getElementById('status-alert')?.remove(); }, 4000);
            </script>
        <?php endif; ?>
    <?php endif; ?>

    <h1 style="color: #333; margin-bottom: 20px;">
        <?= htmlspecialchars($data['place']['name_' . $data['lang']] ?? ($data['place']['name'] ?? 'Unnamed Place')); ?>
    </h1>
    
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <div style="flex: 2; min-width: 350px;">
            <img src="<?= URLROOT; ?>/public/img/places/<?= $data['place']['image_main']; ?>" style="width: 100%; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            
            <div style="margin-top: 30px; line-height: 1.8; color: #444;">
                <h3 style="color: #ffcc00; border-left: 5px solid #ffcc00; padding-left: 15px;"><?= $data['text']['intro']; ?></h3>
                <p><?= nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']] ?? ($data['place']['description'] ?? ''))); ?></p>
                <p><strong>📍 <?= $data['text']['address']; ?>:</strong> <?= htmlspecialchars($data['place']['addr_' . $data['lang']] ?? ($data['place']['address'] ?? '')); ?></p>
            </div>

            <div id="booking-section" style="background: #fdfdfd; padding: 30px; border-radius: 15px; border: 1px solid #eee; margin-top: 30px;">
                <h3 style="margin-top: 0;"><?= $data['text']['booking_title']; ?></h3>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="<?= URLROOT; ?>/place/book" method="POST">
                        <input type="hidden" name="place_id" value="<?= $data['place']['id']; ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <input type="text" name="name" value="<?= $_SESSION['user_name']; ?>" readonly style="padding: 12px; border: 1px solid #eee; border-radius: 8px; background: #f5f5f5;">
                            <input type="email" name="email" value="<?= $_SESSION['user_email'] ?? ''; ?>" readonly style="padding: 12px; border: 1px solid #eee; border-radius: 8px; background: #f5f5f5;">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: #666;">
                                <?= ($data['lang'] == 'lo') ? "ເບີໂທລະສັບ:" : (($data['lang'] == 'en') ? "Phone Number:" : "Số điện thoại:"); ?>
                            </label>
                            <input type="tel" name="phone" required placeholder="Nhập số điện thoại của bạn" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: #666;"><?= $data['text']['date_label']; ?></label>
                            <input type="date" name="date" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <button type="submit" style="width: 100%; padding: 15px; background: #ffcc00; border: none; font-weight: bold; border-radius: 8px; cursor: pointer;"><?= $data['text']['btn_book']; ?></button>
                    </form>
                <?php else: ?>
                    <div style="text-align: center; padding: 20px; border: 1px dashed #ccc; border-radius: 10px;">
                        <p><?= $data['text']['login_req']; ?></p>
                        <a href="<?= URLROOT; ?>/user/login" style="color: #ffcc00; font-weight: bold;">🔑 <?= $data['text']['login_btn']; ?></a>
                    </div>
                <?php endif; ?>
            </div>
            </div>

        <div style="flex: 1; min-width: 300px;">
            <div style="position: sticky; top: 100px;">
                <h3>🗺 <?= $data['text']['location']; ?></h3>
                <div style="width: 100%; height: 400px; border-radius: 15px; overflow: hidden; border: 1px solid #ddd;">
                    <iframe width="100%" height="100%" frameborder="0" src="https://maps.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>&hl=<?= $data['lang']; ?>&z=15&output=embed"></iframe>
                </div>
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>" target="_blank" style="display: block; margin-top: 15px; text-align: center; background: #4285F4; color: white; padding: 15px; text-decoration: none; border-radius: 10px; font-weight: bold;">🚀 <?= $data['text']['direction']; ?></a>
            </div>
        </div>
    </div>

     <div style="margin-top: 20px;">
        <?php require_once '../app/views/inc/comment_box.php'; ?>
    </div>

    <hr style="margin: 60px 0; border: 0; border-top: 1px solid #eee;">

    <h2 style="text-align: center; margin-bottom: 40px;"><?= $data['text']['related']; ?></h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 50px;">
        <?php if(isset($data['related']) && is_array($data['related'])): 
            foreach($data['related'] as $rel): ?>
                <a href="<?= URLROOT; ?>/place/view/<?= $rel['id']; ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <img src="<?= URLROOT; ?>/public/img/places/<?= $rel['image_main']; ?>" style="width: 100%; height: 180px; object-fit: cover;">
                        <div style="padding: 20px; text-align: center; font-weight: bold;">
                            <?= htmlspecialchars($rel['name_' . $data['lang']] ?? ($rel['name'] ?? 'Unnamed Place')); ?>
                        </div>
                    </div>
                </a>
        <?php endforeach; else: ?>
            <p style='text-align:center; grid-column: 1/-1; color:#999;'>Không có địa danh liên quan.</p>
        <?php endif; ?>
    </div>

   
    
</div>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('msg') === 'booked') {
            document.getElementById('booking-section')?.scrollIntoView({ behavior: 'smooth' });
        }
    };
</script>

<?php require_once '../app/views/inc/footer.php'; ?>