<style>
    /* Phần ảnh lớn đầu trang - GIỮ LẠI */
    .special-hero {
        position: relative;
        height: 60vh; /* Giảm nhẹ chiều cao để khách dễ thấy phần nội dung bên dưới */
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        background: url('<?= URLROOT ?>/public/img/places/<?= $data['place']['image_main'] ?>') center/cover no-repeat fixed;
    }
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }
    .hero-content { position: relative; z-index: 2; max-width: 800px; padding: 20px; }
    .hero-content h1 { font-size: 3rem; text-transform: uppercase; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
    
    /* Tiêu đề các mục */
    .section-title { text-align: left; margin: 40px 0 20px; position: relative; }
    .section-title::after {
        content: ''; width: 50px; height: 3px; background: #f39c12;
        display: block; margin-top: 10px;
    }

    /* Khung Video - GIỮ LẠI */
    .video-container {
        max-width: 100%; margin: 0 auto 50px;
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    /* Nội dung giới thiệu - ĐÃ SỬA: Bỏ chia cột văn bản để dành chỗ cho cột Sidebar */
    .content-box {
        line-height: 1.8; 
        font-size: 1.1rem; 
        color: #444;
        text-align: justify; 
        margin-bottom: 40px;
    }

    /* Responsive cho điện thoại */
    @media (max-width: 768px) {
        .hero-content h1 { font-size: 1.8rem; }
        .special-hero { height: 50vh; }
        /* Khi xem trên điện thoại, 2 cột sẽ tự động xếp chồng lên nhau thành 1 cột */
    }
</style>

<section class="special-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1><?= $data['text']['special_title'] ?></h1>
        <p style="font-size: 1.5rem; font-style: italic; opacity: 0.9;">"<?= htmlspecialchars($data['place']['name_' . $data['lang']]) ?>"</p>
    </div>
</section>


<div style="max-width: 1200px; margin: 30px auto 0; padding: 0 20px;">
    <h1 style="font-size: 2.5rem; color: #333;">
        <?php echo $data['text']['special_title'] ?? $data['place']['name_' . $data['lang']]; ?>
    </h1>
</div>

<div style="max-width: 1200px; margin: auto; padding: 0 20px;">
    
    <div class="section-title">
        <h2>🐘 <?= $data['text']['intro'] ?></h2>
    </div>
    
    <div class="content-box">
        <?= nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']])) ?>
        <p style="margin-top: 15px;"><strong>📍 <?= $data['text']['address']; ?>:</strong> <?= htmlspecialchars($data['place']['addr_' . $data['lang']] ?? ''); ?></p>
    </div>

    <div class="video-container">
        <iframe width="100%" height="550" src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                title="Elephant Festival Video" frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
    </div>

    <div style="display: flex; gap: 40px; flex-wrap: wrap; margin-bottom: 80px; align-items: flex-start;">
        
        <div id="booking-section" style="flex: 1.5; min-width: 350px; background: #fdfdfd; padding: 35px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3 style="color: #d35400; margin-top: 0; font-size: 1.6rem; margin-bottom: 25px;">📋 <?= $data['text']['booking_title'] ?></h3>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php 
                    $booking_form_path = '../app/views/inc/booking_form.php'; 
                    if(file_exists($booking_form_path)){
                        require_once $booking_form_path;
                    } else {
                        echo "<p style='color:red;'>Đang cập nhật form đặt chỗ...</p>";
                    }
                ?>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; border: 1px dashed #ccc; border-radius: 12px; background: white;">
                    <p style="color: #666; font-size: 1.1rem; margin-bottom: 20px;"><?= $data['text']['login_req']; ?></p>
                    <a href="<?= URLROOT; ?>/user/login" style="color: #ffcc00; font-weight: bold; text-decoration: none; font-size: 1.2rem; display: inline-block;">
                        🔑 <?= $data['text']['login_btn']; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <h3 style="margin-top: 0; font-size: 1.5rem; display: flex; align-items: center; gap: 10px;">🗺️ <?= $data['text']['location'] ?></h3>
            
            <div style="background: white; padding: 12px; border-radius: 18px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #eee;">
                <div style="height: 380px; border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
                    <iframe 
                        width="100%" height="100%" frameborder="0" style="border:0"
                        src="https://maps.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>&hl=<?= $data['lang']; ?>&z=15&output=embed">
                    </iframe>
                </div>

                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>" 
                   target="_blank" 
                   style="display: flex; align-items: center; justify-content: center; gap: 12px; background: #4285F4; color: white; padding: 16px; text-decoration: none; border-radius: 12px; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(66, 133, 244, 0.3); transition: 0.3s;"
                   onmouseover="this.style.background='#3367D6'"
                   onmouseout="this.style.background='#4285F4'">
                   🚀 <?= $data['text']['direction'] ?>
                </a>
            </div>
        </div>

    </div>
    <div id="comment-section" style="margin-top: 60px; padding: 40px; background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <h3 style="color: #333; font-size: 1.8rem; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
            💬 <?= $data['text']['comment_title'] ?? 'Bình luận & Đánh giá'; ?>
        </h3>

        <?php if(isset($_SESSION['user_id'])): ?>
            <form action="<?= URLROOT; ?>/forum/add" method="POST" style="margin-bottom: 50px;">
                <input type="hidden" name="place_id" value="<?= $data['place']['id']; ?>">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-weight: bold; color: #555;">Người gửi:</label>
                        <input type="text" name="author_name" value="<?= $_SESSION['user_name']; ?>" readonly 
                               style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 10px; background: #f9f9f9; box-sizing: border-box;">
                    </div>
                    
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-weight: bold; color: #555;">Đánh giá của bạn:</label>
                        <select name="user_rating" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; background: white; color: #f39c12; font-weight: bold; cursor: pointer; box-sizing: border-box;">
                            <option value="5">⭐⭐⭐⭐⭐ Tuyệt vời</option>
                            <option value="4">⭐⭐⭐⭐ Rất tốt</option>
                            <option value="3">⭐⭐⭐ Tốt</option>
                            <option value="2">⭐⭐ Trung bình</option>
                            <option value="1">⭐ Kém</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <input type="text" name="title" required placeholder="Tiêu đề nhận xét của bạn..." 
                           style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <textarea name="content" required placeholder="Chia sẻ trải nghiệm của bạn về địa danh này..." 
                              style="width: 100%; height: 120px; padding: 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; font-family: inherit; box-sizing: border-box;"></textarea>
                </div>

                <button type="submit" style="background: #f39c12; color: white; padding: 15px 40px; border: none; border-radius: 10px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);"
                        onmouseover="this.style.background='#e67e22'" onmouseout="this.style.background='#f39c12'">
                    🚀 Gửi bình luận ngay
                </button>
            </form>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; border: 2px dashed #eee; border-radius: 15px; background: #fafafa; margin-bottom: 40px;">
                <p style="color: #666; font-size: 1.1rem;">Vui lòng <strong>đăng nhập</strong> để chia sẻ cảm nhận của bạn.</p>
                <a href="<?= URLROOT; ?>/user/login" style="display: inline-block; margin-top: 10px; color: #f39c12; font-weight: bold; text-decoration: none; border: 1px solid #f39c12; padding: 10px 25px; border-radius: 8px;">🔑 Đăng nhập</a>
            </div>
        <?php endif; ?>

        <div class="comment-display-list">
            <?php if(!empty($data['comments'])): foreach($data['comments'] as $cmt): ?>
                <div style="padding: 25px; border-bottom: 1px solid #f0f0f0; transition: 0.3s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <strong style="font-size: 1.2rem; color: #2c3e50;"><?= htmlspecialchars($cmt['author_name']); ?></strong>
                            <div style="color: #f39c12; margin: 5px 0; font-size: 0.9rem;">
                                ⭐⭐⭐⭐⭐ 
                            </div>
                        </div>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="<?= URLROOT; ?>/forum/delete/<?= $cmt['id']; ?>/<?= $data['place']['id']; ?>" 
                               style="color: #e74c3c; text-decoration: none; font-size: 0.85rem;" 
                               onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">🗑 Xóa</a>
                        <?php endif; ?>
                    </div>
                    <h4 style="margin: 10px 0; color: #333;"><?= htmlspecialchars($cmt['title']); ?></h4>
                    <p style="color: #555; line-height: 1.6; margin: 0;"><?= nl2br(htmlspecialchars($cmt['content'])); ?></p>
                </div>
            <?php endforeach; else: ?>
                <p style="text-align: center; color: #999; padding: 40px;">Hãy là người đầu tiên để lại bình luận cho địa danh này! ✨</p>
            <?php endif; ?>
        </div>
    </div>
</div>