<?php require_once("admin_auth.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : "Admin - Health & Wellness"; ?></title>

    <!-- Google Fonts Outfit + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Admin CSS -->
    <?php
    if(isset($css)){
        echo '<link rel="stylesheet" href="'.$css.'">';
    }
    ?>
</head>

<body class="d-flex flex-column min-vh-100" style="font-family: 'Inter', sans-serif;">

    <!-- Admin Navigation Bar -->
    <div class="container-fluid p-0 sticky-top" style="z-index: 1030; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-4">
                <a class="navbar-brand d-flex align-items-center" href="admin.php">
                    <img class="guest-nav-image" src="../images/logo.jpeg" style="height:48px; width:auto; border-radius:8px; margin-right:12px;" alt="Logo"/>
                    <span class="guest-navbar-heading" style="font-weight: 800; font-size: 26px; background: linear-gradient(135deg, #047857, #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Health & Wellness</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="adminNavbar">
                    <div class="navbar-nav ml-auto align-items-center">
                        <a class="nav-link font-weight-bold mr-2 text-dark" href="admin.php"><i class="fa-solid fa-gauge mr-1"></i> Dashboard</a>
                        <a class="nav-link font-weight-bold mr-2 text-dark" href="users.php"><i class="fa-solid fa-users mr-1"></i> Users</a>
                        <a class="nav-link font-weight-bold mr-2 text-dark" href="plans.php"><i class="fa-solid fa-dumbbell mr-1"></i> Plans</a>
                        <a class="nav-link font-weight-bold mr-2 text-dark" href="messages.php"><i class="fa-solid fa-envelope mr-1"></i> Messages</a>
                        <a class="nav-link bg-success text-white ml-2 px-3 py-2" style="border-radius: 8px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);" href="admin-profile.php">
                            <i class="fa-regular fa-user mr-1"></i> Profile
                        </a>
                        <a class="nav-link bg-danger text-white ml-2 px-3 py-2" style="border-radius: 8px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);" href="../login.php">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

<!-- PAGE CONTENT -->
<main class="flex-fill d-flex flex-column">
    <?php
    if(isset($content)){
        echo $content;
    }
    ?>
</main>

<!-- Footer Section -->
<footer style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); color: #e2e8f0; margin-top: auto; position: relative; overflow: hidden;">
    <div style="height: 4px; background: linear-gradient(90deg, #059669, #10b981, #0d9488, #059669); background-size: 300% 100%; animation: gradientMove 4s ease infinite;"></div>
    
    <div class="container" style="padding: 60px 15px 0;">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="../images/logo.jpeg" alt="Logo" style="height: 42px; width: auto; border-radius: 8px; margin-right: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    <h4 style="font-family: 'Outfit', sans-serif; font-weight: 800; margin: 0; background: linear-gradient(135deg, #10b981, #0d9488); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Health & Wellness</h4>
                </div>
                <p style="color: #94a3b8; font-size: 15px; line-height: 1.8; margin-bottom: 20px;">Empowering you to live a healthier, stronger, and more balanced life. Your wellness journey starts here.</p>
                <div class="d-flex" style="gap: 12px;">
                    <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); display: flex; align-items: center; justify-content: center; color: #10b981; text-decoration: none; transition: all 0.3s ease; font-size: 16px;" onmouseover="this.style.background='#10b981';this.style.color='white';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 20px rgba(16,185,129,0.4)'" onmouseout="this.style.background='rgba(16,185,129,0.1)';this.style.color='#10b981';this.style.transform='translateY(0)';this.style.boxShadow='none'"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); display: flex; align-items: center; justify-content: center; color: #10b981; text-decoration: none; transition: all 0.3s ease; font-size: 16px;" onmouseover="this.style.background='#10b981';this.style.color='white';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 20px rgba(16,185,129,0.4)'" onmouseout="this.style.background='rgba(16,185,129,0.1)';this.style.color='#10b981';this.style.transform='translateY(0)';this.style.boxShadow='none'"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); display: flex; align-items: center; justify-content: center; color: #10b981; text-decoration: none; transition: all 0.3s ease; font-size: 16px;" onmouseover="this.style.background='#10b981';this.style.color='white';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 20px rgba(16,185,129,0.4)'" onmouseout="this.style.background='rgba(16,185,129,0.1)';this.style.color='#10b981';this.style.transform='translateY(0)';this.style.boxShadow='none'"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); display: flex; align-items: center; justify-content: center; color: #10b981; text-decoration: none; transition: all 0.3s ease; font-size: 16px;" onmouseover="this.style.background='#10b981';this.style.color='white';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 20px rgba(16,185,129,0.4)'" onmouseout="this.style.background='rgba(16,185,129,0.1)';this.style.color='#10b981';this.style.transform='translateY(0)';this.style.boxShadow='none'"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6 mb-4">
                <h6 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #f1f5f9; margin-bottom: 20px; font-size: 16px;">Admin Panel</h6>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;"><a href="admin.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Dashboard</a></li>
                    <li style="margin-bottom: 12px;"><a href="users.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Users</a></li>
                    <li style="margin-bottom: 12px;"><a href="plans.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Plans</a></li>
                    <li><a href="messages.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Messages</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 col-6 mb-4">
                <h6 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #f1f5f9; margin-bottom: 20px; font-size: 16px;">Manage</h6>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 12px;"><a href="admin-meal-plans.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Meal Plans</a></li>
                    <li style="margin-bottom: 12px;"><a href="admin-exercise-plans.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Exercise Plans</a></li>
                    <li style="margin-bottom: 12px;"><a href="add-plans.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Add Plan</a></li>
                    <li><a href="admin-profile.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Profile</a></li>
                    <li style="margin-top: 12px;"><a href="change-password.php" style="color: #94a3b8; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#10b981';this.style.paddingLeft='5px'" onmouseout="this.style.color='#94a3b8';this.style.paddingLeft='0'">Change Password</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <h6 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #f1f5f9; margin-bottom: 20px; font-size: 16px;">Stay Updated</h6>
                <p style="color: #94a3b8; font-size: 14px; margin-bottom: 15px;">Subscribe to get the latest health tips and updates.</p>
                <div class="d-flex" style="gap: 8px;">
                    <input type="email" placeholder="Enter your email" style="flex: 1; padding: 12px 16px; border: 1px solid rgba(16,185,129,0.2); border-radius: 10px; background: rgba(255,255,255,0.05); color: #e2e8f0; font-size: 14px; outline: none;">
                    <button style="padding: 12px 20px; background: linear-gradient(135deg, #059669, #0d9488); border: none; border-radius: 10px; color: white; font-family: 'Outfit', sans-serif; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; white-space: nowrap;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(16,185,129,0.4)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">Subscribe</button>
                </div>
                <div style="margin-top: 20px; padding: 15px; background: rgba(16,185,129,0.08); border-radius: 10px; border: 1px solid rgba(16,185,129,0.15);">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-headset" style="font-size: 20px; color: #10b981; margin-right: 12px;"></i>
                        <div>
                            <p style="margin: 0; font-size: 13px; color: #94a3b8;">24/7 Support</p>
                            <p style="margin: 0; font-weight: 600; color: #f1f5f9; font-size: 15px;">+91 98765 43210</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="border-top: 1px solid rgba(255,255,255,0.06); margin-top: 20px; padding: 20px 0; background: rgba(0,0,0,0.15);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left">
                    <p style="margin: 0; font-size: 13px; color: #64748b;">© <?php echo date("Y"); ?> Health & Wellness. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <a href="#" style="color: #64748b; text-decoration: none; font-size: 13px; margin-left: 20px;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#64748b'">Privacy Policy</a>
                    <a href="#" style="color: #64748b; text-decoration: none; font-size: 13px; margin-left: 20px;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#64748b'">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
    <style>@keyframes gradientMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }</style>
</footer>

</body>
</html>
