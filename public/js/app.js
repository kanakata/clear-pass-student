// public/js/app.js — ClearPass client utilities

// ── Auto-dismiss alerts ────────────────────────────────────
document.querySelectorAll('.alert').forEach((el) => {
  if (el.style.display !== 'none') {
    setTimeout(() => (el.style.opacity = '0'), 4000);
    setTimeout(() => (el.style.display = 'none'), 4500);
  }
});

// ── Password visibility toggle helper ─────────────────────
document.querySelectorAll('[data-pw-toggle]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const input = document.getElementById(btn.dataset.pwToggle);
    if (!input) return;
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.textContent = input.type === 'password' ? '👁' : '🙈';
  });
});

// ── Phone number formatter ─────────────────────────────────
document.querySelectorAll('input[type=tel]').forEach((input) => {
  input.addEventListener('blur', function () {
    let val = this.value.replace(/\D/g, '');
    if (val.startsWith('0') && val.length === 10) {
      this.value = val; // keep as 07XXXXXXXX — backend will format
    }
  });
});

// ── Confirm dialogs ────────────────────────────────────────
document.querySelectorAll('[data-confirm]').forEach((el) => {
  el.addEventListener('click', function (e) {
    if (!confirm(this.dataset.confirm)) e.preventDefault();
  });
});

// ── Flash message auto-show ────────────────────────────────
const flashEl = document.getElementById('flash-message');
if (flashEl) {
  flashEl.style.display = 'flex';
  setTimeout(() => (flashEl.style.opacity = '0'), 3500);
  setTimeout(() => (flashEl.style.display = 'none'), 4000);
}
