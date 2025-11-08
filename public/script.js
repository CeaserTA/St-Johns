// Modal functionality for Member Registration
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const modal = document.getElementById('registrationModal');
    const registerBtn = document.getElementById('registerBtn');
    const closeBtn = document.querySelector('.close');
    const registrationForm = document.getElementById('registrationForm');

    // Open modal when register button is clicked
    if (registerBtn) {
        registerBtn.addEventListener('click', function() {
            if (modal) {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        });
    }

    // Close modal when X is clicked
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            closeModal();
        });
    }

    // Close modal when clicking outside of it
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
            closeModal();
        }
    });

    function closeModal() {
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    }

    // Handle form submission
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(registrationForm);
            const data = {};
            
            // Handle regular form fields
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // Here you would typically send this data to your backend
            console.log('Registration data:', data);
            
            // Show success message (you can customize this)
            alert('Registration submitted successfully! We will contact you soon.');
            
            // Reset form and close modal
            registrationForm.reset();
            closeModal();
            
            // In a real application, you would make an API call here:
            // fetch('/api/register', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //     },
            //     body: JSON.stringify(data)
            // })
            // .then(response => response.json())
            // .then(result => {
            //     console.log('Success:', result);
            //     alert('Registration successful!');
            //     registrationForm.reset();
            //     closeModal();
            // })
            // .catch((error) => {
            //     console.error('Error:', error);
            //     alert('Registration failed. Please try again.');
            // });
        });
    }

    // Service/Event/Group selection functionality (for services.html, events.html, groups.html)
    // const selectableCards = document.querySelectorAll('.service-card, .event-card, .group-card');
    // selectableCards.forEach(card => {
    //     card.addEventListener('click', function() {
    //         // Toggle selection
    //         this.classList.toggle('selected');
    //         
    //         // Get the ID or data attribute to identify which item was selected
    //         const itemId = this.dataset.id || this.id;
    //         console.log('Selected item:', itemId);
    //         
    //         // Here you would typically send this selection to your backend
    //         // fetch('/api/select-item', {
    //         //     method: 'POST',
    //         //     headers: {
    //         //         'Content-Type': 'application/json',
    //         //     },
    //         //     body: JSON.stringify({ itemId: itemId })
    //         // })
    //         // .then(response => response.json())
    //         // .then(data => {
    //         //     console.log('Selection saved:', data);
    //         // })
    //         // .catch((error) => {
    //         //     console.error('Error:', error);
    //         // });
    //     });
    // });

    // Load services/events/groups from backend (example function)
    // async function loadItems(endpoint) {
    //     try {
    //         // This is a placeholder - replace with your actual backend endpoint
    //         // const response = await fetch(endpoint);
    //         // const items = await response.json();
    //         // return items;
    //         
    //         // For now, return empty array - you'll populate this from your backend
    //         return [];
    //     } catch (error) {
    //         console.error('Error loading items:', error);
    //         return [];
    //     }
    // }

    // Make loadItems available globally if needed
    // window.loadItems = loadItems;
});

