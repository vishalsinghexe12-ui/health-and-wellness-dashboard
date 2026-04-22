<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

$title = "Manage Pages Content";
$css = "admin.css"; 
ob_start();

require_once("../db_config.php");

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_page'])) {
    $page_type = $_POST['page_type'] ?? '';
    $page_title = $_POST['page_title'] ?? '';
    $page_desc = $_POST['page_desc'] ?? '';
    
    if (!empty($page_type)) {
        $stmt = $con->prepare("UPDATE tblpage SET PageTitle = ?, PageDescription = ? WHERE PageType = ?");
        $stmt->bind_param("sss", $page_title, $page_desc, $page_type);
        if ($stmt->execute()) {
            $_SESSION['page_success'] = "Page content updated successfully.";
        } else {
            $_SESSION['page_error'] = "Error updating page content.";
        }
        header("Location: manage-pages.php?type=" . urlencode($page_type));
        exit();
    }
}

// Determine active page to edit
$active_type = $_GET['type'] ?? 'aboutus';

// Fetch pages for sidebar
$pages_res = mysqli_query($con, "SELECT PageType, PageTitle FROM tblpage ORDER BY id ASC");
$all_pages = [];
while ($r = mysqli_fetch_assoc($pages_res)) {
    $all_pages[] = $r;
}

// Fetch active page data
$active_data = null;
$stmt = $con->prepare("SELECT * FROM tblpage WHERE PageType = ?");
$stmt->bind_param("s", $active_type);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $active_data = $row;
}
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        
        <div class="mb-4">
            <h2 class="font-weight-bold m-0" style="color: var(--text-main);">Manage Page Content</h2>
            <p class="text-muted m-0 mt-1">Dynamically update the titles and text for various guest pages.</p>
        </div>

        <?php if (isset($_SESSION['page_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-check mr-2"></i> <?php echo $_SESSION['page_success']; unset($_SESSION['page_success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['page_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> <?php echo $_SESSION['page_error']; unset($_SESSION['page_error']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Sidebar / Tabs -->
            <div class="col-md-3 mb-4">
                <div class="list-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <?php foreach ($all_pages as $p): ?>
                        <a href="manage-pages.php?type=<?php echo urlencode($p['PageType']); ?>" 
                           class="list-group-item list-group-item-action <?php echo ($active_type === $p['PageType']) ? 'active' : ''; ?>"
                           style="<?php echo ($active_type === $p['PageType']) ? 'background: var(--primary); border-color: var(--primary);' : 'border-color: #f1f5f9;'; ?>">
                            <i class="fa-solid fa-file-alt mr-2"></i> <?php echo htmlspecialchars($p['PageTitle']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Editor -->
            <div class="col-md-9">
                <?php if ($active_data): ?>
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h4 class="font-weight-bold m-0" style="color: var(--primary-dark);">Edit: <?php echo htmlspecialchars($active_data['PageTitle']); ?></h4>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <form action="manage-pages.php" method="POST">
                            <input type="hidden" name="update_page" value="1">
                            <input type="hidden" name="page_type" value="<?php echo htmlspecialchars($active_data['PageType']); ?>">
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted small text-uppercase">Page Heading / Title</label>
                                <input type="text" name="page_title" class="form-control" value="<?php echo htmlspecialchars($active_data['PageTitle']); ?>" required style="border-radius: 10px; padding: 22px 15px; font-size: 16px;">
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted small text-uppercase">Page Description / Body</label>
                                <textarea name="page_desc" class="form-control" rows="8" required style="border-radius: 10px; padding: 15px; font-size: 15px; resize: vertical;"><?php echo htmlspecialchars($active_data['PageDescription']); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-success px-5 py-2" style="border-radius: 10px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); font-weight: 600;">
                                <i class="fa-solid fa-save mr-2"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                    <div class="alert alert-warning">Please select a valid page to edit.</div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
