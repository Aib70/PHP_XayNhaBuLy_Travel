/**
 * 1. กำหนดตัวแปรอ้างอิงถึง HTML Elements
 */
const chatToggle = document.getElementById('chat-toggle-btn'); // ปุ่มไอคอนแชท
const chatWindow = document.getElementById('chat-window');     // หน้าต่างแชท
const closeChat = document.getElementById('close-chat');       // ปุ่มปิดหน้าต่างแชท
const sendBtn = document.getElementById('send-btn');           // ปุ่มส่งข้อความ
const userInput = document.getElementById('user-input');       // ช่องกรอกข้อความ
const chatContent = document.getElementById('chat-content');   // พื้นที่แสดงข้อความ

/**
 * 2. ส่วนควบคุมการเปิด-ปิดหน้าต่างแชท
 */
if (chatToggle) {
    chatToggle.onclick = () => chatWindow.classList.toggle('hidden');
}
if (closeChat) {
    closeChat.onclick = () => chatWindow.classList.add('hidden');
}

/**
 * 3. ฟังก์ชันสำหรับเพิ่ม Bubble ข้อความลงในหน้าจอ
 * @param {string} role - ระบุ 'user' (ผู้ใช้) หรือ 'ai' (บอท)
 * @param {string} text - ข้อความที่จะแสดง
 */
function appendMessage(role, text) {
    const msgDiv = document.createElement('div');
    msgDiv.className = `msg ${role}`; // คลาส CSS สำหรับตกแต่งแยกฝั่ง
    msgDiv.innerText = text;
    chatContent.appendChild(msgDiv);
    
    // เลื่อนหน้าจอลงไปล่างสุดโดยอัตโนมัติ
    chatContent.scrollTop = chatContent.scrollHeight;
}

/**
 * 4. ฟังก์ชันหลักในการส่งข้อความไปประมวลผลที่ Backend
 */
async function sendMessage() {
    const text = userInput.value.trim();
    if (!text) return; // ไม่ส่งข้อความว่าง

    appendMessage("user", text); // แสดงข้อความฝั่งผู้ใช้
    userInput.value = "";        // ล้างช่องกรอก

    // สร้างสถานะกำลังพิมพ์ (Typing indicator)
    const typingDiv = document.createElement("div");
    typingDiv.className = "msg ai typing";
    typingDiv.innerText = "...";
    chatContent.appendChild(typingDiv);
    chatContent.scrollTop = chatContent.scrollHeight;

    try {
        // กำหนด URL ของ Controller ในฝั่ง Backend (PHP)
        const targetUrl = `${window.location.origin}/xayabury_travel/home/ai_chat_api`;

        const response = await fetch(targetUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({ message: text }),
        });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Server error: ${response.status}`);
        }

        const data = await response.json();
        typingDiv.remove(); // ลบสถานะกำลังพิมพ์ออก

        if (data.reply) {
            appendMessage("ai", data.reply); // แสดงข้อความตอบกลับจาก AI
        } else {
            appendMessage("ai", "Rất tiếc, hệ thống hiện không thể phản hồi.");
        }
    } catch (error) {
        if (typingDiv) typingDiv.remove();
        console.error("Fetch error:", error);
        appendMessage("ai", "Đã xảy ra lỗi kết nối. Vui lòng thử lại.");
    }
}

/**
 * 5. ตั้งค่าการเรียกใช้งาน (Event Listeners)
 */
// เมื่อคลิกปุ่มส่ง
if (sendBtn) {
    sendBtn.onclick = sendMessage;
}

// เมื่อกดปุ่ม Enter ในช่องกรอกข้อความ
if (userInput) {
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
}