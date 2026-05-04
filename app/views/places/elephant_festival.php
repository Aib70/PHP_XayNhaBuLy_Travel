<?php
    if (!isset($data)) {
    $data = [];
}
?>
<section class="festival-hero" style="position: relative; height: 80vh; overflow: hidden; display: flex; align-items: center; justify-content: center; color: white;">
    <img src="<?= URLROOT; ?>/public/img/elephant-hero.jpg" style="position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: -1; filter: brightness(0.6);">
    <div style="text-align: center; max-width: 800px; padding: 20px;">
        <h1 style="font-size: 4rem; text-transform: uppercase; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5);">
            <?= $data['text']['festival_title']; ?>
        </h1> </div>
</section>

<div class="container" style="max-width: 1200px; margin: -50px auto 50px; position: relative; z-index: 10; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
        <div>
            <h2 style="color: #d35400; border-bottom: 3px solid #f1c40f; display: inline-block; padding-bottom: 10px;">
                🐘 <?= $data['text']['spirit_of_laos']; ?>
            </h2>
            <p style="font-size: 1.2rem; line-height: 1.8; color: #444; text-align: justify;">
                <?= $data['place']['desc_' . $data['lang']]; ?>
            </p>
        </div>
        
        <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.2); height: 350px;">
            <iframe width="100%" height="100%" 
                    src="https://www.youtube.com/embed/B1jf5ZoGkME?autoplay=1&mute=1&controls=0&rel=0&playlist=B1jf5ZoGkME&loop=1" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        </div>
    </div>

    <hr style="margin: 50px 0; opacity: 0.1;">

    <h3 style="text-align: center; margin-bottom: 30px; font-size: 2rem;"><?= $data['text']['gallery']; ?></h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
        <?php foreach($data['gallery'] as $img): ?>
            <div class="gallery-item" style="overflow: hidden; border-radius: 10px; height: 200px;">
                <img src="<?= URLROOT ?>/public/img/places/<?= $img ?>" style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s; cursor: pointer;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            </div>
        <?php endforeach; ?>
    </div>
</div>