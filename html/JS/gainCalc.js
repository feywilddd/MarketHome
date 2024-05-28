document.addEventListener("DOMContentLoaded", function () {
    let priceInput = document.getElementById('PriceInput');
    let gainLabel = document.getElementById('gainLabel');

    function updateGainLabel() {
        let price = parseFloat(priceInput.value);
        if (!isNaN(price)) {
            price = price * 0.02 + 0.30;
            gainLabel.textContent = "Afin de rester en activité, MarketHome se prendra une cote sur votre vente d'une valeur de : " + price.toFixed(2) + '$';
        }
    }

    priceInput.addEventListener('input', updateGainLabel);
});