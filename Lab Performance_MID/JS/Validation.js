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

let totalPrice = quantityPerDay * unitPrice * days;
totalPriceInput.value = totalPrice;

    if (totalPrice > 1000) {
        alert("Congratulations! You are eligible for a gift coupon.");
    }
}

quantityInput.addEventListener("input", calculateTotal);