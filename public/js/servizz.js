/* ============================================================
   SERVIZZ Admin — Main JavaScript
   Lokasi: public/js/servizz.js
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Sidebar toggle (mobile) ──────────────────────────── */
    const sidebar  = document.getElementById('svzSidebar');
    const overlay  = document.getElementById('svzOverlay');
    const hamburger = document.getElementById('svzHamburger');

    function openSidebar() {
        sidebar  && sidebar.classList.add('is-open');
        overlay  && overlay.classList.add('is-open');
    }

    function closeSidebar() {
        sidebar  && sidebar.classList.remove('is-open');
        overlay  && overlay.classList.remove('is-open');
    }

    hamburger && hamburger.addEventListener('click', openSidebar);
    overlay   && overlay.addEventListener('click', closeSidebar);

    /* ── Auto-hide flash alert setelah 5 detik ───────────── */
    document.querySelectorAll('.svz-alert[data-autohide]').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .5s';
            el.style.opacity    = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 5000);
    });

    /* ── Loading state pada tombol submit form ───────────── */
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (btn && !btn.dataset.noLoading) {
                btn.disabled = true;
                var icon = btn.querySelector('i');
                if (icon) {
                    icon.className = 'bi bi-arrow-repeat spin-icon';
                }
            }
        });
    });

    /* ── Konfirmasi sebelum aksi berbahaya ───────────────── */
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    /* ── Buka modal jika ada flag dari server ────────────── */
    var autoModal = document.getElementById('autoOpenModal');
    if (autoModal) {
        var modal = new bootstrap.Modal(autoModal);
        modal.show();
    }

    /* ── Tooltip Bootstrap ───────────────────────────────── */
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el);
    });

});