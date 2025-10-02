// Image modal + add.php validation
document.addEventListener('DOMContentLoaded', () => {
  // ---- Modal wiring (IDs must match your HTML) ----
  const modal = document.getElementById('imgModal');   // <div id="imgModal" class="modal">
  const modalImg = document.getElementById('modalImg'); // <img id="modalImg">
  const modalClose = document.getElementById('modalClose'); // <button id="modalClose">

  function openModal(src, alt) {
    if (!modal || !modalImg) return;
    modalImg.src = src;
    modalImg.alt = alt || '';
    modal.classList.add('open');
  }

  function closeModal() {
    if (!modal || !modalImg) return;
    modal.classList.remove('open');
    modalImg.src = '';
    modalImg.alt = '';
  }

  // Close actions
  if (modalClose) modalClose.addEventListener('click', closeModal);
  if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

  // ---- Event delegation for any clickable with data-full ----
  document.addEventListener('click', (e) => {
    const el = e.target.closest('[data-full]');
    if (!el) return;
    e.preventDefault(); // in case it sits inside a link
    openModal(el.dataset.full, el.getAttribute('alt') || el.dataset.title || 'Image');
  });

  // ---- Add form validation (client-side) for add.php ----
  const form = document.getElementById('skillForm');
  if (form) {
    form.addEventListener('submit', (e) => {
      const f = document.getElementById('image');
      if (!f || !f.files || !f.files[0]) return;
      const file = f.files[0];
      const allowed = ['image/jpeg','image/png','image/gif','image/webp','image/svg+xml'];
      if (!allowed.includes(file.type)) {
        e.preventDefault();
        alert('Image must be JPG, PNG, GIF, WEBP or SVG.');
        return;
      }
      if (file.size > 2 * 1024 * 1024) {
        e.preventDefault();
        alert('Image must be under 2MB.');
      }
    });
  }
});
