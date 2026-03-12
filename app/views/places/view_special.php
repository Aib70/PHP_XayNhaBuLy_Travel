<style>
    .special-hero {
        position: relative;
        height: 70vh;
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
    .hero-content h1 { font-size: 3.5rem; text-transform: uppercase; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
    
    .section-title { text-align: center; margin: 50px 0; position: relative; }
    .section-title::after {
        content: ''; width: 80px; height: 4px; background: #ffcc00;
        display: block; margin: 10px auto;
    }
    .video-container {
        max-width: 1000px; margin: 0 auto 50px;
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    .content-box {
        line-height: 2; font-size: 1.2rem; color: #444;
        text-align: justify; column-count: 2; column-gap: 40px; margin-bottom: 50px;
    }
    @media (max-width: 768px) {
        .content-box { column-count: 1; }
        .hero-content h1 { font-size: 2rem; }
    }
</style>

<section class="special-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1><?= $data['text']['special_title'] ?></h1>
        <p style="font-size: 1.5rem; font-style: italic; opacity: 0.9;">"<?= htmlspecialchars($data['place']['name_' . $data['lang']]) ?>"</p>
    </div>
</section>



<div style="max-width: 1200px; margin: auto; padding: 0 20px;">
    
    <div class="section-title">
        <h2>🐘 <?= $data['text']['intro'] ?></h2>
    </div>
    
    <div class="content-box">
        <?= nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']])) ?>
    </div>

    <div class="video-container">
        <iframe width="100%" height="550" src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                title="Elephant Festival Video" frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 80px;">
        <div id="booking-section" style="background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3 style="color: #d35400;"><?= $data['text']['booking_title'] ?></h3>
            <?php require_once 'inc_booking_form.php'; ?>
        </div>

        <div>
            <h3 style="margin-top: 0;"><?= $data['text']['location'] ?></h3>
            <div style="height: 350px; border-radius: 15px; overflow: hidden; border: 1px solid #ddd;">
                <iframe width="100%" height="100%" frameborder="0" src="https://maps.google.com/maps?q=<?= $data['place']['latitude']; ?>,<?= $data['place']['longitude']; ?>&hl=<?= $data['lang']; ?>&z=15&output=embed"></iframe>
            </div>
        </div>
    </div>
</div>