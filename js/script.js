$(function () {
    // Cache DOM elements
    const owner = $('#owner');
    const cardNumber = $('#cardNumber');
    const cardNumberField = $('#card-number-field');
    const CVV = $("#cvv");
    const mastercard = $("#mastercard");
    const confirmButton = $('#confirm-purchase');
    const visa = $("#visa");
    const amex = $("#amex");

    // Format card number and CVV using the payform library
    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');

    // Card number input keyup event handler
    cardNumber.on('keyup', function () {
        // Reset card logos
        amex.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        // Validate card number
        const cardNum = cardNumber.val();
        if (!$.payform.validateCardNumber(cardNum)) {
            cardNumberField.addClass('has-error').removeClass('has-success');
        } else {
            cardNumberField.removeClass('has-error').addClass('has-success');
        }

        // Detect and highlight card type
        const cardType = $.payform.parseCardType(cardNum);
        switch (cardType) {
            case 'visa':
                mastercard.addClass('transparent');
                amex.addClass('transparent');
                break;
            case 'amex':
                mastercard.addClass('transparent');
                visa.addClass('transparent');
                break;
            case 'mastercard':
                amex.addClass('transparent');
                visa.addClass('transparent');
                break;
            default:
                // No action needed for unknown or unsupported card types
                break;
        }
    });

    // Confirm purchase button click event handler
    confirmButton.on('click', function (e) {
        e.preventDefault();

        const isCardValid = $.payform.validateCardNumber(cardNumber.val());
        const isCvvValid = $.payform.validateCardCVC(CVV.val());

        // Validate form inputs
        if (owner.val().length < 5) {
            alert("Invalid owner name");
        } else if (!isCardValid) {
            alert("Invalid card number");
        } else if (!isCvvValid) {
            alert("Invalid CVV");
        } else {
            // Form validation successful
            alert("Payment details are valid. Proceeding with submission...");
            // Add form submission logic here (e.g., form.submit())
        }
    });
});
