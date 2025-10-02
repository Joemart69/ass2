// Client-side validation for add.php
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('skillForm');
  if (form) {
    form.addEventListener('submit', (e) => {
      const file = document.getElementById('image').files[0];
      if (!file) return;

      const okTypes = ['image/jpeg','image/png','image/gif','image/webp','image/svg+xml'];
      if (!okTypes.includes(file.type)) {
        e.preventDefault();
        alert('Please upload an image (jpg, png, gif, webp, svg).');
        return;
      }
      if (file.size > 2 * 1024 * 1024) {
        e.preventDefault();
        alert('Image must be under 2MB.');
      }
    });
  }

  // modal for gallery/details
  const modal = document.getElementById('modal');
  const modalImg = document.getElementById('modalImg');
  const closeBtn = document.getElementById('modalClose');

  function openModal(src, alt) {
    if (!modal || !modalImg) return;
    modalImg.src = src;
    modalImg.alt = alt || '';
    modal.classList.add('open');
  }
  function closeModal() {
    if (modal) modal.classList.remove('open');
    if (modalImg) { modalImg.src = ''; modalImg.alt = ''; }
  }
  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (modal) modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });

  document.querySelectorAll('[data-full]').forEach(card => {
    card.addEventListener('click', () => {
      openModal(card.dataset.full, card.dataset.title || 'Skill image');
    });
  });
});
