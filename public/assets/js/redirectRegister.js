$.ajax({
    url: $('#registerForm').attr('action'), // Use the form's action attribute
    method: $('#registerForm').attr('method'),
    data: {
        data: $('#registerForm').serialize(),
    },
    success: function(response) {
        if (response.redirect_url) {
            // Redirect to the specified URL
            window.location.href = response.redirect_url;
        } else {
            // Handle other responses as needed
            console.log(response.message);
        }
    },
    error: function(xhr, status, error) {
        // Handle errors if necessary
        console.error(error);
    }
});