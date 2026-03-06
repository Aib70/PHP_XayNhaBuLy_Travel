<style>
.video-banner{
    position:relative;
    width:100%;
    height:500px;
    overflow:hidden;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.video-banner iframe{
    width:100%;
    height:100%;
    border:none;
    pointer-events:none;
}

.video-overlay{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:white;
    text-align:center;
}

.video-overlay h2{
    font-size:3rem;
    margin-bottom:10px;
    text-shadow:2px 2px 10px rgba(0,0,0,0.5);
}

/* GRID */

.place-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
    padding-bottom:50px;
}

.place-card{
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    transition:transform .3s;
}

.place-card:hover{
    transform:translateY(-10px);
}

.place-img{
    width:100%;
    height:200px;
    object-fit:cover;
    background:#eee;
}

.place-content{
    padding:20px;
}

.place-title{
    font-size:1.4rem;
    margin:0 0 10px;
    color:#222;
}

.place-desc{
    font-size:.9rem;
    color:#666;
    height:60px;
    overflow:hidden;
}

.btn-detail{
    display:inline-block;
    margin-top:15px;
    padding:8px 20px;
    background:#ffcc00;
    color:#333;
    text-decoration:none;
    font-weight:bold;
    border-radius:5px;
}
</style>

<div style="max-width:1200px;margin:auto;padding:20px;">

<!-- VIDEO BANNER -->

<div class="video-banner">

<iframe
src="https://www.youtube.com/embed/B1jf5ZoGkME?autoplay=1&mute=1&controls=0&rel=0"
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

<!-- TITLE -->

<section style="padding:50px 0;text-align:center;">

<h2 style="color:#333">

<?php
echo ($_SESSION['lang']=='vi') ? "Điểm Đến Đặc Sắc" :
(($_SESSION['lang']=='lo') ? "ສະຖານທີ່ເດັ່ນ" : "Featured Destinations");
?>

</h2>

<div style="width:80px;height:4px;background:#ffcc00;margin:20px auto"></div>

</section>

</div>

<!-- PLACE LIST -->

<div class="place-grid">

<?php foreach($data['places'] as $place): ?>

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

</div>

</div>

<?php endforeach; ?>

</div>