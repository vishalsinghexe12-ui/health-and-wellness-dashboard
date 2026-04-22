<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
require_once("../db_config.php");

$plan_id = isset($_GET['plan_id']) ? (int)$_GET['plan_id'] : 0;
if ($plan_id === 0) {
    echo "Invalid Plan ID";
    exit();
}

// Fetch Plan
$stmt = $con->prepare("SELECT * FROM plans WHERE id = ?");
$stmt->bind_param("i", $plan_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo "Plan not found.";
    exit();
}
$plan = $res->fetch_assoc();

// Handle Save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule_json = $_POST['schedule_data'] ?? null;
    
    // Simple validation
    if (!empty($schedule_json)) {
        json_decode($schedule_json);
        if (json_last_error() === JSON_ERROR_NONE) {
            $update = $con->prepare("UPDATE plans SET schedule_data = ? WHERE id = ?");
            $update->bind_param("si", $schedule_json, $plan_id);
            if ($update->execute()) {
                $success_msg = "Schedule saved successfully.";
                // Refresh data
                $plan['schedule_data'] = $schedule_json;
            } else {
                $error_msg = "Database error: " . $con->error;
            }
        } else {
            $error_msg = "Invalid JSON data submitted.";
        }
    } else {
        // Clear schedule
        $update = $con->prepare("UPDATE plans SET schedule_data = NULL WHERE id = ?");
        $update->bind_param("i", $plan_id);
        $update->execute();
        $plan['schedule_data'] = null;
        $success_msg = "Schedule cleared successfully. It will revert to the dynamic generator.";
    }
}

$title = "Manage Schedule - " . htmlspecialchars($plan['title']);
$css = "admin.css"; 

// Existing data
$existing_data = $plan['schedule_data'] ? $plan['schedule_data'] : '[]';

ob_start();
?>

<div class="py-5" style="background-color: #f8fafc; min-height: calc(100vh - 70px);">
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="<?php echo ($plan['type'] === 'Meal' ? 'admin-meal-plans.php' : 'admin-exercise-plans.php'); ?>" class="btn btn-sm btn-outline-secondary mb-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Plans
                </a>
                <h3 class="font-weight-bold m-0" style="color: var(--primary-dark);">Schedule Builder</h3>
                <p class="text-muted m-0">Editing Schedule for: <strong class="text-success"><?php echo htmlspecialchars($plan['title']); ?></strong></p>
            </div>
            <div>
                <button class="btn btn-primary" style="border-radius: 8px;" onclick="addWeek()">
                    <i class="fa-solid fa-plus mr-1"></i> Add Week
                </button>
            </div>
        </div>

        <?php if(isset($success_msg)): ?>
            <div class="alert alert-success mt-3" style="border-radius: 8px;"><i class="fa-solid fa-check-circle mr-2"></i> <?php echo $success_msg; ?></div>
        <?php endif; ?>
        <?php if(isset($error_msg)): ?>
            <div class="alert alert-danger mt-3" style="border-radius: 8px;"><i class="fa-solid fa-triangle-exclamation mr-2"></i> <?php echo $error_msg; ?></div>
        <?php endif; ?>

        <!-- Builder Area -->
        <div id="scheduleApp">
            <div class="row">
                <div class="col-lg-8" id="weeksContainer">
                    <!-- Weeks rendered here by JS -->
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; position: sticky; top: 20px;">
                        <div class="card-body p-4 bg-white" style="border-radius: 12px;">
                            <h5 class="font-weight-bold mb-3">Save Schedule</h5>
                            <p class="text-muted" style="font-size: 14px;">Once you have built out the weeks and days, save your changes. If left empty, the system will dynamically generate a random schedule for the user.</p>
                            <form method="POST" id="saveForm">
                                <input type="hidden" name="schedule_data" id="scheduleDataInput">
                                <button type="button" onclick="saveSchedule()" class="btn btn-success btn-block btn-lg font-weight-bold" style="border-radius: 8px;">
                                    <i class="fa-solid fa-save mr-2"></i> Publish Schedule
                                </button>
                                <button type="button" onclick="clearSchedule()" class="btn btn-outline-danger btn-block mt-2 font-weight-bold" style="border-radius: 8px;">
                                    <i class="fa-solid fa-trash mr-2"></i> Clear Schedule
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Day details -->
<div class="modal fade" id="dayModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: none;">
      <div class="modal-header border-0">
        <h5 class="modal-title font-weight-bold" id="dayModalTitle">Edit Day</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="modalWeekIndex">
        <input type="hidden" id="modalDayIndex">
        
        <div class="form-group">
            <label class="font-weight-bold">Day Number (e.g. 1, 2... or Label)</label>
            <input type="text" id="modalDayLabel" class="form-control" style="border-radius: 8px;">
        </div>
        
        <div class="form-group">
            <label class="font-weight-bold">Activity Details</label>
            <input type="text" id="modalActivity" class="form-control" placeholder="e.g. Full Body Workout / Rest Day" style="border-radius: 8px;">
        </div>
        
        <div class="form-group">
            <label class="font-weight-bold">Duration</label>
            <input type="text" id="modalDuration" class="form-control" placeholder="e.g. 45 Min / -" style="border-radius: 8px;">
        </div>
        
        <div class="form-group custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="modalIsRecovery">
          <label class="custom-control-label" for="modalIsRecovery">Mark as Recovery / Rest Day</label>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" onclick="deleteDay()" style="border-radius: 8px;">Delete Day</button>
        <button type="button" class="btn btn-success" onclick="saveDayDetails()" style="border-radius: 8px;">Save Day</button>
      </div>
    </div>
  </div>
