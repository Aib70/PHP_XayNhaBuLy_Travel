<div style="max-width: 1000px; margin: 50px auto; padding: 20px;">
    <h2>💬 Bình luận của tôi</h2>
    <hr>

    <?php if(empty($data['reviews'])): ?>
        <p>Bạn chưa có bình luận nào.</p>
    <?php else: ?>
        <?php foreach($data['reviews'] as $review): ?>
            <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #eee;">
                <h4 style="margin: 0; color: #004a7c;">📍 Địa danh: <?= $review['name_' . $_SESSION['lang']] ?></h4>
                <div style="color: #f39c12; margin: 10px 0;">
                    <?= str_repeat('⭐', $review['rating']) ?>
                </div>
                <p><strong>Tiêu đề:</strong> <?= htmlspecialchars($review['title']) ?></p>
                <p><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                <small style="color: #999;">Ngày gửi: <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>