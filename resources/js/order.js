Echo.private('checkouts.' + orderId)
    .listen('.order-placed', (data) => {
        // Display a notification to the restaurant
        console.log('New order placed:', data.checkout);
    });
