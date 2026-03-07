<div style="max-width: 1100px; margin: 30px auto; padding: 20px; font-family: 'Segoe UI', Arial, sans-serif;">
    <h1 style="color: #333; margin-bottom: 20px;"><?php echo htmlspecialchars($data['place']['name_' . $data['lang']]); ?></h1>
    
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        
        <div style="flex: 2; min-width: 350px;">
            <img src="<?php echo URLROOT; ?>/public/img/places/<?php echo $data['place']['image_main']; ?>" 
                 style="width: 100%; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);"
                 onerror="this.onerror=null; this.src='<?php echo URLROOT; ?>/public/img/default.jpg';">
            
            <div style="margin-top: 30px; line-height: 1.8; color: #444; font-size: 1.1rem;">
                <h3 style="color: #ffcc00; border-left: 5px solid #ffcc00; padding-left: 15px;">
                    <?php echo ($data['lang'] == 'vi') ? "Giới thiệu" : (($data['lang'] == 'lo') ? "ກ່ຽວກັບ" : "About"); ?>
                </h3>
                <p style="text-align: justify;"><?php echo nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']])); ?></p>
                
                <p><strong>📍 <?php echo ($data['lang'] == 'vi') ? "Địa chỉ" : (($data['lang'] == 'lo') ? "ທີ່ຢູ່" : "Address"); ?>:</strong> 
                <?php echo htmlspecialchars($data['place']['addr_' . $data['lang']]); ?></p>
            </div>

            <div id="booking-section" style="background: #fdfdfd; padding: 30px; border-radius: 15px; border: 1px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 30px;">
                <h3 style="margin-top: 0; color: #333;">
                    <?php 
                        if($data['lang'] == 'vi') echo "Phiếu Đặt Chỗ";
                        elseif($data['lang'] == 'lo') echo "ແບບຟອມຈອງ";
                        else echo "Book Your Trip";
                    ?>
                </h3>
                
                <form action="<?php echo URLROOT; ?>/place/book" method="POST">
                    <input type="hidden" name="place_id" value="<?php echo $data['place']['id']; ?>">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <input type="text" name="name" required 
                            placeholder="<?php echo ($data['lang'] == 'vi') ? 'Họ và tên' : (($data['lang'] == 'lo') ? 'ຊື່ ແລະ ນາມສະກຸນ' : 'Full Name'); ?>" 
                            style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        
                        <input type="email" name="email" required 
                            placeholder="<?php echo ($data['lang'] == 'vi') ? 'Địa chỉ Email' : (($data['lang'] == 'lo') ? 'ອີເມວ' : 'Email'); ?>" 
                            style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: #666;">
                            <?php echo ($data['lang'] == 'vi') ? 'Ngày dự kiến tham quan:' : (($data['lang'] == 'lo') ? 'ວັນທີຄາດວ່າຈະມາຢ້ຽມຢາມ:' : 'Expected date:'); ?>
                        </label>
                        <input type="date" name="date" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>

                    <button type="submit" style="width: 100%; padding: 15px; background: #ffcc00; border: none; font-weight: bold; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                        <?php 
                            if($data['lang'] == 'vi') echo "GỬI YÊU CẦU ĐẶT CHỖ";
                            elseif($data['lang'] == 'lo') echo "ສົ່ງຄຳຮ້ອງຈອງ";
                            else echo "SUBMIT REQUEST";
                        ?>
                    </button>
                </form>
            </div>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <div style="position: sticky; top: 100px;">
                <h3 style="margin-bottom: 15px;">🗺 <?php echo ($data['lang'] == 'vi') ? "Vị trí trên bản đồ" : (($data['lang'] == 'lo') ? "ແຜນທີ່" : "Location"); ?></h3>
                
                <div style="width: 100%; height: 450px; border-radius: 15px; overflow: hidden; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <iframe 
                        width="100%" height="100%" frameborder="0" style="border:0"
                        src="https://maps.google.com/maps?q=<?php echo $data['place']['latitude']; ?>,<?php echo $data['place']['longitude']; ?>&hl=<?php echo $data['lang']; ?>&z=15&output=embed" 
                        allowfullscreen>
                    </iframe>
                </div>
                
                <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $data['place']['latitude']; ?>,<?php echo $data['place']['longitude']; ?>" 
                   target="_blank" 
                   style="display: block; margin-top: 15px; text-align: center; background: #4285F4; color: white; padding: 15px; text-decoration: none; border-radius: 10px; font-weight: bold;">
                   🚀 <?php echo ($data['lang'] == 'vi') ? "Chỉ đường đi" : (($data['lang'] == 'lo') ? "ເສັ້ນທາງ" : "Get Directions"); ?>
                </a>
            </div>
        </div>
    </div>

    <hr style="margin: 60px 0; border: 0; border-top: 1px solid #eee;">
    <h2 style="text-align: center; margin-bottom: 40px;">
        <?php echo ($data['lang'] == 'vi') ? "Địa danh liên quan" : (($data['lang'] == 'lo') ? "ສະຖານທີ່ທີ່ກ່ຽວຂ້ອງ" : "Related Places"); ?>
    </h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
        <?php foreach($data['related'] as $rel): ?>
            <a href="<?php echo URLROOT; ?>/place/view/<?php echo $rel['id']; ?>" style="text-decoration: none; color: inherit;">
                <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                    <img src="<?php echo URLROOT; ?>/public/img/places/<?php echo $rel['image_main']; ?>" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 20px; text-align: center; font-weight: bold;"><?php echo htmlspecialchars($rel['name']); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>