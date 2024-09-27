// parking.js

function showForm(slotNumber) {
    // Set the slot number in the readonly input field
    document.getElementById("slotNumber").value = slotNumber;
    // Display the form container
    var formContainer = document.getElementById("formContainer");
    formContainer.style.display = "block";

    // Update the form title with the slot number
    var formTitle = document.querySelector(".form-container h2");
    formTitle.innerHTML = "Enter information for Slot " + slotNumber;

    // Additionally, you may want to reset the form fields if needed
    resetFormFields();
}

function resetFormFields() {
    // Reset form fields to default values or clear them
    document.getElementById("vehicleCategory").value = "2-wheeler";
    document.getElementById("vehicleName").value = "";
    document.getElementById("vehicleNumber").value = "";
    document.getElementById("ownerName").value = "";
    document.getElementById("ownerContact").value = "";
    document.getElementById("ownerAddress").value = "";
}

function hideForm() {
    // Hide the form container
    var formContainer = document.getElementById("formContainer");
    formContainer.style.display = "none";
}

function handlesubmit() {
    // Your custom JavaScript code here
    alert("Submitting the form!");

    // Return true to allow the form submission, or false to prevent it
    return true;
}
function setTime(time) {
    // Set the selected time to the hidden input field
    document.getElementById('selectedTime').value = time;

    // Update the time input field (optional)
    document.getElementById('time').value = time;
}