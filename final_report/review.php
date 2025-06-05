<?php

include '../version1/database/connection.php';

$stmt = $conn->prepare("SELECT * FROM comments Where unique_code = ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <p>GIVE AN EXAMPLE OF A SPECIFIC BEHAVIOR THAT THIS PERSON IS EFFECTIVE IN.</p>
  <p>Very effective in communicational and interpersonal relationships</p>

  <ol>
    <?php
    while ($row = $result->fetch_assoc()) {
    ?>
      <li><?php echo $row['comment'] ?></li>
    <?php
    }
    ?>
  </ol>
</body>

</html>