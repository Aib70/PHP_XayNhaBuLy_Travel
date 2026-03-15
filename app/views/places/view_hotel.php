<?php require_once '../app/views/inc/header.php'; ?>

<div style="max-width: 1100px; margin: 30px auto; padding: 20px; font-family: 'Segoe UI', Arial, sans-serif;">
    
    <?php if(isset($_GET['msg'])): ?>
        <?php 
            $msg_text = ""; $msg_bg = "#d4edda"; $msg_color = "#155724"; $msg_border = "#c3e6cb";
            if($_GET['msg'] == 'success') {
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

    <div style="margin-bottom: 30px;">
        <h1 style="color: #333; margin-bottom: 10px; display: flex; align-items: center; gap: 15px;">
            🏨 <?= htmlspecialchars($data['place']['name_' . $data['lang']] ?? ($data['place']['name'] ?? 'Unnamed Hotel')); ?>
        </h1>
        
        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div style="color: #f39c12; font-size: 1.3rem; letter-spacing: 2px;">
                <?php 
                    $star_count = $data['place']['star_rating'] ?? 5;
                    for($i = 1; $i <= 5; $i++) {
                        echo ($i <= $star_count) ? '★' : '☆';
                    }
                ?>
            </div>

            <div style="background: #e74c3c; color: white; padding: 8px 20px; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);">
                <span style="font-size: 0.85rem; font-weight: normal;"><?= ($data['lang'] == 'vi') ? 'Giá từ:' : (($data['lang'] == 'lo') ? 'ລາຄາຈາກ:' : 'From:'); ?></span> 
                <?= number_format($data['place']['price'] ?? 0, 0, ',', '.'); ?> 
                <span style="font-size: 0.9rem;"><?= ($data['lang'] == 'vi') ? 'VNĐ/đêm' : (($data['lang'] == 'lo') ? 'ກີບ/ຄືນ' : 'USD/Night'); ?></span>
            </div>
        </div>
    </div>
    
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <div style="flex: 2; min-width: 350px;">
            <img src="<?= URLROOT; ?>/public/img/places/<?= $data['place']['image_main']; ?>" style="width: 100%; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            
            <div style="margin-top: 30px; line-height: 1.8; color: #444;">
                <h3 style="color: #f39c12; border-left: 5px solid #f39c12; padding-left: 15px;"><?= $data['text']['intro']; ?></h3>
                <p><?= nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']] ?? ($data['place']['description'] ?? ''))); ?></p>
                <p><strong>📍 <?= $data['text']['address']; ?>:</strong> <?= htmlspecialchars($data['place']['addr_' . $data['lang']] ?? ($data['place']['address'] ?? '')); ?></p>
            </div>

            <div id="comment-section" style="margin-top: 40px; padding: 30px; background: #fff; border-radius: 15px; border: 1px solid #eee; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <h3 style="color: #333; margin-bottom: 20px;"><?= $data['text']['comment_title']; ?></h3>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="<?= URLROOT; ?>/forum/add" method="POST">
                        <input type="hidden" name="place_id" value="<?= $data['place']['id']; ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <input type="text" name="author_name" value="<?= $_SESSION['user_name']; ?>" readonly style="padding: 12px; border: 1px solid #eee; border-radius: 8px; background: #f5f5f5;">
                            
                            <select name="user_rating" style="padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: white; color: #f39c12; font-weight: bold;">
                                <option value="5">⭐⭐⭐⭐⭐ <?= ($data['lang'] == 'vi') ? 'Tuyệt vời' : 'Excellent'; ?></option>
                                <option value="4">⭐⭐⭐⭐ <?= ($data['lang'] == 'vi') ? 'Rất tốt' : 'Very Good'; ?></option>
                                <option value="3">⭐⭐⭐ <?= ($data['lang'] == 'vi') ? 'Tốt' : 'Good'; ?></option>
                                <option value="2">⭐⭐ <?= ($data['lang'] == 'vi') ? 'Trung bình' : 'Average'; ?></option>
                                <option value="1">⭐ <?= ($data['lang'] == 'vi') ? 'Kém' : 'Poor'; ?></option>
                            </select>
                        </div>

                        <input type="text" name="title" required placeholder="<?= $data['text']['subject'] ?? 'Tiêu đề'; ?>" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; box-sizing: border-box;">
                        
                        <textarea name="content" required placeholder="<?= $data['text']['comment_placeholder']; ?>" style="width: 100%; height: 100px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; box-sizing: border-box;"></textarea>
                        
                        <button type="submit" style="padding: 12px 40px; background: #f39c12; color: #fff; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#d35400'" onmouseout="this.style.background='#f39c12'"><?= $data['text']['btn_comment']; ?></button>
                    </form>
                <?php else: ?>
                    <p style="text-align:center; color:#666; padding: 20px; border: 1px dashed #ddd; border-radius: 10px;">Vui lòng <a href="<?= URLROOT; ?>/user/login" style="color:#f39c12; font-weight:bold;">đăng nhập</a> để viết đánh giá.</p>
                <?php endif; ?>

                <div class="comment-list" style="margin-top: 30px;">
                    <?php if(!empty($data['comments'])): foreach($data['comments'] as $cmt): ?>
                        <div style="padding: 20px; border-bottom: 1px solid #f5f5f5; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong style="color: #2c3e50; font-size: 1.05rem;"><?= htmlspecialchars($cmt['author_name']); ?></strong>
                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <a href="<?= URLROOT; ?>/forum/delete/<?= $cmt['id']; ?>/<?= $data['place']['id']; ?>" style="color: #dc3545; font-size: 0.8rem; text-decoration: none;" onclick="return confirm('Xác nhận xóa?')">🗑 Xóa</a>
                                <?php endif; ?>
                            </div>
                            <h4 style="margin: 8px 0; color: #333;"><?= htmlspecialchars($cmt['title']); ?></h4>
                            <p style="color: #666; font-size: 0.95rem; margin: 0;"><?= nl2br(htmlspecialchars($cmt['content'])); ?></p>
                        </div>
                    <?php endforeach; else: ?>
                        <p style="color: #999; text-align: center;">Chưa có đánh giá nào cho khách sạn này.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <div style="position: sticky; top: 100px;">
                <h3 style="margin-top: 0;">🗺 <?= $data['text']['location']; ?></h3>
                <div style="width: 100%; height: 400px; border-radius: 15px; overflow: hidden; border: 1px solid #ddd; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <iframe width="100%" height="100%" frameborder="0" src="https://maps.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>&hl=<?= $data['lang']; ?>&z=15&output=embed"></iframe>
                </div>
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>" target="_blank" style="display: block; margin-top: 15px; text-align: center; background: #f39c12; color: white; padding: 15px; text-decoration: none; border-radius: 10px; font-weight: bold; transition: 0.3s;" onmouseover="this.style.opacity='0.9'">🚀 <?= $data['text']['direction']; ?></a>
            </div>
        </div>
    </div>
    
    <hr style="margin: 60px 0; border: 0; border-top: 1px solid #eee;">
    <h2 style="text-align: center; margin-bottom: 40px; color: #333;"><?= $data['related_title'] ?? 'Related Hotels'; ?></h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
        <?php if(!empty($data['related'])): ?>
            <?php foreach($data['related'] as $rel): ?>
                <a href="<?= URLROOT; ?>/place/view/<?= $rel['id']; ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <img src="<?= URLROOT; ?>/public/img/places/<?= $rel['image_main']; ?>" style="width: 100%; height: 180px; object-fit: cover;">
                        <div style="padding: 20px; text-align: center;">
                            <span style="display:block; font-weight: bold; margin-bottom: 5px; color: #2c3e50;">
                                <?= htmlspecialchars($rel['name_' . $data['lang']] ?? ($rel['name'] ?? 'Unnamed Hotel')); ?>
                            </span>
                            <span style="color: #f39c12; font-size: 0.85rem;">⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; grid-column: 1/-1; color: #999;">Chưa có khách sạn liên quan khác.</p>
        <?php endif; ?>
    </div>
    
</div>

<?php require_once '../app/views/inc/footer.php'; ?>