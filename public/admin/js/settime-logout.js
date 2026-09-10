let idleTime = 0;
    const maxIdleTime = 2 * 60 * 100; // 1 minutes (in milliseconds)

    function resetIdleTimer() {
        clearTimeout(idleTime);
        idleTime = setTimeout(() => {
            logoutAndRedirect(); // Call the function to logout and redirect
        }, maxIdleTime);
    }

    function logoutAndRedirect() {
        // Send an AJAX request to log out and clear the token
        fetch('{{ route("logout") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.href = "{{ route('login') }}";
            } else {
                alert('Failed to log out. Please try again.');
            }
        }).catch(error => {
            console.error('Logout failed:', error);
        });
    }

    // Detect mouse and keyboard events
    window.onload = resetIdleTimer;
    window.onmousemove = resetIdleTimer;
    window.onkeypress = resetIdleTimer;
    window.onclick = resetIdleTimer;
    window.onscroll = resetIdleTimer;

    // Optional: Warn the user before logout
    function warnUserBeforeLogout() {
        setTimeout(() => {
            // alert("You have been inactive for too long. You will be logged out soon.");
        }, maxIdleTime - 60000); // Warn 1 minute before logout
    }

    warnUserBeforeLogout();