/* ============================================================
   RAKT SETU  |  Main JavaScript
   File: assets/js/app.js
   ============================================================ */

// ---------- THEME TOGGLE (Dark / Light) ----------
(function initTheme() {
  const saved = localStorage.getItem('rakt-theme') || 'dark';
  document.documentElement.setAttribute('data-theme', saved);
})();

function toggleTheme() {
  const current = document.documentElement.getAttribute('data-theme');
  const next = current === 'dark' ? 'light' : 'dark';
  document.documentElement.setAttribute('data-theme', next);
  localStorage.setItem('rakt-theme', next);

  // icon update
  const btn = document.getElementById('themeBtn');
  if (btn) btn.textContent = next === 'dark' ? '🌙' : '☀️';

  playBeat();
}

// ---------- CLICK SOUND (Web Audio API - Reverse Beat) ----------
let audioCtx = null;

function playBeat() {
  try {
    if (!audioCtx) {
      audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    const now = audioCtx.currentTime;

    // Deep thump (bass)
    const osc1 = audioCtx.createOscillator();
    const gain1 = audioCtx.createGain();
    osc1.type = 'sine';
    osc1.frequency.setValueAtTime(180, now);
    osc1.frequency.exponentialRampToValueAtTime(45, now + 0.18);
    gain1.gain.setValueAtTime(0.18, now);
    gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.22);
    osc1.connect(gain1).connect(audioCtx.destination);
    osc1.start(now);
    osc1.stop(now + 0.25);

    // Reverse tick (high)
    const osc2 = audioCtx.createOscillator();
    const gain2 = audioCtx.createGain();
    osc2.type = 'triangle';
    osc2.frequency.setValueAtTime(60, now);
    osc2.frequency.exponentialRampToValueAtTime(900, now + 0.08);
    gain2.gain.setValueAtTime(0.001, now);
    gain2.gain.exponentialRampToValueAtTime(0.09, now + 0.06);
    gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.12);
    osc2.connect(gain2).connect(audioCtx.destination);
    osc2.start(now);
    osc2.stop(now + 0.14);
  } catch (e) {
    // silent fail
  }
}

// ---------- RIPPLE EFFECT ON BUTTONS ----------
function attachRipple(el) {
  el.addEventListener('click', function (e) {
    const rect = el.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const ripple = document.createElement('span');
    ripple.className = 'ripple';
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
    ripple.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
    el.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  });
}

// ---------- AUTO-SETUP ON PAGE LOAD ----------
document.addEventListener('DOMContentLoaded', function () {
  // Theme button icon set
  const themeBtn = document.getElementById('themeBtn');
  const current = document.documentElement.getAttribute('data-theme');
  if (themeBtn) themeBtn.textContent = current === 'dark' ? '🌙' : '☀️';

  // Attach ripple to all clickable elements
  document.querySelectorAll('.btn, .quick-tile, .nav-item, .card[data-clickable]')
    .forEach(el => {
      attachRipple(el);
      el.addEventListener('click', playBeat);
    });

  // Register service worker (PWA)
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(() => {});
  }
});

// ---------- HAPTIC (vibrate on supported devices) ----------
function haptic(ms = 15) {
  if (navigator.vibrate) navigator.vibrate(ms);
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.btn, .nav-item, .quick-tile').forEach(el => {
    el.addEventListener('touchstart', () => haptic(10), { passive: true });
  });
});
