// JavaScript umum aplikasi Pengaduan Sarpras.
// Mode Hitam Putih v3 - logo tetap berwarna dan kompatibel dengan browser HP.
(function () {
    function initBlackWhite() {
        var body = document.body;
        var html = document.documentElement;
        var button = document.getElementById('blackWhiteToggle');
        if (!body || !button) return;

        function applyMode(active) {
            body.classList.toggle('blackwhite', active);
            html.classList.toggle('blackwhite', active);
            body.setAttribute('data-color-mode', active ? 'blackwhite' : 'normal');
            html.setAttribute('data-color-mode', active ? 'blackwhite' : 'normal');
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
            button.title = active ? 'Matikan mode hitam putih' : 'Aktifkan mode hitam putih';
            button.innerHTML = active
                ? '⚪⚫ <span>Warna Normal</span>'
                : '⚫⚪ <span>Hitam Putih</span>';
        }

        var saved = localStorage.getItem('sarpras_black_white');
        applyMode(saved === '1');

        button.addEventListener('click', function () {
            var active = !body.classList.contains('blackwhite');
            applyMode(active);
            localStorage.setItem('sarpras_black_white', active ? '1' : '0');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBlackWhite);
    } else {
        initBlackWhite();
    }
})();
