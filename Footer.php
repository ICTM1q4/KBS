<!DOCTYPE html>
<html lang="en">


<footer style="position: relative;
  left: 0px;
  bottom: 0px;
  width: 100%;
  background-color: rgba(0,0,0,0.5);
  color: white;
  text-align: center;
  height:370px;
  margin-top: 50px;
  border-top: 3px black solid;
  ">
  <div style="margin-top: 10px; padding-bottom: 0px; ">
    <div style="height: 270px;">
      <table style="color: white; margin-left: 30px; margin: auto;">
      <tr>
      <td style="padding-left: 80px; vertical-align: top; text-align: left;">
      <h1>Pagina's</h1>
      <a href="index.php"><p style="color: white; height: 10px;">-Home</p></a>
      <a href="categories.php"><p style="color: white; height: 10px;">-Categorieen</p></a>
      <a href="overons.php"><p style="color: white; height: 10px;">-Over Ons</p></a>
      <a href="contact.php"><p style="color: white; height: 10px;">-Contact</p></a>
      </td>
      <td style="padding-left: 25px; vertical-align: top; text-align: left;">
      <h1>Categorieen</h1>
      <a href="browse.php?category_id=1"><p style="color: white; height: 10px;">-Novelty Items</p></a>
      <a href="browse.php?category_id=2"><p style="color: white; height: 10px;">-Clothing</p></a>
      <a href="browse.php?category_id=4"><p style="color: white; height: 10px;">-T-shirts</p></a>
      <a href="browse.php?category_id=6"><p style="color: white; height: 10px;">-Computing Novelties</p></a>
      <a href="browse.php?category_id=7"><p style="color: white; height: 10px;">-USB Novelties</p></a>
      <a href="browse.php?category_id=9"><p style="color: white; height: 10px;">-Toys</p></a>
      </td>
      <td style="padding-left: 25px; vertical-align: top; text-align: left;">
      <h1>Account</h1>
      <?php if (isset($_SESSION['OrderID'])){?>
          <a href="Account.php"><p style="color: white; height: 10px;">-Account</p></a>
          <a href="winkelmand.php"><p style="color: white; height: 10px;">-Winkelmand</p></a>
          <a href="logout.php"><p style="color: white; height: 10px;">-Logout</p></a>
      <?php
      }
      else {
        ?>
      <a href="login.php"><p style="color: white; height: 10px;">-Login</p></a>
      
      <?php
      }
      ?>
      <td style="padding-left: 25px; vertical-align: top; text-align: left;">
      <h1>Contact</h1>
      <a href="www.twitter.com"><p style="color: white; height: 10px;">-Twitter</p></a>
      <a href="www.facebook.com"><p style="color: white; height: 10px;">-Facebook</p></a>
      
      </td>
      
      
      
      </td>
      </tr>
      </table>
      
      
    
    
    </div>
    <p style="color: gray; border-top: gray 1px solid; margin-bottom: 0px; width: 90%; margin: auto; padding-top: 5px;">NerdyGadgets™ 2020</p>
  </div>
</footer>