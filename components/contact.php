<?php
/**
 * Dholera Responsive Contact Us Section Component
 * Backend-connected: submits to process-enquiry.php
 * Developed by Expert UI/UX Designer & Developer
 */

// Pull flash messages
$enq_success = $_SESSION['enq_success'] ?? '';
$enq_error   = $_SESSION['enq_error']   ?? '';
$enq_old     = $_SESSION['enq_old']     ?? [];
unset($_SESSION['enq_success'], $_SESSION['enq_error'], $_SESSION['enq_old']);

// CSRF token
$csrf = generateCSRFToken();
?>
<!-- Load Contact Component Stylesheet -->
<link rel="stylesheet" href="assets/css/contact.css">

<section class="dh-contact-section" id="contact">
  <div class="dh-contact-container">
    
    <!-- Header Block -->
    <div class="dh-contact-header">
      <span class="dh-contact-subtitle">Get In Touch</span>
      <h2 class="dh-contact-title">Schedule a Consultation</h2>
    </div>

    <!-- ── Flash Messages ── -->
    <?php if (!empty($enq_success)): ?>
      <div class="dh-enq-alert dh-enq-success" id="dhEnqSuccess" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        <span><?php echo $enq_success; ?></span>
        <button class="dh-enq-close" onclick="document.getElementById('dhEnqSuccess').remove()" aria-label="Close">&times;</button>
      </div>
    <?php endif; ?>

    <?php if (!empty($enq_error)): ?>
      <div class="dh-enq-alert dh-enq-error" id="dhEnqError" role="alert">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?php echo htmlspecialchars($enq_error); ?></span>
        <button class="dh-enq-close" onclick="document.getElementById('dhEnqError').remove()" aria-label="Close">&times;</button>
      </div>
    <?php endif; ?>

    <!-- Contact Grid -->
    <div class="dh-contact-grid">
      
      <!-- Left Column: Visual Image & Info Details -->
      <div class="dh-contact-sidebar">
        <!-- Office Image Showcase -->
        <div class="dh-contact-image-wrapper">
          <img src="assets/images/thumb5.png" alt="Dholera Smart City Office Complex" class="dh-contact-image" loading="lazy">
        </div>
        
        <!-- Info Cards List -->
        <div class="dh-contact-info-list">
          
          <!-- Detail Item 1: Phone -->
          <div class="dh-contact-info-item">
            <div class="dh-contact-icon-box">
              <i class="fa-solid fa-phone"></i>
            </div>
            <div class="dh-contact-info-details">
              <h4>Call Center</h4>
              <a href="tel:+919220551771">+91 92205 51771</a>
            </div>
          </div>
          
          <!-- Detail Item 2: Email -->
          <div class="dh-contact-info-item">
            <div class="dh-contact-icon-box">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="dh-contact-info-details">
              <h4>Email Address</h4>
              <a href="mailto:info@dholerasmartcity.com">info@dholerasmartcity.com</a>
            </div>
          </div>
          
          <!-- Detail Item 3: Address -->
          <div class="dh-contact-info-item">
            <div class="dh-contact-icon-box">
              <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div class="dh-contact-info-details">
              <h4>Headquarters</h4>
              <p>Dholera SIR, District Ahmedabad, Gujarat, India</p>
            </div>
          </div>

        </div>
      </div>
      
      <!-- Right Column: Premium Inquiry Form -->
      <div class="dh-contact-form-wrapper">
        <form class="dh-contact-form" action="process-enquiry.php" method="POST" novalidate>

          <!-- CSRF Token (hidden) -->
          <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">

          <div class="dh-contact-form-row">
            <!-- Full Name -->
            <div class="dh-contact-form-group">
              <label class="dh-contact-label" for="dh-contact-name">Full Name <span class="dh-req">*</span></label>
              <input class="dh-contact-input" type="text" id="dh-contact-name" name="name"
                     placeholder="John Doe"
                     value="<?php echo htmlspecialchars($enq_old['name'] ?? ''); ?>"
                     required maxlength="150">
            </div>
            
            <!-- Email -->
            <div class="dh-contact-form-group">
              <label class="dh-contact-label" for="dh-contact-email">Email Address <span class="dh-req">*</span></label>
              <input class="dh-contact-input" type="email" id="dh-contact-email" name="email"
                     placeholder="john@example.com"
                     value="<?php echo htmlspecialchars($enq_old['email'] ?? ''); ?>"
                     required maxlength="255">
            </div>
          </div>

          <div class="dh-contact-form-row">
            <!-- Phone -->
            <div class="dh-contact-form-group">
              <label class="dh-contact-label" for="dh-contact-phone">Phone Number <span class="dh-req">*</span></label>
              <input class="dh-contact-input" type="tel" id="dh-contact-phone" name="phone"
                     placeholder="+91 98765 43210"
                     value="<?php echo htmlspecialchars($enq_old['phone'] ?? ''); ?>"
                     required maxlength="20">
            </div>
            
            <!-- Interest Selector -->
            <div class="dh-contact-form-group">
              <label class="dh-contact-label" for="dh-contact-interest">Interested In</label>
              <select class="dh-contact-select" id="dh-contact-interest" name="interest">
                <?php
                $interests = [
                    'villas'      => 'Residential Villa Plots',
                    'industrial'  => 'Industrial Plug-and-Play Plots',
                    'commercial'  => 'Commercial Economic Land',
                    'consultancy' => 'Smart City Consultancy',
                    'general'     => 'General Enquiry',
                ];
                $sel = $enq_old['interest'] ?? 'general';
                foreach ($interests as $val => $label):
                ?>
                  <option value="<?php echo $val; ?>" <?php echo ($sel === $val) ? 'selected' : ''; ?>>
                    <?php echo $label; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Message -->
          <div class="dh-contact-form-group full-width">
            <label class="dh-contact-label" for="dh-contact-msg">Detailed Message <span class="dh-req">*</span></label>
            <textarea class="dh-contact-textarea" id="dh-contact-msg" name="message"
                      placeholder="Hi, I would like to schedule a virtual tour or request availability updates for Ring Road plots..."
                      required minlength="10"><?php echo htmlspecialchars($enq_old['message'] ?? ''); ?></textarea>
          </div>

          <!-- Submit -->
          <button class="dh-contact-submit-btn" type="submit" id="dhEnqSubmitBtn">
            <span class="btn-text">Schedule a Consultation</span>
            <span class="btn-loader" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i> Sending…</span>
            <i class="fa-solid fa-arrow-right btn-icon"></i>
          </button>

        </form>
      </div>

    </div>
  </div>
</section>

<script>
(function () {
  const form = document.querySelector('.dh-contact-form');
  const btn  = document.getElementById('dhEnqSubmitBtn');
  if (!form || !btn) return;

  form.addEventListener('submit', function () {
    btn.querySelector('.btn-text').style.display = 'none';
    btn.querySelector('.btn-icon').style.display = 'none';
    btn.querySelector('.btn-loader').style.display = 'inline';
    btn.disabled = true;
  });
})();
</script>
