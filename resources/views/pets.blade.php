<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petstore API</title>
</head>
<body>
    <h1>Petstore API</h1>
    <form id="addPetForm">
        <input type="text" id="name" name="name" placeholder="Name" required>
        <input type="text" id="status" name="status" placeholder="Status" required>
        <button type="submit">Add Pet</button>
    </form>

    <script>
        document.getElementById('addPetForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const status = document.getElementById('status').value;

            fetch('/pets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ name, status }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
