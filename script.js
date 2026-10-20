/**
 * CampusFest 2026 - Master Interactive JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {

  // ==========================================================================
  // 1. Mobile Navigation Toggle
  // ==========================================================================
  const navToggleBtn = document.getElementById('navToggleBtn');
  const navLinks = document.getElementById('navLinks');

  if (navToggleBtn && navLinks) {
    navToggleBtn.addEventListener('click', () => {
      navLinks.classList.toggle('nav-open');
      const isExpanded = navLinks.classList.contains('nav-open');
      navToggleBtn.setAttribute('aria-expanded', isExpanded);
      navToggleBtn.innerHTML = isExpanded ? '&#10005;' : '&#9776;';
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!navLinks.contains(e.target) && !navToggleBtn.contains(e.target) && navLinks.classList.contains('nav-open')) {
        navLinks.classList.remove('nav-open');
        navToggleBtn.innerHTML = '&#9776;';
      }
    });
  }

  // ==========================================================================
  // 2. Countdown Timer for CampusFest 2026
  // ==========================================================================
  const daysEl = document.getElementById('cdDays');
  const hoursEl = document.getElementById('cdHours');
  const minsEl = document.getElementById('cdMins');
  const secsEl = document.getElementById('cdSecs');

  if (daysEl && hoursEl && minsEl && secsEl) {
    // Set target date for CampusFest
    let festDate = new Date('March 18, 2026 09:00:00').getTime();
    const now = new Date().getTime();

    // If target date is in the past, set 150 days from today for dynamic festival countdown
    if (festDate <= now) {
      festDate = now + (142 * 24 * 60 * 60 * 1000);
    }

    function updateCountdown() {
      const currentTime = new Date().getTime();
      const distance = festDate - currentTime;

      if (distance < 0) {
        daysEl.innerText = '00';
        hoursEl.innerText = '00';
        minsEl.innerText = '00';
        secsEl.innerText = '00';
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      daysEl.innerText = days < 10 ? '0' + days : days;
      hoursEl.innerText = hours < 10 ? '0' + hours : hours;
      minsEl.innerText = minutes < 10 ? '0' + minutes : minutes;
      secsEl.innerText = seconds < 10 ? '0' + seconds : seconds;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
  }

  // ==========================================================================
  // 3. Category Filter Tabs (Events & Gallery)
  // ==========================================================================
  const filterBtns = document.querySelectorAll('.filter-btn');
  const filterableItems = document.querySelectorAll('.filterable-item');

  if (filterBtns.length > 0 && filterableItems.length > 0) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Remove active class from all buttons
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filterValue = btn.getAttribute('data-filter');

        filterableItems.forEach(item => {
          const category = item.getAttribute('data-category');
          if (filterValue === 'all' || category === filterValue) {
            item.style.display = '';
            item.style.opacity = '0';
            setTimeout(() => {
              item.style.transition = 'opacity 0.4s ease';
              item.style.opacity = '1';
            }, 50);
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

  // ==========================================================================
  // 4. Registration Dynamic Event Selection & Fee Calculator
  // ==========================================================================
  const eventSelect = document.getElementById('eventSelect');
  const feeDisplay = document.getElementById('feeDisplay');
  const feeHiddenInput = document.getElementById('feeHiddenInput');
  const teamSection = document.getElementById('teamDetailsSection');
  const teamTypeRadios = document.querySelectorAll('input[name="team_type"]');

  if (eventSelect) {
    eventSelect.addEventListener('change', () => {
      const selectedOption = eventSelect.options[eventSelect.selectedIndex];
      const fee = selectedOption.getAttribute('data-fee') || '0.00';
      const isTeam = selectedOption.getAttribute('data-team') === 'true';

      if (feeDisplay) {
        feeDisplay.textContent = '₹' + parseFloat(fee).toFixed(2);
      }
      if (feeHiddenInput) {
        feeHiddenInput.value = fee;
      }

      // Show team details if the event is a team event
      if (teamSection) {
        if (isTeam) {
          teamSection.style.display = 'block';
          const teamRadio = document.querySelector('input[name="team_type"][value="Team"]');
          if (teamRadio) teamRadio.checked = true;
        } else {
          // If solo or no specific requirement, let user choose
          const checkedRadio = document.querySelector('input[name="team_type"]:checked');
          if (checkedRadio && checkedRadio.value === 'Solo') {
            teamSection.style.display = 'none';
          }
        }
      }
    });

    // Handle radio changes
    teamTypeRadios.forEach(radio => {
      radio.addEventListener('change', () => {
        if (teamSection) {
          teamSection.style.display = radio.value === 'Team' ? 'block' : 'none';
        }
      });
    });
  }

  // ==========================================================================
  // 5. Lightbox Modal (Gallery)
  // ==========================================================================
  const lightboxModal = document.getElementById('lightboxModal');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const lightboxClose = document.getElementById('lightboxClose');
  const galleryItems = document.querySelectorAll('.gallery-item');

  if (lightboxModal && lightboxImg && galleryItems.length > 0) {
    galleryItems.forEach(item => {
      item.addEventListener('click', () => {
        const img = item.querySelector('img');
        const caption = item.querySelector('.gallery-caption');
        
        if (img) {
          lightboxImg.src = img.src;
          lightboxImg.alt = img.alt || 'Gallery photo';
        }
        if (lightboxCaption && caption) {
          lightboxCaption.textContent = caption.textContent;
        }

        lightboxModal.classList.add('active');
        document.body.style.overflow = 'hidden';
      });
    });

    const closeModal = () => {
      lightboxModal.classList.remove('active');
      document.body.style.overflow = '';
    };

    if (lightboxClose) {
      lightboxClose.addEventListener('click', closeModal);
    }

    lightboxModal.addEventListener('click', (e) => {
      if (e.target === lightboxModal) {
        closeModal();
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && lightboxModal.classList.contains('active')) {
        closeModal();
      }
    });
  }

  // ==========================================================================
  // 6. Accordion (FAQ & Guidelines)
  // ==========================================================================
  const accordionButtons = document.querySelectorAll('.accordion-btn');
  accordionButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.parentElement;
      const isOpen = item.classList.contains('active');

      // Close all others
      document.querySelectorAll('.accordion-item').forEach(other => {
        other.classList.remove('active');
      });

      if (!isOpen) {
        item.classList.add('active');
      }
    });
  });

  // ==========================================================================
  // 7. Payment Gateway Interactive Simulator
  // ==========================================================================
  const payTabs = document.querySelectorAll('.gateway-tab');
  const tabContents = document.querySelectorAll('.payment-tab-content');

  if (payTabs.length > 0) {
    payTabs.forEach(tab => {
      tab.addEventListener('click', () => {
        payTabs.forEach(t => t.classList.remove('active'));
        tabContents.forEach(c => c.style.display = 'none');

        tab.classList.add('active');
        const targetId = tab.getAttribute('data-target');
        const targetContent = document.getElementById(targetId);
        if (targetContent) {
          targetContent.style.display = 'block';
        }
      });
    });
  }

  // Format Card Number input
  const cardNumberInput = document.getElementById('card_number');
  if (cardNumberInput) {
    cardNumberInput.addEventListener('input', (e) => {
      let value = e.target.value.replace(/\D/g, '');
      let formatted = '';
      for (let i = 0; i < value.length && i < 16; i++) {
        if (i > 0 && i % 4 === 0) formatted += ' ';
        formatted += value[i];
      }
      e.target.value = formatted;
    });
  }

  // Format Expiry Date (MM/YY)
  const cardExpInput = document.getElementById('card_exp');
  if (cardExpInput) {
    cardExpInput.addEventListener('input', (e) => {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length >= 2) {
        e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
      } else {
        e.target.value = value;
      }
    });
  }

  // Auto-dismiss Alerts after 6 seconds
  const autoDismissAlerts = document.querySelectorAll('.alert-dismissible');
  if (autoDismissAlerts.length > 0) {
    setTimeout(() => {
      autoDismissAlerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 500);
      });
    }, 6000);
  }

});
