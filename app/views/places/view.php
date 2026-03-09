<div style="max-width: 1100px; margin: 30px auto; padding: 20px; font-family: 'Segoe UI', Arial, sans-serif;">
    <h1 style="color: #333; margin-bottom: 20px;"><?php echo htmlspecialchars($data['place']['name_' . $data['lang']]); ?></h1>
    
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        
        <div style="flex: 2; min-width: 350px;">
            <img src="<?php echo URLROOT; ?>/public/img/places/<?php echo $data['place']['image_main']; ?>" 
                 style="width: 100%; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);"
                 onerror="this.onerror=null; this.src='<?php echo URLROOT; ?>/public/img/default.jpg';">
            
            <div style="margin-top: 30px; line-height: 1.8; color: #444; font-size: 1.1rem;">
                <h3 style="color: #ffcc00; border-left: 5px solid #ffcc00; padding-left: 15px;">
                    <?php echo $data['text']['intro']; ?>
                </h3>
                <p style="text-align: justify;"><?php echo nl2br(htmlspecialchars($data['place']['desc_' . $data['lang']])); ?></p>
                
                <p><strong>📍 <?php echo $data['text']['address']; ?>:</strong> 
                <?php echo htmlspecialchars($data['place']['addr_' . $data['lang']]); ?></p>
            </div>

            <div id="booking-section" style="background: #fdfdfd; padding: 30px; border-radius: 15px; border: 1px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 30px;">
                <h3 style="margin-top: 0; color: #333;"><?php echo $data['text']['booking_title']; ?></h3>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="<?php echo URLROOT; ?>/place/book" method="POST">
                        <input type="hidden" name="place_id" value="<?php echo $data['place']['id']; ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" readonly 
                                style="padding: 12px; border: 1px solid #eee; border-radius: 8px; background: #f5f5f5; color: #666;">
                            
                            <input type="email" name="email" value="<?php echo $_SESSION['user_email'] ?? ''; ?>" readonly 
                                style="padding: 12px; border: 1px solid #eee; border-radius: 8px; background: #f5f5f5; color: #666;">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: #666;">
                                <?php echo $data['text']['date_label']; ?>
                            </label>
                            <input type="date" name="date" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        </div>

                        <button type="submit" style="width: 100%; padding: 15px; background: #ffcc00; border: none; font-weight: bold; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                            <?php echo $data['text']['btn_book']; ?>
                        </button>
                    </form>
                <?php else: ?>
                    <div style="text-align: center; padding: 20px; border: 1px dashed #ccc; border-radius: 10px;">
                        <p><?php echo $data['text']['login_req']; ?></p>
                        <a href="<?php echo URLROOT; ?>/user/login" style="color: #ffcc00; font-weight: bold; text-decoration: none;">🔑 <?php echo $data['text']['login_btn']; ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <div id="comment-section" style="margin-top: 40px; padding: 30px; background: #fff; border-radius: 15px; border: 1px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <h3 style="color: #333; margin-bottom: 20px;"><?php echo $data['text']['comment_title']; ?></h3>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="<?php echo URLROOT; ?>/forum/add" method="POST" style="margin-bottom: 30px;">
                        <input type="hidden" name="place_id" value="<?php echo $data['place']['id']; ?>">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <input type="text" name="author_name" value="<?php echo $_SESSION['user_name']; ?>" readonly 
                                style="padding: 12px; border: 1px solid #eee; border-radius: 8px; background: #f5f5f5; color: #666;">
                            
                            <input type="text" name="title" required 
                                placeholder="<?php echo $data['text']['subject'] ?? 'Subject'; ?>" 
                                style="padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        </div>
                        <textarea name="content" required 
                            placeholder="<?php echo $data['text']['comment_placeholder']; ?>" 
                            style="width: 100%; height: 100px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;"></textarea>
                        
                        <button type="submit" style="padding: 12px 30px; background: #333; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
                            <?php echo $data['text']['btn_comment']; ?>
                        </button>
                    </form>
                <?php else: ?>
                    <p style="text-align: center; color: #999; padding: 10px; border-bottom: 1px solid #eee;">
                        <?php echo $data['text']['login_req']; ?>
                    </p>
                <?php endif; ?>

                <div class="comment-list">
                    <?php if(!empty($data['comments'])): ?>
                        <?php foreach($data['comments'] as $cmt): ?>
                            <div style="padding: 15px; border-bottom: 1px solid #f0f0f0; margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #007bff;"><?php echo htmlspecialchars($cmt['author_name']); ?></strong>
                                    <span style="font-size: 0.8rem; color: #999;"><?php echo date('d/m/Y H:i', strtotime($cmt['created_at'])); ?></span>
                                </div>
                                <h4 style="margin: 10px 0 5px 0;"><?php echo htmlspecialchars($cmt['title']); ?></h4>
                                <p style="margin: 0; color: #555;"><?php echo nl2br(htmlspecialchars($cmt['content'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <div style="position: sticky; top: 100px;">
                <h3 style="margin-bottom: 15px;">🗺 <?php echo $data['text']['location']; ?></h3>
                
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
                   🚀 <?php echo $data['text']['direction']; ?>
                </a>
            </div>
        </div>
    </div>

    <hr style="margin: 60px 0; border: 0; border-top: 1px solid #eee;">
    <h2 style="text-align: center; margin-bottom: 40px;">
        <?php echo $data['text']['related']; ?>
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

<?php require_once '../app/views/inc/footer.php'; ?>