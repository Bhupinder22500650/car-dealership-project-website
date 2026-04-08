/**
 * script.js
 * Core JavaScript for COSS website interactions (cleaned and fixed)
 *
 * Sections:
 * 1. Field Highlighting
 * 2. Navigation Hover Effects
 * 3. Button Hover Effects
 * 4. Login Form Submission Popup
 * 5. Registration Form Submission Popup
 * 6. Add Car Form Submission Popup
 * 7. Search Form Validation
 * 8. Feedback Form Submission Popup
 * 9. Dynamic Car Search & Popup
 */

document.addEventListener('DOMContentLoaded', () => {


  // ------------------ 4. Login Form Submission Popup ------------------
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault(); // Prevent default submission

      const user = this.username.value.trim();
      const pass = this.password.value.trim();

      // Clear previous error messages
      const errorDiv = this.querySelector('.error-message');
      if (errorDiv) errorDiv.remove();

      // Validate inputs
      if (!user || !pass) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.textContent = '⚠️ Please enter both username and password.';
        this.insertBefore(error, this.firstChild);
        return;
      }

      // If validation passes, submit the form
      this.submit();
    });
  }

  // ------------------ 5. Registration Form Submission Popup ------------------
  const registrationForm = document.querySelector('.registration__form');
  if (registrationForm) {
    registrationForm.addEventListener('submit', function (e) {
      e.preventDefault(); // Prevent default submission

      // Clear previous error messages
      const errorDiv = this.querySelector('.error-message');
      if (errorDiv) errorDiv.remove();

      // Get form values
      const firstName = this.firstName.value.trim();
      const lastName = this.lastName.value.trim();
      const address = this.address.value.trim();
      const phone = this.phone.value.trim();
      const email = this.email.value.trim();
      const username = this.username.value.trim();
      const password = this.password.value.trim();

      // Validation rules
      const errors = [];

      if (username.length < 6) {
        errors.push('Username must be at least 6 characters long');
      }

      if (password.length < 6) {
        errors.push('Password must be at least 6 characters long');
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.push('Please enter a valid email address');
      }

      if (!/^[\d+\-\s()]+$/.test(phone)) {
        errors.push('Please enter a valid phone number');
      }

      if (firstName.length < 2) {
        errors.push('First name must be at least 2 characters long');
      }

      if (lastName.length < 2) {
        errors.push('Last name must be at least 2 characters long');
      }

      if (address.length < 5) {
        errors.push('Please enter a valid address');
      }

      // If there are errors, display them
      if (errors.length > 0) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.innerHTML = errors.map(err => `• ${err}`).join('<br>');
        this.insertBefore(error, this.firstChild);
        return;
      }

      // If validation passes, submit the form
      this.submit();
    });
  }

  // ------------------ 6. Add Car Form Submission Popup ------------------
  const addCarForm = document.getElementById('addCarForm');
  if (addCarForm) {
    addCarForm.addEventListener('submit', function (e) {
      // If there's a file being uploaded, let the form submit normally
      const fileInput = this.querySelector('input[type="file"]');
      if (fileInput && fileInput.files.length > 0) {
        return true;
      }

      e.preventDefault();

      // Clear previous error messages
      const errorDiv = this.querySelector('.error-message');
      if (errorDiv) errorDiv.remove();

      // Get form values
      const company = this.company.value.trim();
      const model = this.model.value.trim();
      const year = parseInt(this.year.value.trim());
      const price = parseFloat(this.price.value.trim());
      const location = this.location.value.trim();
      const bodyType = this.bodyType.value.trim();

      // Validation rules
      const errors = [];

      if (company.length < 2) {
        errors.push('Company name must be at least 2 characters long');
      }

      if (model.length < 2) {
        errors.push('Car model must be at least 2 characters long');
      }

      if (isNaN(year) || year < 1900 || year > new Date().getFullYear()) {
        errors.push(`Year must be between 1900 and ${new Date().getFullYear()}`);
      }

      if (isNaN(price) || price <= 0) {
        errors.push('Price must be greater than 0');
      }

      if (location.length < 2) {
        errors.push('Location must be at least 2 characters long');
      }

      const validBodyTypes = ['Sedan', 'SUV', 'Hatchback', 'Coupe', 'Convertible', 'Wagon', 'Van', 'Truck'];
      if (!validBodyTypes.includes(bodyType)) {
        errors.push('Please select a valid body type');
      }

      // If there are errors, display them
      if (errors.length > 0) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.innerHTML = errors.map(err => `• ${err}`).join('<br>');
        this.insertBefore(error, this.firstChild);
        return;
      }

      // If no errors, submit the form
      this.submit();
    });
  }

  // ------------------ 7. Search Form Validation ------------------
  const searchForm = document.querySelector('form[action="search.php"]') || document.querySelector('form.search-form');
  if (searchForm) {
    searchForm.addEventListener('submit', function (e) {
      e.preventDefault();

      // Clear previous error messages
      const errorDiv = this.querySelector('.error-message');
      if (errorDiv) errorDiv.remove();

      // Get form values
      const model = this.querySelector('input[name="model"]')?.value.trim();
      const year = this.querySelector('input[name="year"]')?.value.trim();
      const price = this.querySelector('input[name="price"]')?.value.trim();

      // At least one field must be filled
      if (!model && !year && !price) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.textContent = '⚠️ Please fill in at least one search field.';
        this.insertBefore(error, this.firstChild);
        return;
      }

      // Validate year if provided
      if (year && (isNaN(year) || year < 1900 || year > new Date().getFullYear())) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.textContent = '⚠️ Please enter a valid year between 1900 and ' + new Date().getFullYear();
        this.insertBefore(error, this.firstChild);
        return;
      }

      // Validate price if provided
      if (price && (isNaN(price) || price <= 0)) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.textContent = '⚠️ Please enter a valid price greater than 0.';
        this.insertBefore(error, this.firstChild);
        return;
      }

      // If validation passes, submit the form
      this.submit();
    });
  }

  // ------------------ 8. Feedback Form Submission Popup ------------------
  const feedbackForm = document.querySelector('.feedback__form');
  if (feedbackForm) {
    feedbackForm.addEventListener('submit', function (e) {
      e.preventDefault();

      // Clear previous error messages
      const errorDiv = this.querySelector('.error-message');
      if (errorDiv) errorDiv.remove();

      // Get form values
      const email = this.email.value.trim();
      const feedbackField = this.querySelector('[name="feedback"], [name="comment"]');
      const feedback = feedbackField ? feedbackField.value.trim() : '';

      // Validation rules
      const errors = [];

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.push('Please enter a valid email address');
      }

      if (feedback.length < 10) {
        errors.push('Feedback must be at least 10 characters long');
      }

      if (feedback.length > 1000) {
        errors.push('Feedback cannot exceed 1000 characters');
      }

      // If there are errors, display them
      if (errors.length > 0) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.color = '#ff4d4d';
        error.style.marginBottom = '1rem';
        error.innerHTML = errors.map(err => `• ${err}`).join('<br>');
        this.insertBefore(error, this.firstChild);
        return;
      }

      // If validation passes, submit the form
      this.submit();
    });
  }

  // ------------------ 9. Universal 3D Tilt & Glassmorphism ------------------
  // Dynamically inject premium styles into existing components
  const premiumElements = document.querySelectorAll('.car-card, .message-card, .form__container, .search__container, .car-form, .car-detail__full-info, .car-detail__spec-item');
  premiumElements.forEach(el => {
    el.classList.add('glass-panel', 'tilt-element');
  });

  const magneticButtons = document.querySelectorAll('.form__btn, .search__btn, .car-detail__button, .feedback__button, .car-card__view-btn');
  magneticButtons.forEach(btn => {
    btn.classList.add('magnetic-btn');
  });

  // Track all tilt-elements
  const tiltElements = document.querySelectorAll('.tilt-element, .hero__content');
  
  tiltElements.forEach(el => {
    // The container tracking the mouse. For Hero, it's the wrapper. For cards, it's the card itself.
    const container = el.classList.contains('hero__content') ? document.querySelector('.hero') : el;
    
    if (container) {
      container.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = container.getBoundingClientRect();
        // Calculate mouse position relative to the center of the element (-0.5 to 0.5)
        const x = (e.clientX - left) / width - 0.5;
        const y = (e.clientY - top) / height - 0.5;
  
        // Aggressiveness of tilt
        const rotateX = y * -25; // Tilt up to 12.5 degrees
        const rotateY = x * 25;
  
        el.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(20px)`;
      });
  
      container.addEventListener('mouseleave', () => {
        el.style.transform = `rotateX(0) rotateY(0) translateZ(0)`;
        el.style.transition = `transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)`;
      });
  
      container.addEventListener('mouseenter', () => {
        el.style.transition = `transform 0.1s linear`; // Snap to cursor quickly without delay
      });
    }
  });

  // Track Magnetic Buttons
  magneticButtons.forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
      const { left, top, width, height } = btn.getBoundingClientRect();
      const x = (e.clientX - left) / width - 0.5;
      const y = (e.clientY - top) / height - 0.5;

      // Small translation towards mouse
      btn.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
    });

    btn.addEventListener('mouseleave', () => {
      btn.style.transform = `translate(0px, 0px)`;
    });
  });

  // ------------------ 10. Global 3D Scroll Reveal Animations ------------------
  // Create an Intersection Observer to watch for elements entering the viewport
  const revealOptions = {
    root: null, // Viewport
    rootMargin: '0px 0px -50px 0px', // Trigger slightly before the element is fully in view
    threshold: 0.05 // 5% of the element must be visible
  };

  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      // If the element is within the viewport
      if (entry.isIntersecting) {
        entry.target.classList.add('active'); // Add the active class to trigger CSS animation
      }
    });
  }, revealOptions);

  // Find all elements with the .reveal-3d class and observe them
  const revealElements = document.querySelectorAll('.reveal-3d');
  revealElements.forEach(el => revealObserver.observe(el));
});
