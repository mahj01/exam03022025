const trueRadio = document.querySelector('#trueRadio');
const falseRadio = document.querySelector('#falseRadio');
const aCacher = document.querySelector('.dateVenteContainer');

// Ajouter un événement pour vérifier quand le radio "trueRadio" est sélectionné
trueRadio.addEventListener('change', () => {
  if (trueRadio.checked) {
    aCacher.style.display = 'none';  // Masque l'élément si trueRadio est sélectionné
  }
});

// Ajouter un événement pour vérifier quand le radio "falseRadio" est sélectionné
falseRadio.addEventListener('change', () => {
  if (falseRadio.checked) {
    aCacher.style.display = '';  // Restaure l'affichage de l'élément si falseRadio est sélectionné
  }
});


document.addEventListener('DOMContentLoaded', function() {
    const autoVenteRadios = document.querySelectorAll('input[name="autovente"]');
    const dateVenteContainer = document.getElementById('dateVenteContainer');

    // Function to hide or show the date input based on the selected value of 'autovente'
    function toggleDateVenteVisibility() {
        const selectedValue = document.querySelector('input[name="autovente"]:checked').value;
        
        if (selectedValue === "0") {
            dateVenteContainer.style.display = 'none'; // Hide the date input container
        } else {
            dateVenteContainer.style.display = 'block'; // Show the date input container
        }
    }

    // Initialize the visibility based on the current state of the radio buttons
    toggleDateVenteVisibility();

    // Add event listeners to the radio buttons
    autoVenteRadios.forEach(function(radio) {
        radio.addEventListener('change', toggleDateVenteVisibility);
    });
});
