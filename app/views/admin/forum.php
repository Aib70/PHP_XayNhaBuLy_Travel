<div class="container">
    <h1>Duyệt bài viết Diễn đàn</h1>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <tr style="background: #333; color: #fff;">
            <th>Người đăng</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach($data['posts'] as $p): ?>
        <tr>
            <td><?php echo htmlspecialchars($p['author_name']); ?></td>
            <td><strong><?php echo htmlspecialchars($p['title']); ?></strong><br><?php echo $p['content']; ?></td>
            <td><?php echo ($p['status'] == 1) ? "✅ Đã duyệt" : "⏳ Chờ duyệt"; ?></td>
            <td>
                <?php if($p['status'] == 0): ?>
                    <a href="<?php echo URLROOT; ?>/admin/approve_post/<?php echo $p['id']; ?>" style="color: green;">Duyệt bài</a>
                <?php endif; ?>
                <a href="<?php echo URLROOT; ?>/admin/delete_post/<?php echo $p['id']; ?>" style="color: red; margin-left: 10px;">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>