<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Web Application</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; color: #333; }
        .container { max-width: 500px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { color: #4A90E2; font-size: 24px; margin-bottom: 20px; }
        label { font-weight: bold; display: block; margin-top: 15px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 5px; }
        input[type="submit"] { background-color: #4A90E2; color: white; border: none; padding: 12px 20px; margin-top: 20px; cursor: pointer; border-radius: 5px; width: 100%; font-size: 16px; }
        input[type="submit"]:hover { background-color: #357ABD; }
        .result-box { margin-top: 25px; padding: 15px; background-color: #eef7ee; border-left: 5px solid #52b788; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to My PHP App</h1>
    
    <!-- HTML Form sending data to the same page via POST method -->
    <form method="POST" action="">
        <label for="username">Your Name:</label>
        <input type="text" id="username" name="username" placeholder="Enter your name" required>

        <label for="fav_number">Favorite Number:</label>
        <input type="number" id="fav_number" name="fav_number" placeholder="Enter a number" required>

        <input type="submit" value="Submit Information">
    </form>

    <?php
    // Check if the form was submitted using the server request method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Collect and sanitize form inputs to prevent security vulnerabilities
        $name = htmlspecialchars($_POST['username']);
        $number = intval($_POST['fav_number']);
        
        echo "<div class='result-box'>";
        // Logic 1: Dynamic text output using data strings
        echo "<p><strong>Hello, " . $name . "!</strong> Welcome to this application.</p>";
        
        // Logic 2: Conditional statements using math
        if ($number % 2 == 0) {
            echo "<p>Your favorite number (<strong>" . $number . "</strong>) is an <strong>Even</strong> number!</p>";
        } else {
            echo "<p>Your favorite number (<strong>" . $number . "</strong>) is an <strong>Odd</strong> number!</p>";
        }
        echo "</div>";
    }
    ?>
</div>

</body>
</html>
