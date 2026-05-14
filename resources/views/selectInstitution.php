<?php loadHeader("select-institution") ?>

<div class="auth-layout">
    <div class="auth-left">
        <div class="auth-left-content">
            <a href="/" class="auth-logo">
                <div class="mark">C</div>ClearPass
            </a>
            <h2>Track your<br><span>clearance</span> status</h2>
            <p class="auth-tagline mt-8">Log in to apply for clearance, track department approvals, and download your certificate.</p>
            <div class="auth-feature mt-16">
                <div class="auth-feature-icon">📋</div>
                <div>
                    <div class="auth-feature-title">Apply for Clearance</div>
                    <div class="auth-feature-text">Submit your clearance request and track it in real time</div>
                </div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-icon">🔔</div>
                <div>
                    <div class="auth-feature-title">Live Status Updates</div>
                    <div class="auth-feature-text">See exactly which departments have approved or need action</div>
                </div>
            </div>
            <div class="auth-feature">
                <div class="auth-feature-icon">📄</div>
                <div>
                    <div class="auth-feature-title">Digital Certificate</div>
                    <div class="auth-feature-text">Download your tamper-proof clearance certificate instantly</div>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form-wrap animate-fadeup">
            <h2 class="auth-form-title">Student Login</h2>
            <!-- <p class="auth-form-sub">Sign in to your clearance portal</p> -->

            <div id="alert-box" class="alert" style="display:none"></div>

            <form id="loginForm" method="post" action="">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

                <div class="form-group">
                    <label class="form-label">Your School *</label>
                    <select name="school_name" class="form-control" required>
                        <option value="">— Select your institution —</option>
                        <?php foreach ($schools as $s): ?>
                            <option value="<?= e($s['school name']) ?>"><?= e($s['school name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">School code *</label>
                    <div class="input-icon-wrap">
                        <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="14" rx="2" />
                            <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                            <line x1="12" y1="12" x2="12" y2="16" />
                            <line x1="10" y1="14" x2="14" y2="14" />
                        </svg>
                        <input type="text" name="school_code" class="form-control" placeholder="e.g. 26500002">
                    </div>
                </div>

                <div class="form-group">
                    <div style="text-align:right;margin-top:6px">
                        <a href="/landing" style="font-size:15px;color:var(--amber)">Go back</a>
                    </div>
                </div>

                <button type="submit" name="proceed" class="btn btn-primary btn-full btn-lg" id="submitBtn">
                    Proceed
                </button>
            </form>

            <!-- <div class="auth-switch mt-16">
                New student? <a href="/student/register">Create an account</a>
            </div>
            <div class="auth-switch mt-8">
                Are you a school admin? <a href="/school/login">School login →</a>
            </div> -->

        </div>
    </div>
</div>

<?php loadFooter() ?>
