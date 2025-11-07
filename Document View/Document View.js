document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabs = document.querySelectorAll('.tab');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        // Remove active class from all tabs and panes
        tabs.forEach(t => t.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Show corresponding tab pane
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
      });
    });
    
    // Back button functionality
    const backButton = document.getElementById('backButton');
    if (backButton) {
      backButton.addEventListener('click', function() {
        // Add your back navigation logic here
        alert('Navigating back to results...');
        // window.history.back(); // Uncomment this for actual back navigation
      });
    }
    
    // Action buttons functionality
    const actionButtons = document.querySelectorAll('.action-button');
    actionButtons.forEach(button => {
      button.addEventListener('click', function() {
        const title = this.getAttribute('title');
        alert(`${title} action triggered`);
        
        // Add specific functionality for each button
        switch(title) {
          case 'Edit':
            // Edit functionality
            break;
          case 'Print':
            window.print();
            break;
          case 'Download':
            // Download functionality
            break;
        }
      });
    });
  });