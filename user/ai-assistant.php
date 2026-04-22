<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php");
    exit();
}
require_once("../db_config.php");

$user_id = $_SESSION['user_id'];

// Restrict Access to Active Members Only
$check_membership = $con->prepare("SELECT 1 FROM user_memberships WHERE user_id = ? AND end_date > NOW() AND status = 'Active' UNION SELECT 1 FROM user_purchases p JOIN memberships m ON p.plan_name = m.title WHERE p.user_id = ? AND p.status = 'Active'");
$check_membership->bind_param("ii", $user_id, $user_id);
$check_membership->execute();
$mbr_result = $check_membership->get_result();

if ($mbr_result->num_rows == 0) {
    $_SESSION['login_error'] = "This is a premium feature. Please upgrade to Elite status to access the AI Fitness Assistant.";
    header("Location: memberships.php");
    exit();
}

$title = "AI Fitness Assistant";
$css = "register-dashboard.css"; 
ob_start();
?>

<style>
    .ai-wrapper {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 120px);
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        position: relative;
    }
    .ai-header {
        padding: 20px 30px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ai-chat-box {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
    }
    .bubble {
        max-width: 75%;
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 24px;
        font-size: 15px;
        line-height: 1.5;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .bubble.ai {
        align-self: flex-start;
        background: white;
        color: #1e293b;
        border-radius: 4px 20px 20px 20px;
        border: 1px solid #e2e8f0;
    }
    .bubble.user {
        align-self: flex-end;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-radius: 20px 4px 20px 20px;
    }
    .ai-input-area {
        padding: 24px 30px;
        background: white;
        border-top: 1px solid #e2e8f0;
    }
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: white;
        border: 1px solid #cbd5e1;
        border-radius: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        transition: all 0.3s;
    }
    .input-wrapper:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .ai-input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 16px 20px;
        outline: none;
        font-size: 16px;
    }
    .ai-send-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #3b82f6;
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .ai-send-btn:hover {
        background: #2563eb;
    }
    .typing-indicator {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 16px 20px;
        background: white;
        border-radius: 4px 20px 20px 20px;
        border: 1px solid #e2e8f0;
        align-self: flex-start;
        margin-bottom: 24px;
        display: none;
    }
    .typing-indicator span {
        width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out both;
    }
    .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
    .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
    .suggested-prompts {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        overflow-x: auto;
        padding-bottom: 8px;
    }
    .suggested-prompts::-webkit-scrollbar { height: 4px; }
    .suggested-prompts::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .prompt-chip {
        padding: 8px 16px;
        background: white;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        font-size: 13px;
        color: #475569;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .prompt-chip:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
</style>

<div class="container-fluid py-4 px-5">
    
    <div class="ai-wrapper">
        <div class="ai-header">
            <div class="d-flex align-items-center">
                <div style="width:48px; height:48px; border-radius:12px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center; margin-right:16px;">
                    <i class="fa-solid fa-robot text-white" style="font-size: 24px;"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold">Aura — AI Fitness Assistant</h5>
                    <small style="color: rgba(255,255,255,0.7);">Powered by intelligence</small>
                </div>
            </div>
            <div>
                <span class="badge badge-primary px-3 py-2" style="border-radius:8px;"><i class="fa-solid fa-bolt text-warning mr-1"></i> Connected</span>
            </div>
        </div>

        <div class="ai-chat-box" id="chatBox">
            <div class="bubble ai d-flex align-items-start">
                <div class="mr-3 mt-1"><i class="fa-solid fa-robot text-primary"></i></div>
                <div>
                    <strong>Hi there! I'm Aura.</strong><br><br>
                    I am your personal AI Fitness Assistant. I can help you with:<br>
                    • Generating custom meal plans based on your macros.<br>
                    • Creating on-the-fly workout routines.<br>
                    • Analyzing your fitness progress.<br>
                    • Answering health and wellness questions.<br><br>
                    How can I assist you today?
                </div>
            </div>
            
            <div class="typing-indicator" id="typingIndicator">
                <span></span><span></span><span></span>
            </div>
        </div>

        <div class="ai-input-area">
            <div class="suggested-prompts" id="promptsContainer">
                <div class="prompt-chip" onclick="fillPrompt('Create a 30-min HIIT workout')">Create a 30-min HIIT workout</div>
                <div class="prompt-chip" onclick="fillPrompt('What should I eat for post-workout recovery?')">Post-workout recovery meals</div>
                <div class="prompt-chip" onclick="fillPrompt('How do I calculate my daily calorie needs?')">Calculate daily calories</div>
                <div class="prompt-chip" onclick="fillPrompt('Tips for better sleep and recovery')">Tips for better sleep</div>
            </div>
            <form id="aiForm" onsubmit="event.preventDefault(); sendMessage();">
                <div class="input-wrapper">
                    <input type="text" id="userInput" class="ai-input" placeholder="Ask Aura anything..." required autocomplete="off">
                    <button type="submit" class="ai-send-btn"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    const chatBox = document.getElementById('chatBox');
    const userInput = document.getElementById('userInput');
    const typingIndicator = document.getElementById('typingIndicator');
    const aiForm = document.getElementById('aiForm');

    function fillPrompt(text) {
        userInput.value = text;
        userInput.focus();
    }

    function sendMessage() {
        const text = userInput.value.trim();
        if(!text) return;

        // Add user bubble
        appendBubble(text, 'user');
        userInput.value = '';
        
        // Show typing
        chatBox.appendChild(typingIndicator); // move to bottom
        typingIndicator.style.display = 'inline-flex';
        scrollToBottom();

        // Simulate AI Response Delay
        setTimeout(() => {
            typingIndicator.style.display = 'none';
            const response = generateMockResponse(text);
            appendBubble(response, 'ai');
        }, 1500 + Math.random() * 1000); // 1.5 - 2.5s delay
    }

    function appendBubble(text, sender) {
        const div = document.createElement('div');
        div.className = `bubble ${sender}`;
        
        if(sender === 'ai') {
            div.innerHTML = `<div class="d-flex align-items-start">
                                <div class="mr-3 mt-1"><i class="fa-solid fa-robot text-primary"></i></div>
                                <div>${text}</div>
                             </div>`;
        } else {
            div.textContent = text;
        }
        
        chatBox.appendChild(div);
        scrollToBottom();
    }

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function generateMockResponse(text) {
        const lower = text.toLowerCase();
        if(lower.includes('hiit') || lower.includes('workout')) {
            return "Here is a quick 30-minute HIIT routine for you:<br><br>1. Jumping Jacks - 45s (15s rest)<br>2. Burpees - 45s (15s rest)<br>3. High Knees - 45s (15s rest)<br>4. Mountain Climbers - 45s (15s rest)<br>5. Plank - 60s<br><br>Repeat this circuit 4 times! Ensure you warm up before starting.";
        } else if(lower.includes('eat') || lower.includes('meal') || lower.includes('food') || lower.includes('recovery')) {
            return "For post-workout recovery, prioritize <b>Protein</b> and <b>Carbohydrates</b>.<br><br>A great option would be:<br>- A scoop of whey protein with a banana.<br>- Grilled chicken breast with sweet potatoes and broccoli.<br>- Greek yogurt with a handful of berries and a drizzle of honey.<br><br>Staying hydrated is also key!";
        } else if(lower.includes('hello') || lower.includes('hi')) {
            return "Hello! How is your fitness journey going today?";
        } else {
            return "That's a great question! As my API integration is currently being finalized, I am running in simulation mode. Soon I will be able to provide detailed, AI-generated answers for your request. Keep pushing towards your goals!";
        }
    }
</script>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
