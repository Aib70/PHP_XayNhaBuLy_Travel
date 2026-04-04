<style>
    /* Giữ nguyên phần Style của bạn */
    .special-hero {
        position: relative;
        height: 60vh;
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
    
    .section-title { text-align: left; margin: 40px 0 20px; position: relative; }
    .section-title::after {
        content: ''; width: 50px; height: 3px; background: #f39c12;
        display: block; margin-top: 10px;
    }

    .video-container {
        max-width: 100%; margin: 0 auto 50px;
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .content-box {
        line-height: 1.8; 
        font-size: 1.1rem; 
        color: #444;
        text-align: justify; 
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .hero-content h1 { font-size: 1.8rem; }
        .special-hero { height: 50vh; }
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
                title="Video" frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
    </div>

    <div style="display: flex; gap: 40px; flex-wrap: wrap; margin-bottom: 40px; align-items: flex-start;">
        <div id="booking-section" style="flex: 1.5; min-width: 350px; background: #fdfdfd; padding: 35px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3 style="color: #d35400; margin-top: 0; font-size: 1.6rem; margin-bottom: 25px;">📋 <?= $data['text']['booking_title'] ?></h3>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php 
                    $booking_form_path = '../app/views/inc/booking_form.php'; 
                    if(file_exists($booking_form_path)) require_once $booking_form_path;
                ?>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; border: 1px dashed #ccc; border-radius: 12px; background: white;">
                    <p style="color: #666; font-size: 1.1rem; margin-bottom: 20px;"><?= $data['text']['login_req']; ?></p>
                    <a href="<?= URLROOT; ?>/user/login" style="color: #ffcc00; font-weight: bold; text-decoration: none; font-size: 1.2rem;">
                        🔑 <?= $data['text']['login_btn']; ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <h3 style="margin-top: 0; font-size: 1.5rem; display: flex; align-items: center; gap: 10px;">🗺️ <?= $data['text']['location'] ?></h3>
            <div style="background: white; padding: 12px; border-radius: 18px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #eee;">
                <div style="height: 380px; border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
                    <iframe width="100%" height="100%" frameborder="0" style="border:0"
                            src="http://maps.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>&hl=<?= $data['lang']; ?>&z=15&output=embed">
                    </iframe>
                </div>
                <a href="https://www.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>" target="_blank" style="display: block; background: #4285F4; color: white; padding: 16px; text-decoration: none; border-radius: 12px; font-weight: bold; text-align: center;">
                    🚀 <?= $data['text']['direction'] ?>
                </a>
            </div>
        </div>
    </div>

    <?php if(!empty($data['related'])): ?>
    <section style="margin-top: 60px;">
        <div class="section-title">
            <h2>🔗 <?= $data['text']['related'] ?></h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 50px;">
            <?php foreach($data['related'] as $rel): ?>
                <a href="<?= URLROOT ?>/place/view/<?= $rel['id'] ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                        <img src="<?= URLROOT ?>/public/img/places/<?= $rel['image_main'] ?>" style="width: 100%; height: 180px; object-fit: cover;">
                        <div style="padding: 15px; text-align: center; font-weight: bold;"><?= $rel['name'] ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <div style="margin-bottom: 80px;">
        <?php 
            $comment_box_path = '../app/views/inc/comment_box.php';
            if(file_exists($comment_box_path)) {
                require_once $comment_box_path; 
            }
        ?>
    </div>
   
</div>
 