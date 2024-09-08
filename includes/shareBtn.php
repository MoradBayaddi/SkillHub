document.getElementById('share-button').addEventListener('click', function() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        }).then(() => {
            console.log('Thanks for sharing!');
        }).catch(console.error);
    } else {
        // Fallback for browsers that don't support the Web Share API
        const dummy = document.createElement('textarea');
        document.body.appendChild(dummy);
        dummy.value = window.location.href;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        alert('URL copied to clipboard!');
    }
});