// Search Image by ID
document.getElementById('searchButton').addEventListener('click', function () {
    const id = document.getElementById('searchImageID').value;

    if (id) {
        fetch('image_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'search', id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Ensure the Base64 image is displayed correctly
                if (data.photo) {
                    // Dynamically set the MIME type for the image
                    let mimeType = 'image/jpeg'; // Default to JPEG
                    if (data.photoType === 'image/png') mimeType = 'image/png';
                    if (data.photoType === 'image/gif') mimeType = 'image/gif';

                    const img = document.createElement('img');
                    img.src = `data:${mimeType};base64,${data.photo}`;
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = '100%';
                    img.alt = 'Fetched Image';

                    // Clear the container and append the new image
                    const imageContainer = document.getElementById('imageContainer');
                    imageContainer.innerHTML = ''; // Clear any existing content
                    imageContainer.appendChild(img);
                } else {
                    document.getElementById('imageContainer').innerHTML = 'No image data available.';
                }

                // Populate the details
                document.getElementById('photonameresult').value = data.name || '';
                document.getElementById('photodateresult').value = data.date || '';
                document.getElementById('photoidresult').value = data.photo_id || '';
                document.getElementById('photouseridresult').value = data.session_id || '';
            }
        })
        .catch(error => console.error('Error fetching the image:', error));
    } else {
        alert('Please enter an ID.');
    }
});

// Delete Image by ID
document.getElementById('deleteButton').addEventListener('click', function () {
    const id = document.getElementById('photoidtodelete').value;

    if (id) {
        fetch('image_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'delete', id })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success || data.error);
            if (!data.error) {
                // Clear the displayed image and details
                document.getElementById('imageContainer').innerHTML = 'Image will appear here...';
                document.getElementById('photonameresult').value = '';
                document.getElementById('photodateresult').value = '';
                document.getElementById('photoidresult').value = '';
                document.getElementById('photouseridresult').value = '';
            }
        });
    } else {
        alert('Please enter an ID to delete.');
    }
});