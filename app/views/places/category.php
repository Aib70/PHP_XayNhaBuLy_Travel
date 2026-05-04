<?php
    if (!isset($data)) {
    $data = [];
}
?>
<div style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    <h1 class="text-center my-4">
    <?php echo $data['title']; ?>
    </h1>
    
    <?php if(empty($data['places'])): ?>
        <p style="text-align: center;">Chưa có dữ liệu cho danh mục này.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
            <?php foreach($data['places'] as $p): ?>
                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <img src="<?php echo URLROOT; ?>/public/img/places/<?php echo $p['image_main']; ?>" 
                         style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 15px;">
                        <h3 style="margin: 0; color: #d35400;"><?php echo $p['name']; ?></h3>
                        <p style="font-size: 0.9rem; color: #666; height: 60px; overflow: hidden;">
                            <?php echo mb_strimwidth(strip_tags($p['description']), 0, 100, "..."); ?>
                        </p>
                        <a href="<?php echo URLROOT; ?>/place/view/<?php echo $p['id']; ?>" 
                           style="display: inline-block; background: #333; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 14px;">
                           Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>