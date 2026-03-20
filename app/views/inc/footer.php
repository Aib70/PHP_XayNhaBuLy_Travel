<?php 
    // Bộ từ điển đa ngôn ngữ cho Footer
    $lang = $_SESSION['lang'] ?? 'vi';
    $f_text = [
        'vi' => [
            'desc' => 'Khám phá vẻ đẹp hoang sơ và văn hóa đặc sắc của Xayabury, Lào. Chúng tôi cung cấp những trải nghiệm du lịch tuyệt vời nhất.',
            'quick_links' => 'Liên kết nhanh',
            'contact' => 'Liên hệ',
            'address' => 'Tỉnh Xayabury, CHDCND Lào',
            'rights' => 'Tất cả quyền được bảo lưu.'
        ],
        'lo' => [
            'desc' => 'ສຳຫຼວດຄວາມສວຍງາມ ແລະ ວັດທະນະທຳທີ່ເປັນເອກະລັກຂອງ ໄຊຍະບູລີ, ລາວ. ພວກເຮົາໃຫ້ປະສົບການການທ່ອງທ່ຽວທີ່ດີທີ່ສຸດ.',
            'quick_links' => 'ລິ້ງດ່ວນ',
            'contact' => 'ຕິດຕໍ່',
            'address' => 'ແຂວງໄຊຍະບູລີ, ສປປ ລາວ',
            'rights' => 'ສະຫງວນລິຂະສິດທັງໝົດ.'
        ],
        'en' => [
            'desc' => 'Explore the untouched beauty and unique culture of Xayabury, Laos. We provide the best travel experiences.',
            'quick_links' => 'Quick Links',
            'contact' => 'Contact Us',
            'address' => 'Xayabury Province, Lao PDR',
            'rights' => 'All rights reserved.'
        ]
    ];
    $footer = $f_text[$lang];
?>

<footer style="background: #222; color: #bbb; padding: 60px 0 30px 0; margin-top: 50px; font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="max-width: 1100px; margin: auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; padding: 0 20px;">
        
        <div>
            <h3 style="color: #ffcc00; margin-bottom: 20px;">XAYABURY TRAVEL</h3>
            <p style="line-height: 1.6; font-size: 0.95rem; text-align: justify;">
                <?php echo $footer['desc']; ?>
            </p>
        </div>

        <div>
            <h4 style="color: #fff; margin-bottom: 20px;"><?php echo $footer['quick_links']; ?></h4>
            <ul style="list-style: none; padding: 0; line-height: 2;">
                <li><a href="<?php echo URLROOT; ?>" style="color: #bbb; text-decoration: none; transition: 0.3s;">🏠 <?php echo ($lang == 'vi') ? 'Trang chủ' : (($lang == 'lo') ? 'ໜ້າຫຼັກ' : 'Home'); ?></a></li>
                <li><a href="#" style="color: #bbb; text-decoration: none; transition: 0.3s;">📍 <?php echo ($lang == 'vi') ? 'Địa danh' : (($lang == 'lo') ? 'ສະຖານທີ່' : 'Places'); ?></a></li>
                <li><a href="<?php echo URLROOT; ?>/user/register" style="color: #bbb; text-decoration: none; transition: 0.3s;">📝 <?php echo ($lang == 'vi') ? 'Đăng ký' : (($lang == 'lo') ? 'ລົງທະບຽນ' : 'Register'); ?></a></li>
            </ul>
        </div>

        <div>
            <h4 style="color: #fff; margin-bottom: 20px;"><?php echo $footer['contact']; ?></h4>
            <p style="font-size: 0.9rem; margin-bottom: 10px;">📍 <?php echo $footer['address']; ?></p>
            <p style="font-size: 0.9rem; margin-bottom: 10px;">📞 +856 20 XXXX XXXX</p>
            <p style="font-size: 0.9rem;">📧 info@xayaburytravel.gov.la</p>
        </div>

    </div>

    <div style="text-align: center; border-top: 1px solid #333; margin-top: 50px; padding-top: 30px; font-size: 0.85rem;">
        <p>&copy; <?php echo date('Y'); ?> <strong>Xayabury Travel</strong>. <?php echo $footer['rights']; ?></p>
    </div>
</footer>
<!-- Chatbox Wrapper -->
<div id="ai-chat-wrapper">
    <!-- ปุ่มวงกลมสำหรับเปิดแชท -->
    <button id="chat-toggle-btn">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg" alt="Messenger AI">
    </button>

    <!-- หน้าต่างแชท (ซ่อนไว้เริ่มต้น) -->
    <div id="chat-window" class="hidden">
        <div class="chat-header">
            <div class="admin-info">
                <div class="online-dot"></div>
                <span>Support AI (Xayabury)</span>
            </div>
            <button id="close-chat">&times;</button>
        </div>
        <div id="chat-content">
            <div class="msg ai">สวัสดีครับ! มีอะไรให้ Xayabury Travel ช่วยเหลือไหมครับ?</div>
        </div>
        <div class="chat-input-area">
            <input type="text" id="user-input" placeholder="พิมพ์ข้อความที่นี่...">
            <button id="send-btn">ส่ง</button>
        </div>
    </div>
</div>

<!-- เชื่อมต่อไฟล์ JS ที่คุณสร้างไว้ -->
<script src="<?= URLROOT ?>/js/chatBoot.js"></script>



<style>
#ai-chat-wrapper { position: fixed; bottom: 20px; right: 20px; z-index: 1000; font-family: 'Segoe UI', sans-serif; }
#chat-toggle-btn { width: 60px; height: 60px; border-radius: 50%; border: none; background: #0084ff; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
#chat-toggle-btn img { width: 35px; }

#chat-window { width: 350px; height: 450px; background: white; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); display: flex; flex-direction: column; overflow: hidden; position: absolute; bottom: 80px; right: 0; transition: 0.3s; }
.hidden { display: none !important; }

.chat-header { background: #0084ff; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; }
.online-dot { width: 10px; height: 10px; background: #2ecc71; border-radius: 50%; display: inline-block; margin-right: 5px; }

#chat-content { flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; background: #f0f2f5; }
.msg { padding: 10px 15px; border-radius: 18px; max-width: 80%; font-size: 14px; line-height: 1.4; }
.msg.ai { background: white; align-self: flex-start; border-bottom-left-radius: 2px; }
.msg.user { background: #0084ff; color: white; align-self: flex-end; border-bottom-right-radius: 2px; }

.chat-input-area { padding: 10px; display: flex; gap: 5px; border-top: 1px solid #eee; }
#user-input { flex: 1; border: none; background: #f0f2f5; padding: 8px 15px; border-radius: 20px; outline: none; }
#send-btn { border: none; background: none; color: #0084ff; font-weight: bold; cursor: pointer; }
</style>

