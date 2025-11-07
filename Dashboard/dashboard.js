const menuLinks = document.querySelectorAll('.nav-menu a');

menuLinks.forEach(link => {
  link.addEventListener('click', () => {
    // Alisin active sa lahat
    menuLinks.forEach(l => l.classList.remove('active'));
    // Lagay active sa na-click
    link.classList.add('active');
  });
});

const userProfile = document.getElementById('userProfile');
const dropdownMenu = document.getElementById('dropdownMenu');

// toggle dropdown visibility when profile is clicked
userProfile.addEventListener('click', (event) => {
  event.stopPropagation(); // prevent closing immediately
  dropdownMenu.style.display =
    dropdownMenu.style.display === 'flex' ? 'none' : 'flex';
});

// close dropdown when clicking outside
window.addEventListener('click', (e) => {
  if (!userProfile.contains(e.target)) {
    dropdownMenu.style.display = 'none';
  }
});

document.getElementById('logoutBtn').addEventListener('click', (e) => {
    e.preventDefault(); // prevent default link behavior
    window.location.href = 'LOGIN/login.html'; // redirect to login page (fixed path to forward slash for cross-platform)
  });
  
  const notifIcon = document.getElementById('notifIcon');
const notifDropdown = document.getElementById('notifDropdown');

// toggle dropdown
notifIcon.addEventListener('click', (event) => {
  event.stopPropagation();
  notifDropdown.classList.toggle('active');
});

// close when clicking outside
window.addEventListener('click', (e) => {
  if (!notifDropdown.contains(e.target) && e.target !== notifIcon) {
    notifDropdown.classList.remove('active');
  }
});

const darkModeToggle = document.getElementById('darkModeToggle');

// Check saved theme (para kahit i-refresh, same pa rin)
if (localStorage.getItem('theme') === 'dark') {
  document.body.classList.add('dark-mode');
  // Use safer class manipulation
  darkModeToggle.classList.remove('bx-moon');
  darkModeToggle.classList.add('bx-sun');
}

darkModeToggle.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');

  if (document.body.classList.contains('dark-mode')) {
    // Use safer class manipulation
    darkModeToggle.classList.remove('bx-moon');
    darkModeToggle.classList.add('bx-sun');
    localStorage.setItem('theme', 'dark');
  } else {
    darkModeToggle.classList.remove('bx-sun');
    darkModeToggle.classList.add('bx-moon');
    localStorage.setItem('theme', 'light');
  }
});

//PARA NAMAN SA LOADING ANIMATION
window.addEventListener('load', () => {
    const modal = document.getElementById('loading-modal');
  
    // Optional: small delay para smooth fade out
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 1000); // 1 second delay
  });


// --- Dropdown Smooth Show/Hide ---
document.querySelectorAll('.dropdown > a').forEach(menu => {
  menu.addEventListener('click', e => {
    e.preventDefault();
    const parent = menu.parentElement;
    parent.classList.toggle('active');
    
    // Close other dropdowns
    document.querySelectorAll('.dropdown').forEach(drop => {
      if (drop !== parent) drop.classList.remove('active');
    });
  });
});

// Optional: Close dropdown when clicking outside
document.addEventListener('click', e => {
  if (!e.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown').forEach(drop => drop.classList.remove('active'));
  }
});

const navDropdowns = document.querySelectorAll('.nav-menu .dropdown');

navDropdowns.forEach(drop => {
  const link = drop.querySelector('a');
  link.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();

    // isara lahat ng dropdowns muna
    navDropdowns.forEach(d => {
      if (d !== drop) d.classList.remove('active');
    });

    // toggle current
    drop.classList.toggle('active');
  });
});

// isara kapag nag-click sa labas
window.addEventListener('click', () => {
  navDropdowns.forEach(d => d.classList.remove('active'));
});

document.querySelectorAll('.nav-menu .dropdown > a').forEach(menu => {
  menu.addEventListener('click', (e) => {
    e.preventDefault();
    const parent = menu.parentElement;

    // Close all dropdowns first
    document.querySelectorAll('.nav-menu .dropdown').forEach(drop => {
      if (drop !== parent) drop.classList.remove('active');
    });

    // Toggle current
    parent.classList.toggle('active');
  });
});

document.addEventListener('click', (e) => {
  if (!e.target.closest('.nav-menu')) {
    document.querySelectorAll('.nav-menu .dropdown').forEach(drop => drop.classList.remove('active'));
  }
});

// --- Tab Functionality ---
const tabButtons = document.querySelectorAll(".tab-button");
const tabContents = document.querySelectorAll(".tab-content");

tabButtons.forEach(button => {
  button.addEventListener("click", () => {
    // Remove active from all buttons and contents
    tabButtons.forEach(btn => btn.classList.remove("active"));
    tabContents.forEach(content => content.classList.remove("active"));

    // Activate clicked button and its content
    button.classList.add("active");
    document.getElementById(button.dataset.tab).classList.add("active");
  });
});


