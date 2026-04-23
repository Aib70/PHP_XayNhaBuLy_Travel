<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Trợ giúp - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* TỔNG THỂ */
        body { font-family: 'Segoe UI', Tahoma, sans-serif; padding: 30px; background-color: #f8fafc; color: #333; }
        .container { padding: 40px; max-width: 1200px; margin: auto; }

        /* NÚT DASHBOARD ĐỒNG BỘ */
        .btn-dashboard {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white !important; padding: 10px 22px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 14px;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
            transition: 0.3s; margin-bottom: 30px;
        }
        .btn-dashboard:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* TIÊU ĐỀ */
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        h1 { margin: 0; font-size: 28px; color: #1e293b; font-weight: 800; display: flex; align-items: center; gap: 12px; }

        /* BẢNG PHONG CÁCH THẺ (CARD TABLE) */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { 
            background-color: #1e293b; color: #f8fafc; padding: 18px; 
            font-size: 13px; text-transform: uppercase; text-align: left; border: none; 
        }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }

        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }

        .admin-table td { padding: 20px; border: none; vertical-align: top; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        /* BADGE SỐ THỨ TỰ & THÔNG TIN KHÁCH */
        .badge-stt { background: #334155; color: #fff; padding: 5px 12px; border-radius: 6px; font-weight: bold; }
        .sender-name { font-weight: bold; color: #1e293b; font-size: 16px; display: block; margin-bottom: 5px; }
        .contact-tag { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; }
        .time { font-size: 0.8rem; color: #94a3b8; display: block; margin-top: 8px; }

        /* NỘI DUNG TIN NHẮN */
        .message-content { line-height: 1.6; color: #475569; font-style: italic; background: #f8fafc; padding: 15px; border-radius: 10px; border-left: 4px solid #cbd5e1; }

        /* NÚT XÓA */
        .btn-delete { 
            color: #ef4444; text-decoration: none; font-weight: bold; 
            border: 1.5px solid #ef4444; padding: 8px 16px; border-radius: 8px; 
            font-size: 13px; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-delete:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-dashboard">
            <i class="fa-solid fa-house-chimney"></i> Dashboard (Tổng quan)
        </a>

        <div class="header">
            <h1><i class="fa-solid fa-envelope-open-text" style="color: #e84393;"></i> Quản lý yêu cầu trợ giúp</h1>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th width="80">STT</th>
                    <th width="25%">Khách hàng</th>
                    <th width="50%">Nội dung tin nhắn</th>
                    <th width="15%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; if(!empty($data['requests'])): foreach($data['requests'] as $req): ?>
                <tr>
                    <td><span class="badge-stt"><?= $stt++; ?></span></td>
     <td>
    <span class="sender-name" style="font-weight: bold; font-size: 1.1rem; color: #1e293b;">
        <?= htmlspecialchars($req['name']) ?>
    </span>
    
    <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 8px;">
        <a href="mailto:<?= htmlspecialchars($req['contact_info']) ?>" 
           class="contact-tag" 
           style="text-decoration: none; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;"
           title="Nhấn để gửi email cho khách">
            <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($req['contact_info']) ?>
        </a>

        <?php if(!empty($req['register_phone'])): ?>
            <span class="contact-tag" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                <i class="fa-solid fa-phone"></i> <?= htmlspecialchars($req['register_phone']) ?>
            </span>
        <?php else: ?>
            <small style="color: #94a3b8; font-style: italic;">(Không tìm thấy SĐT đăng ký)</small>
        <?php endif; ?>
    </div>

    <span class="time" style="display: block; margin-top: 10px; font-size: 0.8rem; color: #94a3b8;">
        <i class="fa-regular fa-clock"></i> <?= date('H:i d/m/Y', strtotime($req['created_at'])) ?>
    </span>
</td>
                    <td>
                        <div class="message-content">
                            "<?= nl2br(htmlspecialchars($req['message'])) ?>"
                        </div>
                    </td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/delete_help/<?= $req['id'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Bạn đã xử lý xong và muốn xóa yêu cầu này?')">
                           <i class="fa-solid fa-trash-can"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 50px; color: #94a3b8; font-style: italic;">
                        📭 Hiện chưa có yêu cầu trợ giúp nào từ khách hàng.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>