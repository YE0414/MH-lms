<div class="learn_class-list">
  <div>
    <?php
      $id = $_GET['id'];
      $sql = "SELECT * FROM learn_table WHERE learn_num = $id";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $learn_assignment = $row['learn_assignment'];
      $learn_assignment = explode(',', $learn_assignment);
      $learn_about = $row['learn_file'];
      $learn_about = explode(',', $learn_about);
      
      foreach($learn_about as $key => $value){
        if($key == 0){
          echo "<form name='learn_upload" . $key . "' action='./module/learn_module_upload.php' method='post' enctype='multipart/form-data'>";
          echo "<input type='hidden' name='learn_upload_id' value='$id'>";
          echo "<input type='hidden' name='learn_upload_week' value='$key'>";
          echo "<div class='learn_class-menubar-toggle act'><p class='learn-class-title list03 act'><span>" . ($key + 1) . "주차</span><span class='learn-btn'><img src='../img/icon5.svg' alt='toggle'></span></p>";
          echo "<p class='learn-class-info list03 act'> <span class='learn-upload-info'>" . $learn_assignment[$key] . "</span>";
          echo "<span class='learn_upload-input-wrap'>";
          echo "<label for='learn_upload_file' class='learn_upload-upload_btn'>파일 업로드</label>";
          echo "<span class='upload_info'></span>";
          echo "<input type='file' name='learn_upload_file' id='learn_upload_file'><input type='submit' value='제출하기'></span></p></div>";
          echo "</form>";
        } else {
          echo "<form name='learn_upload" . $key . "' action='./module/learn_module_upload.php' method='post' enctype='multipart/form-data'>";
          echo "<input type='hidden' name='learn_upload_id' value='$id'>";
          echo "<input type='hidden' name='learn_upload_week' value='$key'>";
          echo "<div class='learn_class-menubar-toggle act'><p class='learn-class-title list03'><span>" . ($key + 1) . "주차</span><span class='learn-btn'><img src='../img/icon5.svg' alt='toggle'></span></p>";
          echo "<p class='learn-class-info list03'> <span class='learn-upload-info'>" . $learn_assignment[$key] . "</span>";
          echo "<span class='learn_upload-input-wrap'>";
          echo "<label for='learn_upload_file' class='learn_upload-upload_btn'>파일 업로드</label>";
          echo "<span class='upload_info'></span>";
          echo "<input type='file' name='learn_upload_file' id='learn_upload_file'><input type='submit' value='제출하기'></span></p></div>";
          echo "</form>";
        }
      }
    ?>
  </div>

  <script>
    const learn_toggle03 = document.querySelectorAll('.learn-class-title.list03');
    const learn_info03 = document.querySelectorAll('.learn-class-info.list03');
    learn_toggle03.forEach((item, index) => {
      item.addEventListener('click', () => {
        learn_toggle03.forEach((item) => {
          item.classList.remove('act');
        });
        learn_info03.forEach((item) => {
          item.classList.remove('act');
        });
        item.classList.toggle('act');
        learn_info03[index].classList.toggle('act');
      });
    });

    const learn_upload_file = document.querySelectorAll('#learn_upload_file');
    const upload_info = document.querySelectorAll('.upload_info');
    learn_upload_file.forEach((item, index) => {
      item.addEventListener('change', () => {
        upload_info[index].innerHTML = item.value;
      });
    });
  </script>

</div>