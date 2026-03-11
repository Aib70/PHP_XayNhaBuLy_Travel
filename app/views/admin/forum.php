
<div class="container" style="max-width: 1100px; margin: 30px auto; padding: 20px;">
    <h1>Duyệt bài viết Diễn đàn</h1>
    
    <div style="margin-bottom: 25px;">
        <a href="<?php echo URLROOT; ?>/admin" 
           style="display: inline-flex; align-items: center; text-decoration: none; background: #007bff; color: white; padding: 12px 20px; border-radius: 8px; font-weight: bold;">
           ⬅️ <?php echo ($_SESSION['lang'] == 'lo') ? "ກັບຄືນການຈັດການສະຖານທີ່" : "Quay lại Quản lý địa danh"; ?>
        </a>
    </div>

    <table border="1" width="100%" style="border-collapse: collapse; background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <tr style="background: #333; color: #fff;">
            <th style="padding: 15px;">Người đăng</th>
            <th style="padding: 15px;">Nội dung</th>
            <th style="padding: 15px;">Trạng thái</th>
            <th style="padding: 15px;">Thao tác</th>
        </tr>
        <?php foreach($data['posts'] as $p): ?>
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 15px; text-align: center;"><?php echo htmlspecialchars($p['author_name']); ?></td>
            <td style="padding: 15px;">
                <strong><?php echo htmlspecialchars($p['title']); ?></strong><br>
                <small style="color: #666;"><?php echo nl2br(htmlspecialchars($p['content'])); ?></small>
            </td>
            <td style="padding: 15px; text-align: center;">
                <?php echo ($p['status'] == 1) ? "✅ <span style='color: green;'>Đã duyệt</span>" : "⏳ <span style='color: orange;'>Chờ duyệt</span>"; ?>
            </td>
            <td style="padding: 15px; text-align: center;">
                <?php if($p['status'] == 0): ?>
                    <a href="<?php echo URLROOT; ?>/admin/approve_post/<?php echo $p['id']; ?>" style="color: #28a745; text-decoration: none; font-weight: bold;">Duyệt bài</a> |
                <?php endif; ?>

                <a href="<?php echo URLROOT; ?>/forum/delete/<?php echo $p['id']; ?>/0" 
                   style="color: #dc3545; text-decoration: none; font-weight: bold;"
                   onclick="return confirm('Xác nhận xóa bài viết này?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>