// --- Quick Links (para sa Detailed/Quick Search anchors) ---
const quickLinks = document.querySelectorAll(".quick-link");

quickLinks.forEach(link => {
  link.addEventListener("click", (e) => {
    e.preventDefault();

    // Kunin kung aling tab ang target
    const targetTab = link.dataset.tab;

    // Alisin muna active sa lahat ng tab buttons at tab contents
    document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
    document.querySelectorAll(".tab-content").forEach(content => content.classList.remove("active"));

    // I-activate yung tab na tinutukoy ng link
    const targetButton = document.querySelector(`.tab-button[data-tab="${targetTab}"]`);
    const targetContent = document.getElementById(targetTab);

    if (targetButton && targetContent) {
      targetButton.classList.add("active");
      targetContent.classList.add("active");
    }

    // Optional: scroll to top kapag nagpalit ng tab
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});


// --- Unified Tab Activation Function ---
function activateTab(tabId) {
  // Remove active classes
  document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));
  document.querySelectorAll(".tab-content").forEach(content => content.classList.remove("active"));

  // Find and activate the correct button/content
  const targetBtn = document.querySelector(`.tab-button[data-tab="${tabId}"]`);
  const targetContent = document.getElementById(tabId);

  if (targetBtn && targetContent) {
    targetBtn.classList.add("active");
    targetContent.classList.add("active");
  }

  // Optional: close any open dropdowns
  document.querySelectorAll(".dropdown").forEach(drop => drop.classList.remove("active"));

  // Scroll to top
  window.scrollTo({ top: 0, behavior: "smooth" });
}

// --- Quick Links + Dropdown Search Links ---
document.querySelectorAll(".quick-link, .search-link").forEach(link => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const targetTab = link.dataset.tab;
    if (targetTab) {
      activateTab(targetTab);
    }
  });
});



//PARA SA DOCUMENT SEARCH FORM SWITCHING
// Function to switch between document type forms
function switchForm(type) {
    // Hide all forms
    document.querySelectorAll('.form-content').forEach(form => {
        form.classList.remove('active');
    });
    
    // Show selected form
    document.getElementById(type + '-form').classList.add('active');
}

// Initialize event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to radio buttons for form switching
    const radioButtons = document.querySelectorAll('input[name="documentType"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            switchForm(this.value);
        });
    });

    // Handle search button click for Detailed Search
    const resultsEl = document.getElementById('detailed-results');
    const headEl = document.getElementById('detailed-results-head');
    const bodyEl = document.getElementById('detailed-results-body');
    const countEl = document.getElementById('detailed-results-count');

    // Add error handling
    if (!resultsEl || !headEl || !bodyEl || !countEl) {
      console.error('Detailed search results elements not found');
      return;
    }

    document.querySelector('.search-button').addEventListener('click', function(e) {
        e.preventDefault();
        const type = document.querySelector('input[name="documentType"]:checked').value;

        // Define columns per type
        const columns = {
            birth: ['No.', 'Province', 'City/Municipality', 'Book', 'Page', 'Registry No.', 'Name of Child', 'Name of Mother', 'Name of Father'],
            marriage: ['No.', 'Province', 'City/Municipality', 'Book', 'Page', 'Registry No.', 'Name of Husband', 'Name of Wife', "Name of Husband's Father", "Name of Husband's Mother", "Name of Wife's Father", "Name of Wife's Mother"],
            death: ['No.', 'Province', 'City/Municipality', 'Book', 'Page', 'Registry No.', 'Name of Deceased', 'Name of Father', 'Name of Mother']
        };

        const sampleRows = {
            birth: [
                ['1','Daet','Camarines Norte','12','34','LCR-2023-001','Juan Dela Cruz','Maria Dela Cruz','Carlos Dela Cruz'],
                ['2','Basud','Camarines Norte','08','22','LCR-2023-045','Juan Dela Luna','Glenda Dela Luna','Mario Dela Luna'],
                ['3','Daet','Camarines Norte','15','67','LCR-2023-089','Juan Dela Paz','Jualia Dela Paz','Fred Dela Paz']
            ],
            marriage: [
                ['1','Daet','Camarines Norte','13','23','LCR-2023-001','Juan Dela Cruz','Maria Dela Cruz','Carlos Dela Cruz','Josie Dela Cruz','Jojo Avilla','Nina Avilla'],
                ['2','Basud','Camarines Norte','02','12','LCR-2023-045','Juan Dela Luna','Glenda Dela Luna','Mario Dela Luna','Rose Dela Luna','Jun Villarcruz','Anne Villarcruz']
            ],
            death: [
                ['1','Daet','Camarines Norte','12','34','LCR-2023-001','Juan Dela Cruz','Carlos Dela Cruz','Maria Dela Cruz'],
                ['2','Basud','Camarines Norte','08','22','LCR-2023-045','Juan Dela Luna','Mario Dela Luna','Glenda Dela Luna'],
                ['3','Daet','Camarines Norte','15','67','LCR-2023-089','Juan Dela Paz','Fred Dela Paz','Jualia Dela Paz']
            ]
        };

        // Render header
        headEl.innerHTML = columns[type].map(c => `<th>${c}</th>`).join('');
        // Render rows
        bodyEl.innerHTML = sampleRows[type].map(r => `<tr>${r.map(v => `<td>${v}</td>`).join('')}</tr>`).join('');
        countEl.textContent = `${sampleRows[type].length} documents found`;

        resultsEl.classList.add('show');
        resultsEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // View document navigation
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'viewDocBtn') {
            window.location.href = 'view-document.html';
        }
    });
});






