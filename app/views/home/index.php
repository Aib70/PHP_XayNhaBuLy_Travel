<style>
.video-banner {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    margin-bottom: 30px;
}

.video-banner iframe {
    width: 100%;
    height: 100%;
    border: none;
    pointer-events: none;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
}

.video-overlay h2 {
    font-size: 3rem;
    margin-bottom: 10px;
    text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
}

/* GRID & CARDS */
.place-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    padding: 0 20px 50px 20px;
    max-width: 1200px;
    margin: auto;
}

.place-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform .3s;
    display: flex;
    flex-direction: column; /* Đảm bảo nội dung trải dài */
    height: 100%;
}

.place-card:hover {
    transform: translateY(-10px);
}

.place-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: #eee;
}

.place-content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1; /* Đẩy nút bấm xuống đáy card */
}

.place-title {
    font-size: 1.3rem;
    margin: 0 0 10px;
    color: #222;
    font-weight: bold;
}

.place-desc {
    font-size: .9rem;
    color: #666;
    line-height: 1.5;
    margin-bottom: 20px;
    /* Cắt chữ nếu quá 3 dòng */
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}

.btn-detail {
    display: inline-block;
    margin-top: auto; /* Tự động đẩy nút xuống dưới cùng */
    padding: 10px 20px;
    background: #ffcc00;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    text-align: center;
    transition: 0.3s;
}

.btn-detail:hover {
    background: #333;
    color: #ffcc00;
}
</style>



<?php require_once '../app/views/inc/header.php'; ?>

<div style="max-width:1200px;margin:auto;padding:20px;">

    <div class="video-banner">
        <iframe
            src="https://www.youtube.com/embed/B1jf5ZoGkME?autoplay=1&mute=1&controls=0&rel=0&playlist=B1jf5ZoGkME&loop=1"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>

        <div class="video-overlay">
            <?php if($_SESSION['lang']=='vi'): ?>
                <h2>Xayabury Tuyệt Đẹp</h2>
                <p>Hành trình khám phá thiên nhiên hoang sơ</p>
            <?php elseif($_SESSION['lang']=='lo'): ?>
                <h2>ໄຊຍະບູລີ ທີ່ສວຍງາມ</h2>
                <p>ການເດີນທາງເພື່ອສຳຣວດທຳມະຊາດທີ່ບໍລິສຸດ</p>
            <?php else: ?>
                <h2>Beautiful Xayabury</h2>
                <p>A journey to explore untouched nature</p>
            <?php endif; ?>
        </div>
    </div>

    <div style="max-width: 600px; margin: -30px auto 30px; position: relative; z-index: 10;">
    <form action="<?php echo URLROOT; ?>" method="GET" style="display: flex; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border-radius: 30px; overflow: hidden;">
        <input 
            type="text" 
            name="search" 
            value="<?php echo htmlspecialchars($data['keyword'] ?? ''); ?>"
            placeholder="<?php echo ($lang == 'vi') ? 'Tìm địa danh...' : (($lang == 'lo') ? 'ຄົ້ນຫາສະຖານທີ່...' : 'Search places...'); ?>"
            style="flex: 1; padding: 15px 25px; border: none; outline: none; font-size: 1rem;"
        >
        <button type="submit" style="padding: 0 25px; background: #ffcc00; border: none; cursor: pointer; font-weight: bold;">
            🔍
        </button>
    </form>
    
    <?php if(!empty($data['keyword'])): ?>
        <p style="text-align: center; margin-top: 15px;">
            <?php echo ($lang == 'vi') ? "Kết quả tìm kiếm cho" : "Search results for"; ?>: 
            <strong>"<?php echo htmlspecialchars($data['keyword']); ?>"</strong>
            <a href="<?php echo URLROOT; ?>" style="margin-left: 10px; color: red; text-decoration: none;">[X]</a>
        </p>
    <?php endif; ?>
</div>

    <section style="padding:30px 0; text-align:center;">
        <h2 style="color:#333">
    <?php if(!empty($data['keyword'])): ?>
        <?php echo ($lang == 'vi') ? "Kết quả tìm kiếm" : "Search Results"; ?>
    <?php else: ?>
        <?php echo ($lang == 'vi') ? "Điểm Đến Đặc Sắc" : "Featured Destinations"; ?>
    <?php endif; ?>
</h2>
        <div style="width:80px;height:4px;background:#ffcc00;margin:20px auto"></div>
    </section>

</div>

<div class="place-grid">
    <?php if(!empty($data['special_places'])): ?>
        <?php foreach($data['special_places'] as $place): ?>
            <div class="place-card">
                <img
                    src="<?php echo URLROOT;?>/public/img/places/<?php echo $place['image_main'];?>"
                    class="place-img"
                    loading="lazy"
                    alt="<?php echo htmlspecialchars($place['name']);?>"
                    onerror="this.onerror=null;this.src='<?php echo URLROOT;?>/public/img/no-image.jpg';"
                >

                <div class="place-content">
                    <h3 class="place-title">
                        <?php echo htmlspecialchars($place['name']);?>
                    </h3>

                    <div class="place-desc">
                        <?php echo htmlspecialchars($place['description'] ?? ''); ?>
                    </div>

                    <a href="<?php echo URLROOT; ?>/place/view/<?php echo $place['id']; ?>" class="btn-detail">
                        <?php 
                            if($_SESSION['lang'] == 'vi') echo "Xem chi tiết →";
                            elseif($_SESSION['lang'] == 'lo') echo "ລາຍລະອຽດ →";
                            else echo "View Details →";
                        ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; grid-column: 1/-1;">Chưa có địa danh đặc sắc nào được tìm thấy.</p>
    <?php endif; ?>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>