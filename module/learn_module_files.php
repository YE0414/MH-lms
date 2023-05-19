<div class="learn_class-list">
  <ul>
    <?php
      $id = $_GET['id'];
      $sql = "SELECT * FROM learn_table WHERE learn_num = $id";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $learn_about = $row['learn_file'];
      $learn_about = explode(',', $learn_about);
      
      foreach($learn_about as $key => $value){
        if($key == 0){
          echo "<li class='learn_class-menubar-toggle'>";
          echo "<p class='learn-class-title list02 act'>";
          echo "<span>" . ($key + 1) . "주차</span>";
          echo "<span class='learn-btn'>";
          echo "<img src='../img/icon5.svg' alt='toggle'>";
          echo "</span>";
          echo "</p>";
          echo "<p class='learn-class-info list02 act'>";
          echo "<a href='./files/learn/" . $value . "'>$value</a>";
          echo "</p></li>";  
        } else {
          echo "<li class='learn_class-menubar-toggle'>";
          echo "<p class='learn-class-title list02'>";
          echo "<span>" . ($key + 1) . "주차</span>";
          echo "<span class='learn-btn'><img src='../img/icon5.svg' alt='toggle'></span>";
          echo "</p>";
          echo "<p class='learn-class-info list02'>";
          echo "<a href='./files/learn/" . $value . "'>$value</a>";
          echo "</p></li>";
        }
      }
    ?>
  </ul>
  <script>
    const learn_toggle02 = document.querySelectorAll('.learn-class-title.list02');
    const learn_info02 = document.querySelectorAll('.learn-class-info.list02');

    learn_toggle02.forEach((item, index) => {
      item.addEventListener('click', () => {
        learn_toggle02.forEach((item) => {
          item.classList.remove('act');
        });
        learn_info02.forEach((item) => {
          item.classList.remove('act');
        });
        item.classList.toggle('act');
        learn_info02[index].classList.toggle('act');
      });
    });
  </script>

</div>