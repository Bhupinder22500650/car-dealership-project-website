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
  // ------------------ 1. Field Highlighting ------------------
  document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('focus', () => {
      input.style.backgroundColor = 'yellow';
      input.style.color = 'black';
    });
    input.addEventListener('blur', () => {
      input.style.backgroundColor = '';  // reset
      input.style.color = '';
    });
  });

  // ------------------ 2. Navigation Link Hover Effects ------------------
  document.querySelectorAll('nav a').forEach(link => {
    link.addEventListener('mouseover', () => link.style.color = 'green');
    link.addEventListener('mouseout',  () => link.style.color = '');
  });

  // ------------------ 3. Button Hover Effects ------------------
  document.querySelectorAll('button').forEach(btn => {
    btn.addEventListener('mouseover', () => btn.style.backgroundColor = 'lightblue');
    btn.addEventListener('mouseout',  () => btn.style.backgroundColor = '');
  });

  // ------------------ 4. Login Form Submission Popup ------------------
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
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
    registrationForm.addEventListener('submit', function(e) {
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
    addCarForm.addEventListener('submit', function(e) {
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
    searchForm.addEventListener('submit', function(e) {
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
    feedbackForm.addEventListener('submit', function(e) {
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

  // ------------------ 9. Reserved for future enhancements ------------------
});
