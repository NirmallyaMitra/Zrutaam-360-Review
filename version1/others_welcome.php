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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet" />
    <!-- =====================================END GOOGLE FONT================================= -->
  </head>

  <body>
    <div id="" class="main-container">
      <div id="" class="container">
        <strong>Privacy and Confidentiality Notice for 360-Degree Leadership
          Assessment Survey</strong>
        <p class="para-1">
          Before you begin this survey, we want to emphasize our commitment to
          your privacy and the confidentiality of your responses. Please read
          the following points carefully:
        </p>
        <p class="para-2">
          Anonymity of Responses: All responses provided in this survey will be
          treated with the utmost confidentiality. Individual responses will not
          be disclosed to anyone in a manner that reveals your identity.
        </p>
        <p class="para-3">
          Data Aggregation: For the purpose of analysis and reporting, data will
          be aggregated and only reported in summarized form. This ensures that
          no individual responses can be traced back to any participant.
        </p>
        <p class="para-4">
          Purpose of Data Collection: The demographic information collected is
          solely for the purpose of enhancing our understanding of the feedback
          across different segments of our organization. This helps us in
          identifying trends and making informed decisions for organizational
          development.
        </p>
        <p class="para-5">
          No Individual Reporting: No individual data or specific responses will
          be reported out. Our focus is on overall trends and collective
          insights that aid in the growth and development of our leadership and
          organization.
        </p>
        <p class="para-6">
          Security of Information: We have implemented appropriate security
          measures to ensure that your data is protected and stored securely.
        </p>
        <p class="para-7">
          We appreciate your participation in this survey and your contribution
          to the leadership development process in our organization. Your honest
          and thoughtful feedback is crucial for our continuous improvement.
        </p>
        <p class="para-8">
          If you have any concerns or questions regarding the privacy and
          confidentiality of your responses, please feel free to contact [insert
          appropriate contact information].
        </p>
        <p class="para-9">Thank you for your time and valuable input.</p>
      </div>
    </div>
    <a href="./others.php">NEXT</a>
  </body>

  </html>
<?php
} else {
  header("location: ./others_index.php");
}
?>