<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    $_SESSION['auth_flash'] = "Please create an account to purchase this plan.";
    header("Location: ../register.php");
    exit();
}
$title = "Checkout - Secure Payment";
$css = "register-dashboard.css"; 

// Get plan details from URL or default
$planName = isset($_GET['plan']) ? htmlspecialchars($_GET['plan']) : "Custom Health Plan";
$planPrice = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : "0";

ob_start();
?>

<div class="py-5" style="background-color: var(--bg-light); min-height: calc(100vh - 70px);">
    <div class="container">
        
        <div class="row justify-content-center">
            
            <div class="col-lg-8">
                <!-- Order Summary -->
                <div class="stat-card mb-4" style="border-top: 5px solid var(--primary);">
                    <h3 class="font-weight-bold mb-4" style="color: var(--text-main);">Order Summary</h3>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                        <div>
                            <h5 class="mb-1 font-weight-bold" style="color: var(--primary-dark);"><?php echo $planName; ?></h5>
                            <small class="text-muted">Lifetime Access to this module</small>
                        </div>
                        <div class="font-weight-bold" style="font-size: 20px;">
                            ₹ <?php echo $planPrice; ?>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>₹ <?php echo $planPrice; ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Taxes & Platform Fees</span>
                        <span>₹ 0</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top: 2px dashed rgba(0,0,0,0.1);">
                        <strong style="font-size: 18px;">Total Payable</strong>
                        <strong style="font-size: 24px; color: var(--primary-dark);">₹ <?php echo $planPrice; ?></strong>
                    </div>
                </div>
                
                <!-- Payment Form -->
                <div class="stat-card">
                    <h3 class="font-weight-bold mb-4" style="color: var(--text-main);">Payment Details</h3>
                    
                    <!-- Payment Methods Tabs -->
                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active font-weight-bold" id="pills-card-tab" data-toggle="pill" href="#pills-card" role="tab" style="border-radius: 8px;">Credit / Debit Card</a>
                      </li>
                      <li class="nav-item ml-2" role="presentation">
                        <a class="nav-link font-weight-bold" id="pills-upi-tab" data-toggle="pill" href="#pills-upi" role="tab" style="border-radius: 8px;">UPI</a>
                      </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                      <!-- Card Form -->
                      <div class="tab-pane fade show active" id="pills-card" role="tabpanel">
                          <form id="paymentForm" onsubmit="processPayment(event, this)" autocomplete="off">
                              <div class="form-group">
                                  <label class="text-muted font-weight-bold">Cardholder Name</label>
                                  <input type="text" class="form-control" placeholder="John Doe" autocomplete="cc-name" required style="border-radius: 8px; padding: 22px 15px;">
                              </div>
                              <div class="form-group">
                                  <label class="text-muted font-weight-bold">Card Number</label>
                                  <div class="input-group">
                                      <input type="text" id="cardNumber" class="form-control" placeholder="0000000000000000" pattern="[0-9]{16}" minlength="16" maxlength="16" title="16 digit card number" autocomplete="cc-number" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="border-radius: 8px 0 0 8px; padding: 22px 15px;">
                                      <div class="input-group-append">
                                          <span class="input-group-text bg-light"><i class="fa-brands fa-cc-visa" style="font-size:24px; color:#1a1f71;"></i></span>
                                          <span class="input-group-text bg-light" style="border-radius: 0 8px 8px 0;"><i class="fa-brands fa-cc-mastercard" style="font-size:24px; color:#eb001b;"></i></span>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label class="text-muted font-weight-bold">Expiry Date</label>
                                          <input type="text" id="cardExpiry" class="form-control" placeholder="MM/YY" pattern="(0[1-9]|1[0-2])/([0-9]{2})" maxlength="5" title="Format: MM/YY" autocomplete="cc-exp" required style="border-radius: 8px; padding: 22px 15px;">
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label class="text-muted font-weight-bold">CVV</label>
                                          <input type="text" class="form-control" placeholder="•••" pattern="[0-9]{3}" minlength="3" maxlength="3" title="3 digit CVV" autocomplete="cc-csc" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="border-radius: 8px; padding: 22px 15px; -webkit-text-security: disc;">
                                      </div>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-success btn-lg btn-block mt-4" style="border-radius: 8px;">
                                  <i class="fa-solid fa-lock mr-2"></i> Pay ₹ <?php echo $planPrice; ?> Securely
                              </button>
                          </form>
                      </div>
                      
                      <!-- UPI Form -->
                      <div class="tab-pane fade" id="pills-upi" role="tabpanel">
                          <form id="upiForm" onsubmit="processPayment(event, this)">
                              <div class="form-group">
                                  <label class="text-muted font-weight-bold">Enter UPI ID</label>
                                  <input type="text" class="form-control" placeholder="username@upi" required pattern=".+@.+" title="Enter valid UPI ID" style="border-radius: 8px; padding: 22px 15px;">
                              </div>
                              <div class="text-center my-4">
                                  <span class="text-muted text-uppercase">OR SCAN QR CODE</span><br>
                                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=mock@upi&pn=Health+Wellness&am=<?php echo $planPrice; ?>" alt="QR Code" class="mt-3 img-thumbnail" style="border-radius: 12px; border: 2px solid var(--primary);">
                              </div>
                              
                              <button type="submit" class="btn btn-success btn-lg btn-block mt-4" style="border-radius: 8px;">
                                  <i class="fa-solid fa-lock mr-2"></i> Pay ₹ <?php echo $planPrice; ?> Securely
                              </button>
                          </form>
                      </div>
                    </div>
                </div>
                
                <!-- Safe checkout badges -->
                <div class="text-center mt-4 mb-5 text-muted">
                    <p class="mb-2"><i class="fa-solid fa-shield-halved mr-2 text-success"></i> 256-bit SSL Encryption. Guaranteed safe checkout.</p>
                </div>
                
            </div>
            
        </div>
    </div>
