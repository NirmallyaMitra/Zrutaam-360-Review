<?php
  session_start();
  if(isset($_SESSION['uni_code'])){

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page 3</title>
    <!-- ================================CSS LNK================================== -->
    <link rel="stylesheet" href="./assets/CSS/email_list.css" />
    <!-- ================================CSS LNK================================== -->
    <!-- =====================================GOOGLE FONT================================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap"
      rel="stylesheet"
    />
    <!-- =====================================END GOOGLE FONT================================= -->
  </head>
  <body>
    <div id="" class="main-container">
      <form action="./database/add_emails.php?id=<?php echo $_SESSION['uni_code']?>" method="POST">
        <div id="" class="container">
          <div id="" class="email-div"><h1 id="" class="email">EMAIL</h1></div>
          <label for="mail1" class="label-font change">MANAGER 1</label>
          <input type="text" name="email1" id="" class="text1 txt" required/>
          <label for="email2" class="label-font change">SUB ORDINATE 1</label>
          <input type="text" name="email2" id="" class="text2 txt" required/>
          <label for="email3" class="label-font change">SUB ORDINATE 2</label>
          <input type="text" name="email3" id="" class="text3 txt" required/>
          <label for="email4" class="label-font change">SUB ORDINATE 3</label>
          <input type="text" name="email4" id="" class="text4 txt" required/>
          <label for="email5" class="label-font change">TEAM MATE 1</label>
          <input type="text" name="email5" id="" class="text5 txt" required/>
          <label for="email6" class="label-font change">TEAM MATE 2</label>
          <input type="text" name="email6" id="" class="text6 txt" required/>
          <label for="email7" class="label-font change">TEAM MATE 3</label>
          <input type="text" name="email7" id="" class="text7 txt" required/>
          <input type="submit" name="submit_email" style="background-color: #ff9800; color:white; height:40px; border:none;"/> 
        </div>
      </form>
    </div>
  </body>
</html>
<?php
  }
?>