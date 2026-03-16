const unitPrice = 1000;
const days = 30;
const quantityInput = document.getElementById("quantityPerDay");
const totalPriceInput = document.getElementById("totalPrice");

function calculateTotal() {
    let quantityPerDay = parseInt(quantityInput.value) || 0;

    if (quantityPerDay < 0) {
        alert("Quantity per day cannot be negative.Resetting to 0.");
        quantityPerDay = 0;
        quantityInput.value = 0;
}