</div>     

<!-- Modal Processing -->
<div class="modal fade" id="processingModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center p-5">
      <div id="loadingState">
          <div class="spinner-border text-success mb-3" role="status" style="width: 4rem; height: 4rem;"></div>
          <h4 class="font-weight-bold">Processing Payment...</h4>
          <p class="text-muted">Please do not close this window or press back.</p>
      </div>
      <div id="successState" style="display:none;">
          <i class="fa-solid fa-circle-check text-success mb-4" style="font-size: 5rem;"></i>
          <h3 class="font-weight-bold text-success">Payment Successful!</h3>
          <p class="text-muted mb-4">You have successfully purchased the <?php echo $planName; ?>.</p>
          <a href="manage-plans.php" class="btn btn-success btn-block" style="border-radius:8px;">Go to My Plans</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var cardExpiry = document.getElementById('cardExpiry');
    if (cardExpiry) {
        cardExpiry.addEventListener('input', function() {
            var val = this.value;
            // Strip everything that is not a digit
            val = val.replace(/[^0-9]/g, '');
            // Max 4 digits (MMYY)
            if (val.length > 4) val = val.substring(0, 4);
            // After 2 digits, insert a single slash
            if (val.length > 2) {
                val = val.substring(0, 2) + '/' + val.substring(2);
            }
            this.value = val;
        });
    }
});

function processPayment(event, form) {
    // Form verification natively triggers because of the submit event bind.
    if (!form.checkValidity()) {
        return;
    }
    
    event.preventDefault(); // Pause form submittal
    
    $('#processingModal').modal('show');
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('successState').style.display = 'none';
    
    const formData = new FormData();
    formData.append('plan_name', '<?php echo addslashes($planName); ?>');
    formData.append('price', '<?php echo addslashes($planPrice); ?>');

    fetch('process_purchase.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Give a satisfying simulated delay of 1.5 seconds minimum
        setTimeout(function() {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('successState').style.display = 'block';
        }, 1500);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during submission.');
        $('#processingModal').modal('hide');
    });
}
</script>

<?php
$content = ob_get_clean();
include("../includes/user_layout.php");
?>
