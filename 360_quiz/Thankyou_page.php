<?php
session_start();
if (isset($_SESSION['uni_code'])) {
  session_destroy();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thank You</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        height: 100vh;
        background: linear-gradient(135deg, #007aff, #9face6);
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .thankyou-container {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 400px;
        animation: fadeIn 0.8s ease-in-out;
      }

      .thankyou-container .checkmark {
        font-size: 60px;
        color: #4BB543;
        margin-bottom: 20px;
      }

      .thankyou-container h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 10px;
      }

      .thankyou-container p {
        font-size: 16px;
        color: #666;
        margin-bottom: 30px;
      }

      .thankyou-container a {
        text-decoration: none;
        color: white;
        background: #007aff;
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: bold;
        transition: background 0.3s ease;
      }

      .thankyou-container a:hover {
        background: #007aff;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(20px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
  </head>

  <body>

    <div class="thankyou-container">
      <div class="checkmark">✔️</div>
      <h1>Thank You!</h1>
      <p>Your submission has been received.<br>We appreciate your response.</p>
      <a href="index.php">Back to Home</a>
    </div>

  </body>

  </html>
<?php
} else {
  header("location: ./");
}
?>