</div>

<script>
let schedule = <?php echo $existing_data; ?>;
if (!Array.isArray(schedule)) { schedule = []; }

function render() {
    const container = document.getElementById('weeksContainer');
    container.innerHTML = '';
    
    if (schedule.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 border" style="border-radius: 12px; border-style: dashed !important; border-width: 2px !important; background: transparent;">
                <h5 class="text-muted mb-3">No custom schedule created yet.</h5>
                <button class="btn btn-outline-primary" style="border-radius: 8px;" onclick="addWeek()">Start Building</button>
            </div>
        `;
        return;
    }

    schedule.forEach((week, wIndex) => {
        let daysHtml = '';
        if (week.days && week.days.length > 0) {
            week.days.forEach((day, dIndex) => {
                let badgeClass = day.is_recovery ? 'badge-light text-muted' : 'badge-success';
                let textClass = day.is_recovery ? 'text-muted' : 'text-dark';
                let recoveryIcon = day.is_recovery ? '<i class="fa-solid fa-bed mr-2"></i>' : '';
                daysHtml += `
                    <div class="list-group-item px-3 py-3 border mb-2 d-flex justify-content-between align-items-center" style="border-radius: 8px; cursor:pointer;" onclick="openDayModal(${wIndex}, ${dIndex})">
                        <div>
                            <span class="font-weight-bold mr-3 ${textClass}">Day ${day.day}</span>
                            <span class="${textClass}">${recoveryIcon} ${day.activity}</span>
                        </div>
                        <span class="badge ${badgeClass} p-2">${day.duration}</span>
                    </div>
                `;
            });
        } else {
            daysHtml = `<p class="text-muted small">No days added. Click "Add Day" below.</p>`;
        }

        const weekCard = document.createElement('div');
        weekCard.className = 'card border-0 shadow-sm mb-4';
        weekCard.style.borderRadius = '12px';
        weekCard.style.borderLeft = '5px solid var(--primary)';
        weekCard.innerHTML = `
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <input type="text" class="form-control w-50 font-weight-bold" style="border: none; background: #f8fafc; border-radius: 8px; font-size: 18px;" value="${week.title}" onblur="updateWeekTitle(${wIndex}, this.value)">
                <div>
                    <button class="btn btn-sm btn-outline-primary mr-2" style="border-radius: 8px;" onclick="addDay(${wIndex})"><i class="fa-solid fa-plus mr-1"></i> Day</button>
                    <button class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" onclick="deleteWeek(${wIndex})"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div class="list-group">
                    ${daysHtml}
                </div>
            </div>
        `;
        container.appendChild(weekCard);
    });
}

function addWeek() {
    schedule.push({
        title: "Week " + (schedule.length + 1) + ": New Phase",
        days: []
    });
    render();
}

function deleteWeek(wIndex) {
    if(confirm('Delete this entire week?')) {
        schedule.splice(wIndex, 1);
        render();
    }
}

function updateWeekTitle(wIndex, val) {
    schedule[wIndex].title = val;
}

function addDay(wIndex) {
    schedule[wIndex].days.push({
        day: schedule[wIndex].days.length + 1,
        activity: "New Activity",
        duration: "30 Min",
        is_recovery: false
    });
    openDayModal(wIndex, schedule[wIndex].days.length - 1);
}

function openDayModal(wIndex, dIndex) {
    const day = schedule[wIndex].days[dIndex];
    document.getElementById('modalWeekIndex').value = wIndex;
    document.getElementById('modalDayIndex').value = dIndex;
    document.getElementById('modalDayLabel').value = day.day;
    document.getElementById('modalActivity').value = day.activity;
    document.getElementById('modalDuration').value = day.duration;
    document.getElementById('modalIsRecovery').checked = day.is_recovery;
    
    $('#dayModal').modal('show');
}

function saveDayDetails() {
    const wIndex = document.getElementById('modalWeekIndex').value;
    const dIndex = document.getElementById('modalDayIndex').value;
    
    schedule[wIndex].days[dIndex] = {
        day: document.getElementById('modalDayLabel').value,
        activity: document.getElementById('modalActivity').value,
        duration: document.getElementById('modalDuration').value,
        is_recovery: document.getElementById('modalIsRecovery').checked
    };
    
    $('#dayModal').modal('hide');
    render();
}

function deleteDay() {
    const wIndex = document.getElementById('modalWeekIndex').value;
    const dIndex = document.getElementById('modalDayIndex').value;
    if(confirm('Delete this day?')) {
        schedule[wIndex].days.splice(dIndex, 1);
        $('#dayModal').modal('hide');
        render();
    }
}

function saveSchedule() {
    document.getElementById('scheduleDataInput').value = JSON.stringify(schedule);
    document.getElementById('saveForm').submit();
}

function clearSchedule() {
    if(confirm('Are you sure you want to completely clear the custom schedule? It will revert to dynamically generated schedules.')) {
        document.getElementById('scheduleDataInput').value = "";
        document.getElementById('saveForm').submit();
    }
}

// Initial render
render();
</script>

<?php
$content = ob_get_clean();
include("../includes/admin_layout.php");
?>
