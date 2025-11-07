//PARA NAMAN SA LOADING ANIMATION
window.addEventListener('load', () => {
    const modal = document.getElementById('loading-modal');
  
    // Optional: small delay para smooth fade out
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 1000); // 1 second delay
  });
  
  //PARA NAMAN SA PAG REMEMBER ME 
  // Wait for page load
document.addEventListener('DOMContentLoaded', () => {
  const rememberCheckbox = document.getElementById('rememberDevice');
  const emailInput = document.getElementById('user-email');
  const passwordInput = document.getElementById('user-password');
  const loginButton = document.querySelector('.secure-login-btn');

  // Load saved info (if user checked remember)
  if (localStorage.getItem('remember') === 'true') {
    emailInput.value = localStorage.getItem('email') || '';
    passwordInput.value = localStorage.getItem('password') || '';
    rememberCheckbox.checked = true;
  }

  // When login button is clicked
  loginButton.addEventListener('click', (e) => {
    e.preventDefault(); // prevent actual form submit for demo

    if (rememberCheckbox.checked) {
      localStorage.setItem('remember', 'true');
      localStorage.setItem('email', emailInput.value);
      localStorage.setItem('password', passwordInput.value);
    } else {
      localStorage.removeItem('remember');
      localStorage.removeItem('email');
      localStorage.removeItem('password');
    }

    alert('Login simulated. Device preference saved!');
  });
});