//Quick search functionality
// Handle search button click for Quick Search
const resultsEl = document.getElementById('quick-results');
const headEl = document.getElementById('quick-results-head');
const bodyEl = document.getElementById('quick-results-body');
const countEl = document.getElementById('quick-results-count');
const keywordInput = document.getElementById('searchKeyword'); // Added missing declaration

// Add error handling
if (!resultsEl || !headEl || !bodyEl || !countEl || !keywordInput) {
  console.error('Quick search results elements not found');
} else {
  document.querySelector('.search-button2').addEventListener('click', function(e) { // Changed to .search-button2 for Quick Search
      e.preventDefault();
      const type = document.querySelector('input[name="documentTypeQuick"]:checked').value; // Updated name for Quick Search
      const keyword = keywordInput.value.trim();

      if (!keyword) {
          alert('Please enter a search keyword');
          return;
      }

      // Define columns per type
      const columns = {
          birth: ['No.', 'Province', 'City/Municipality', 'Book', 'Page', 'Registry No.', 'Name of Child', 'Name of Mother', 'Name of Father'],
          marriage: ['No.', 'Province', 'City/Municipality', 'Book', 'Page', 'Registry No.', 'Name of Husband', 'Name of Wife', "Name of Husband's Father", "Name of Husband's Mother", "Name of Wife's Father", "Name of Wife's Mother"],
          death: ['No.', 'Province', 'City/Municipality', 'Book', 'Page', 'Registry No.', 'Name of Deceased', 'Name of Father', 'Name of Mother']
      };

      // Sample data filtered by keyword (simulating search)
      const sampleData = {
          birth: [
              ['1','Daet','Camarines Norte','12','34','LCR-2023-001','Juan Dela Cruz','Maria Dela Cruz','Carlos Dela Cruz'],
              ['2','Basud','Camarines Norte','08','22','LCR-2023-045','Juan Dela Luna','Glenda Dela Luna','Mario Dela Luna'],
              ['3','Daet','Camarines Norte','15','67','LCR-2023-089','Juan Dela Paz','Jualia Dela Paz','Fred Dela Paz']
          ],
          marriage: [
              ['1','Daet','Camarines Norte','13','23','LCR-2023-001','Juan Dela Cruz','Maria Dela Cruz','Carlos Dela Cruz','Josie Dela Cruz','Jojo Avilla','Nina Avilla'],
              ['2','Basud','Camarines Norte','02','12','LCR-2023-045','Juan Dela Luna','Glenda Dela Luna','Mario Dela Luna','Rose Dela Luna','Jun Villarcruz','Anne Villarcruz']
          ],
          death: [
              ['1','Daet','Camarines Norte','12','34','LCR-2023-001','Juan Dela Cruz','Carlos Dela Cruz','Maria Dela Cruz'],
              ['2','Basud','Camarines Norte','08','22','LCR-2023-045','Juan Dela Luna','Mario Dela Luna','Glenda Dela Luna'],
              ['3','Daet','Camarines Norte','15','67','LCR-2023-089','Juan Dela Paz','Fred Dela Paz','Jualia Dela Paz']
          ]
      };

      // Filter results based on keyword (simple contains search)
      const filteredData = sampleData[type].filter(row => 
          row.some(cell => cell.toLowerCase().includes(keyword.toLowerCase()))
      );

      // Render header
      headEl.innerHTML = columns[type].map(c => `<th>${c}</th>`).join('');
      // Render rows
      bodyEl.innerHTML = filteredData.map(r => `<tr>${r.map(v => `<td>${v}</td>`).join('')}</tr>`).join('');
      countEl.textContent = `${filteredData.length} documents found`;

      resultsEl.classList.add('show');
      resultsEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // Allow Enter key to trigger search
  keywordInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
          document.querySelector('.search-button2').click(); // Changed to .search-button2
      }
  });
}

// View document navigation
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'viewDocBtn') {
        window.location.href = 'view-document.html';
    }
});
