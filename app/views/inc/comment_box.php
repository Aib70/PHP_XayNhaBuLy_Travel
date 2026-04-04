<div id="comment-section" style="margin-top: 60px; padding: 40px; background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #eee;">
    <h3 style="color: #333; font-size: 1.8rem; margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
        💬 <?= $data['text']['comment_title'] ?? 'Bình luận & Đánh giá'; ?>
    </h3>

    <?php if(isset($_SESSION['user_id'])): ?>
        <form action="<?= URLROOT; ?>/place/add_review/<?= $data['place']['id']; ?>" method="POST" style="margin-bottom: 50px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: bold; color: #555;">Người gửi:</label>
                    <input type="text" value="<?= $_SESSION['user_name']; ?>" readonly 
                           style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 10px; background: #f9f9f9; box-sizing: border-box;">
                </div>
                
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: bold; color: #555;">Đánh giá của bạn:</label>
                    <select name="rating" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; background: white; color: #f39c12; font-weight: bold; cursor: pointer; box-sizing: border-box;">
                        <option value="5">⭐⭐⭐⭐⭐ Tuyệt vời</option>
                        <option value="4">⭐⭐⭐⭐ Rất tốt</option>
                        <option value="3">⭐⭐⭐ Tốt</option>
                        <option value="2">⭐⭐ Trung bình</option>
                        <option value="1">⭐ Kém</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <textarea name="comment" required placeholder="<?= $data['text']['comment_placeholder']; ?>" 
                          style="width: 100%; height: 120px; padding: 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; font-family: inherit; box-sizing: border-box;"></textarea>
            </div>

            <button type="submit" style="background: #f39c12; color: white; padding: 15px 40px; border: none; border-radius: 10px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);">
                🚀 <?= $data['text']['btn_comment']; ?>
            </button>
        </form>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; border: 2px dashed #eee; border-radius: 15px; background: #fafafa; margin-bottom: 40px;">
            <p style="color: #666; font-size: 1.1rem;"><?= $data['text']['login_req']; ?></p>
            <a href="<?= URLROOT; ?>/user/login" style="display: inline-block; margin-top: 10px; color: #f39c12; font-weight: bold; text-decoration: none; border: 1px solid #f39c12; padding: 10px 25px; border-radius: 8px;">🔑 <?= $data['text']['login_btn']; ?></a>
        </div>
    <?php endif; ?>

    <div class="comment-display-list">
        <?php if(!empty($data['comments'])): foreach($data['comments'] as $cmt): ?>
            <div style="padding: 25px; border-bottom: 1px solid #f0f0f0;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong style="font-size: 1.1rem; color: #2c3e50;"><?= htmlspecialchars($cmt['author_name'] ?? 'Khách'); ?></strong>
                        <div style="color: #f39c12; margin: 5px 0;">
    <?php 
        // In ra số sao tương ứng với giá trị trong Database
        $stars = isset($cmt['rating']) ? (int)$cmt['rating'] : 5;
        echo str_repeat('⭐', $stars); 
       ?>
    </div>
                    </div>
                    <small style="color: #999;"><?= date('d/m/Y', strtotime($cmt['created_at'])); ?></small>
                </div>
                <p style="color: #555; line-height: 1.6; margin-top: 10px;"><?= nl2br(htmlspecialchars($cmt['content'])); ?></p>
            </div>
        <?php endforeach; else: ?>
            <p style="text-align: center; color: #999; padding: 40px;">Hãy là người đầu tiên đánh giá! ✨</p>
        <?php endif; ?>
    </div>
</div>