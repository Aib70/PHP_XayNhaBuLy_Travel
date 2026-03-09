<div style="max-width: 800px; margin: 30px auto; padding: 20px;">
    <h2>💬 <?php echo ($data['lang'] == 'vi') ? "Diễn đàn thảo luận" : "Discussion Forum"; ?></h2>

    <form action="<?php echo URLROOT; ?>/forum/add" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <input type="text" name="author_name" placeholder="Tên của bạn..." required style="width: 100%; padding: 10px; margin-bottom: 10px;">
        <input type="text" name="title" placeholder="Tiêu đề..." required style="width: 100%; padding: 10px; margin-bottom: 10px;">
        <textarea name="content" placeholder="Nội dung chia sẻ..." required style="width: 100%; padding: 10px; height: 100px;"></textarea>
        <button type="submit" style="background: #ffcc00; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; margin-top: 10px;">Gửi bài viết</button>
    </form>

    <?php foreach($data['posts'] as $post): ?>
        <div style="border-bottom: 1px solid #eee; padding: 15px 0;">
            <h3 style="margin: 0; color: #333;"><?php echo htmlspecialchars($post['title']); ?></h3>
            <small>Bởi: <strong><?php echo htmlspecialchars($post['author_name']); ?></strong> - <?php echo $post['created_at']; ?></small>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        </div>
    <?php endforeach; ?>
</div>