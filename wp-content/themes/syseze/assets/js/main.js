/* =========================================================
   SysEze — Main JS
   Nav scroll state, mobile menu, scroll reveal, counters.
   ========================================================= */

(function () {
  'use strict';

  /* ---------- Nav scroll state ---------- */
  const nav = document.querySelector('.nav');
  if (nav) {
    const onScroll = () => {
      if (window.scrollY > 12) nav.classList.add('scrolled');
      else nav.classList.remove('scrolled');
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ---------- Mobile menu ---------- */
  const hamburger = document.querySelector('.hamburger');
  const mobileMenu = document.querySelector('.mobile-menu');
  if (hamburger && mobileMenu) {
    const close = () => {
      mobileMenu.classList.remove('open');
      document.body.style.overflow = '';
    };
    hamburger.addEventListener('click', () => {
      const open = mobileMenu.classList.toggle('open');
      document.body.style.overflow = open ? 'hidden' : '';
    });
    mobileMenu.addEventListener('click', (e) => {
      if (e.target === mobileMenu) close();
    });
    mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
  }

  /* ---------- Scroll reveal ---------- */
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
      revealEls.forEach(el => io.observe(el));
    } else {
      revealEls.forEach(el => el.classList.add('is-visible'));
    }
  }

  /* ---------- Animated counters ---------- */
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const animate = (el) => {
      const target = parseFloat(el.getAttribute('data-count'));
      const suffix = el.getAttribute('data-suffix') || '';
      const dur = 1600;
      const start = performance.now();
      const step = (now) => {
        const t = Math.min(1, (now - start) / dur);
        const eased = 1 - Math.pow(1 - t, 3);
        const val = Math.round(target * eased);
        el.textContent = val + suffix;
        if (t < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animate(entry.target);
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.4 });
      counters.forEach(el => io.observe(el));
    } else {
      counters.forEach(animate);
    }
  }

  /* ---------- FAQ accordion ---------- */
  document.querySelectorAll('.faq-item').forEach(item => {
    const btn = item.querySelector('.faq-q');
    if (!btn) return;
    btn.addEventListener('click', () => {
      item.classList.toggle('open');
      btn.setAttribute('aria-expanded', item.classList.contains('open'));
    });
  });

  /* ---------- Portfolio filter ---------- */
  const filterButtons = document.querySelectorAll('[data-filter]');
  const filterItems = document.querySelectorAll('[data-category]');
  if (filterButtons.length && filterItems.length) {
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const f = btn.getAttribute('data-filter');
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        filterItems.forEach(item => {
          const cats = item.getAttribute('data-category').split(' ');
          item.style.display = (f === 'all' || cats.includes(f)) ? '' : 'none';
        });
      });
    });
  }

  /* ---------- Contact form ---------- */
  const form = document.querySelector('#contact-form');
  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const status = document.querySelector('#form-status');
      const data = new FormData(form);

      if (!data.get('name') || !data.get('email') || !data.get('message')) {
        if (status) {
          status.textContent = 'Please fill in your name, email, and a short message.';
          status.className = 'form-status error';
        }
        return;
      }

      const btn = form.querySelector('[type="submit"]');
      if (btn) btn.disabled = true;
      if (status) { status.textContent = 'Sending…'; status.className = 'form-status'; }

      data.append('action', 'syseze_contact');
      data.append('nonce', (typeof sysezeAjax !== 'undefined') ? sysezeAjax.nonce : '');

      try {
        const res  = await fetch((typeof sysezeAjax !== 'undefined') ? sysezeAjax.ajaxurl : '/wp-admin/admin-ajax.php', { method: 'POST', body: data });
        const json = await res.json();
        if (json.success) {
          status.textContent = json.data;
          status.className = 'form-status success';
          form.reset();
        } else {
          status.textContent = json.data || 'Something went wrong. Please try again.';
          status.className = 'form-status error';
        }
      } catch (_) {
        if (status) {
          status.textContent = 'Network error. Please email us at hello@syseze.com.';
          status.className = 'form-status error';
        }
      } finally {
        if (btn) btn.disabled = false;
      }
    });
  }
})();
