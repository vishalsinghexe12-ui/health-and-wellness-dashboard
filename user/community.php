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
    $_SESSION['login_error'] = "This is a premium feature. Please upgrade your membership to access the Private Community.";
    header("Location: memberships.php");
    exit();
}

$title = "Private Community";
$css = "register-dashboard.css"; // Ensure standard dashboard layout style applies
ob_start();
?>

<!-- Community CSS inline for simplicity -->
<style>
    .community-wrapper {
        display: flex;
        height: calc(100vh - 120px);
        background: #f8fafc;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .channels-sidebar {
        width: 250px;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        padding: 20px 0;
        display: flex;
        flex-direction: column;
    }
    .channel-item {
        padding: 12px 24px;
        color: #64748b;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }
    .channel-item:hover {
        background: rgba(16, 185, 129, 0.05);
        color: #10b981;
    }
    .channel-item.active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border-right: 3px solid #10b981;
    }
    .chat-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f8fafc;
    }
    .chat-header {
        padding: 20px 30px;
        background: white;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chat-messages {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
    }
    .message {
        display: flex;
        margin-bottom: 24px;
    }
    .msg-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #e2e8f0;
        margin-right: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .msg-content {
        background: white;
        padding: 16px 20px;
        border-radius: 0 16px 16px 16px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        max-width: 80%;
    }
    .msg-content.mine {
        background: #10b981;
        color: white;
        border-radius: 16px 0 16px 16px;
    }
    .msg-input-area {
        padding: 20px 30px;
        background: white;
        border-top: 1px solid #e2e8f0;
    }
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .chat-input {
        width: 100%;
        border: 1px solid #e2e8f0;
        background: #f1f5f9;
        border-radius: 30px;
        padding: 15px 60px 15px 25px;
        outline: none;
        transition: all 0.2s;
    }
    .chat-input:focus {
        border-color: #10b981;
        background: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }
    .send-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #10b981;
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .send-btn:hover {
        background: #059669;
    }
    .members-sidebar {
        width: 250px;
        background: white;
        border-left: 1px solid #e2e8f0;
        padding: 20px 0;
    }
    .member-item {
        display: flex;
        align-items: center;
        padding: 10px 24px;
    }
    .member-status {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        margin-left: auto;
    }
</style>

<div class="container-fluid py-4 px-5">
    
    <div class="d-flex align-items-center mb-4">
        <div>
            <span class="badge badge-warning text-dark px-3 py-2 mb-2" style="border-radius: 8px;"><i class="fa-solid fa-crown mr-1"></i> Premium Feature</span>
            <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Private Community</h2>
            <p class="text-muted m-0">Connect, share your progress, and get inspired by fellow members.</p>
        </div>
    </div>

    <div class="community-wrapper">
        <!-- Channels -->
        <div class="channels-sidebar">
            <h6 class="text-muted px-4 mb-3 font-weight-bold" style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Channels</h6>
            <a href="#" class="channel-item active"><i class="fa-solid fa-hashtag mr-3"></i> General Chat</a>
            <a href="#" class="channel-item"><i class="fa-solid fa-hashtag mr-3"></i> Form Check</a>
            <a href="#" class="channel-item"><i class="fa-solid fa-hashtag mr-3"></i> Diet Recipes</a>
            <a href="#" class="channel-item"><i class="fa-solid fa-hashtag mr-3"></i> Success Stories</a>
            <a href="#" class="channel-item"><i class="fa-solid fa-bullhorn mr-3"></i> Announcements</a>
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <div class="chat-header">
                <div>
                    <h5 class="m-0 font-weight-bold"><i class="fa-solid fa-hashtag text-muted mr-2"></i>General Chat</h5>
                    <small class="text-muted">Welcome to the main lobby!</small>
                </div>
                <div>
                    <i class="fa-solid fa-circle-info text-muted" style="font-size: 20px; cursor: pointer;"></i>
                </div>
            </div>

            <div class="chat-messages">
                <!-- Example Message -->
                <div class="message">
                    <div class="msg-avatar">
                        <img src="../images/testimonial-1.jpg" style="width:100%; height:100%; object-fit:cover;" onerror="this.src=''; this.className='fa-solid fa-user text-muted'">
                    </div>
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="font-weight-bold mr-2">Sarah Jenkins</span>
                            <small class="text-muted">10:42 AM</small>
                        </div>
                        <div class="msg-content">
                            Hey everyone! Just finished my first week on the Elite plan. Down 2kg already and feeling super energetic. Anyone else trying the Keto recipes? 🥑
                        </div>
                    </div>
                </div>

                <!-- Example Message -->
                <div class="message">
                    <div class="msg-avatar">
                        <img src="../images/testimonial-2.jpg" style="width:100%; height:100%; object-fit:cover;" onerror="this.src=''; this.className='fa-solid fa-user text-muted'">
                    </div>
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="font-weight-bold mr-2">Mike T.</span>
                            <small class="text-muted">10:45 AM</small>
                        </div>
                        <div class="msg-content">
                            Awesome job Sarah! Keep it up. I'm doing the high-protein meal prep today.
                        </div>
                    </div>
                </div>
                
                <!-- My Message (simulated) -->
                <div class="message" style="flex-direction: row-reverse;">
                    <div class="msg-avatar" style="margin-right: 0; margin-left: 16px;">
                        <i class="fa-solid fa-user text-muted"></i>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <div class="d-flex align-items-center mb-1">
                            <small class="text-muted mr-2">10:50 AM</small>
                            <span class="font-weight-bold">You</span>
                        </div>
                        <div class="msg-content mine">
                            That's amazing Sarah! I just joined the community today. Looking forward to learning from everyone here. 💪
                        </div>
                    </div>
                </div>
            </div>

            <div class="msg-input-area">
                <div class="input-wrapper">
                    <input type="text" class="chat-input" placeholder="Message #General Chat...">
                    <button class="send-btn"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <!-- Members -->
        <div class="members-sidebar">
            <h6 class="text-muted px-4 mb-3 font-weight-bold" style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Online — 3</h6>
            
            <div class="member-item">
                <div class="msg-avatar" style="width: 32px; height: 32px; margin-right: 12px;"><i class="fa-solid fa-user text-muted" style="font-size: 12px;"></i></div>
                <span style="font-size: 14px; font-weight: 500;">Sarah Jenkins</span>
                <div class="member-status"></div>
            </div>
            
            <div class="member-item">
                <div class="msg-avatar" style="width: 32px; height: 32px; margin-right: 12px;"><i class="fa-solid fa-user text-muted" style="font-size: 12px;"></i></div>
                <span style="font-size: 14px; font-weight: 500;">Mike T.</span>
                <div class="member-status"></div>
            </div>

            <div class="member-item">
                <div class="msg-avatar" style="width: 32px; height: 32px; margin-right: 12px;"><i class="fa-solid fa-user-doctor text-success" style="font-size: 12px;"></i></div>
                <span style="font-size: 14px; font-weight: 500; color: #10b981;">Coach Alex <i class="fa-solid fa-circle-check ml-1"></i></span>
                <div class="member-status"></div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
