<div class="learn_class-list act">
  <ul>
    <?php
      $id = $_GET['id'];
      $sql = "SELECT * FROM learn_table WHERE learn_num = $id";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $learn_about = $row['learn_about'];
      $learn_about = explode(',', $learn_about);
      
      foreach($learn_about as $key => $value){
        if($key == 0){
          echo "<li class='learn_class-menubar-toggle'>";
          echo "<p class='learn-class-title list01 act'>";
          echo "<span>" . ($key + 1) . "주차</span>";
          echo "<span class='learn-btn'><img src='../img/icon5.svg' alt='toggle'></span>";
          echo "</p>";
          echo "<div class='learn-class-info list01 act'> ";
          echo "<video src='./img/sample.mp4' class='learn-class-videos'></video>";
          echo "<p class='video-progress'><span class='video-progressbar'></span></p>";
          echo "<ul class='learn-class-video_ctrl-wrap'>";
          echo "<li class='btn01'><i class='fa-solid fa-play'></i></li>";
          echo "<li class='btn02'><i class='fa-solid fa-pause'></i></li>";
          echo "<li class='btn03'><i class='fa-solid fa-stop'></i></li>";
          echo "<li class='btn04'>1X</li>";
          echo "<li class='btn05'>2X</li>";
          echo "</ul>";
          echo $learn_about[$key] . "</div>";
          echo "</li>";
          } else {
          echo "<li class='learn_class-menubar-toggle'>";
          echo "<p class='learn-class-title list01'>";
          echo "<span>" . ($key + 1) . "주차</span>";
          echo "<span class='learn-btn'><img src='../img/icon5.svg' alt='toggle'></span>";
          echo "</p>";
          echo "<div class='learn-class-info list01'> ";
          echo "<video src='./img/sample.mp4' class='learn-class-videos'></video>";
          echo "<p class='video-progress'><span class='video-progressbar'></span></p>";
          echo "<ul class='learn-class-video_ctrl-wrap'>";
          echo "<li class='btn01'><i class='fa-solid fa-play'></i></li>";
          echo "<li class='btn02'><i class='fa-solid fa-pause'></i></li>";
          echo "<li class='btn03'><i class='fa-solid fa-stop'></i></li>";
          echo "<li class='btn04'>1X</li>";
          echo "<li class='btn05'>2X</li>";
          echo "</ul>";
          echo $learn_about[$key] . "</div>";
          echo "</li>";
        }
      }
    ?>
  </ul>
  <script>
    const learn_toggle = document.querySelectorAll('.learn-class-title.list01');
    const learn_info = document.querySelectorAll('.learn-class-info.list01');

    learn_toggle.forEach((item, index) => {
      item.addEventListener('click', () => {
        learn_toggle.forEach((item) => {
          item.classList.remove('act');
        });
        learn_info.forEach((item) => {
          item.classList.remove('act');
        });
        item.classList.toggle('act');
        learn_info[index].classList.toggle('act');
      });
    });

    const learn_video = document.querySelectorAll('.learn-class-videos');
    const learn_video_ctrl = document.querySelectorAll('.learn-class-video_ctrl-wrap');
    const progressbar = document.querySelectorAll('.video-progressbar');


    for(let i=0; i<learn_video.length; i++){
      learn_video[i].addEventListener('timeupdate', () => {
        let progress = learn_video[i].currentTime / learn_video[i].duration;
        progressbar[i].style.width = progress * 100 + '%';
      });
      learn_video_ctrl[i].children[0].addEventListener('click', () => {
        learn_video[i].play();
      });
      learn_video_ctrl[i].children[1].addEventListener('click', () => {
        learn_video[i].pause();
      });
      learn_video_ctrl[i].children[2].addEventListener('click', () => {
        learn_video[i].pause();
        learn_video[i].currentTime = 0;
      });
      learn_video_ctrl[i].children[3].addEventListener('click', () => {
        learn_video[i].playbackRate = 1;
      });
      learn_video_ctrl[i].children[4].addEventListener('click', () => {
        learn_video[i].playbackRate = 2;
      });
    }


  </script>
</div>