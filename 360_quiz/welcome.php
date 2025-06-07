<?php
session_start();
if (isset($_SESSION['uni_code'])) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page 4</title>
    <!-- ================================CSS LNK================================== -->
    <link rel="stylesheet" href="./assets/CSS/welcome.css" />
    <!-- ================================CSS LNK================================== -->
    <!-- =====================================GOOGLE FONT================================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600;700;800;900&display=swap"
      rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap"
      rel="stylesheet" />
    <!-- =====================================END GOOGLE FONT================================= -->
  </head>

  <body>
    <div id="" class="main-container">
      <div id="" class="container">
        <strong>
          <center>
            <h2>Welcome Page & Privacy Notice</h2>
          </center>
        </strong>
        <p class="para-1">
          Before you begin, please review our commitment to your privacy and the confidentiality of your responses.
        </p>
        <p class="para-2">
          <strong>Privacy and Confidentiality Notice</strong><br>
          Anonymity of Responses: All feedback provided in this survey is administered by Zrutaam and is treated with the utmost confidentiality. Individual responses will not be disclosed in any way that reveals your identity.
        </p>
        <p class="para-3">
          <strong>Data Aggregation</strong><br>
          To ensure anonymity, feedback is aggregated by Zrutaam and reported only in a summarized form. This makes it impossible for individual responses to be traced back to any single participant.
        </p>
        <p class="para-4">
          <strong>Purpose of Data Collection</strong><br>
          Demographic information, if collected, is used by Zrutaam solely to enhance the understanding of feedback across different groups, helping to identify broad organizational trends.
        </p>
        <p class="para-5">
          <strong>No Individual Reporting</strong><br>
          We want to be perfectly clear: no individual data or specific, attributable responses will ever be reported by Zrutaam. The focus is entirely on collective insights.
        </p>
        <p class="para-6">
          <strong>Security of Information</strong><br>
          As the independent administrator, Zrutaam has implemented robust security measures to ensure that your data is protected and stored securely throughout this process.
        </p>
        <p class="para-7">
          We deeply appreciate your participation. If you have any questions or concerns regarding the privacy and confidentiality of your responses, please feel free to contact us directly at <strong>survey@zrutaam.com</strong>.
        </p>
        <p class="para-8">
          <strong>By clicking "Continue," you acknowledge that you have read and understood this notice.</strong>
        </p>
      </div>
      <a href="./leaders.php" style="background-color: #007aff; border-radius: 5px; padding: 15px; color: #fff; text-decoration: none; font-weight:bold; ">Continue</a>
    </div>

  </body>

  </html>
<?php
} else {
  header("location: ./");
}
?>