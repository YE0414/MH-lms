// 회원가입 입력양식에 대한 유효성 검사
$(document).ready(function () {
  $("#user_id").blur(function () {
    let reg = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;
    let txt = $("#user_id").val();
    if ($(this).val() == "") {
      // console.log(txt);
      $("#id_check_msg")
        .html("아이디를 입력해주세요.")
        .css("color", "#f00")
        .attr("data-check", "0");
    } else if (!reg.test(txt)) {
      // console.log(txt);
      $("#id_check_msg")
        .html("영어, 숫자 포함 6자리이상 입력해주세요.")
        .css("color", "#f00")
        .attr("data-check", "0");
    } else {
      checkIdAjax();
    }
  });

  $("#user_info").blur(function () {
    if ($(this).val() == "") {
      $("#info_check_msg")
        .html("학번을 입력해주세요.")
        .css("color", "#f00")
        .attr("data-check", "0");
    } else {
      checkInfoAjax();
    }
  });
  //비밀번호 확인
  $("#user_password").blur(function () {
    let reg = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/;
    let txt = $("#user_password").val();
    if ($(this).val() == "") {
      // console.log('비밀번호체크1');
      $("#pass_check_msg")
        .html("비밀번호를 입력해주세요.")
        .css("color", "#f00")
        .attr("data-check", "0");
    } else if (!reg.test(txt)) {
      console.log(txt);
      $("#pass_check_msg")
        .html("대문자, 소문자, 숫자, 특수문자 포함 8자리이상 입력해주세요.")
        .css("color", "#f00")
        .attr("data-check", "0");
    } else {
      // console.log('비밀번호체크3');
      // console.log(txt+"3번체크");
      $("#pass_check_msg")
        .html("&nbsp;")
        .css("color", "#f00")
        .attr("data-check", "1");
    }
  });

  // id값을 post로 전송하여 서버와 통신을 통해 중복결과 json형태로 받아오기 위한 함수
  function checkIdAjax() {
    $.ajax({
      async: false,
      url: "./ajax/check_id.php",
      type: "post",
      dataType: "JSON",
      data: {
        user_id: $("#user_id").val(),
        user_info: $("#user_info").val(),
      },
      success: function (data) {
        let i_len = $("#user_id").val().length;
        if (data.check) {
          if (i_len < 6) {
            console.log(i_len);
            $("#id_check_msg")
              .html("아이디는 여섯자리 이상이어야합니다.")
              .css("color", "#f00")
              .attr("data-check", "0");
          } else {
            $("#id_check_msg")
              .html("사용 가능한 아이디입니다.")
              .css("color", "#00f")
              .attr("data-check", "1");
          }
        } else {
          $("#id_check_msg")
            .html("중복된 아이디입니다.")
            .css("color", "#f00")
            .attr("data-check", "0");
        }
      },
    });
  }

  function checkInfoAjax() {
    $.ajax({
      async: false,
      url: "./ajax/check_c_num.php",
      type: "post",
      dataType: "JSON",
      data: {
        user_info: $("#user_info").val(),
      },
      success: function (data) {
        let info_len = $("#user_info").val().length;
        if (data.check) {
          if (info_len != 6) {
            $("#info_check_msg")
              .html("학번은 여섯자리입니다.")
              .css("color", "#f00")
              .attr("data-check", "0");
          } else {
            $("#info_check_msg")
              .html("OK")
              .css("color", "#00f")
              .attr("data-check", "1");
          }
        } else {
          $("#info_check_msg")
            .html("이미 등록된 학번입니다.")
            .css("color", "#f00")
            .attr("data-check", "0");
        }
      },
    });
  }
  // 체크박스 스크립트
  // 전체 동의 클릭시 모두 체크
  $("#j-form_agreeall").click(function () {
    let checked = $(this).is(":checked");
    if (checked) {
      $("#join_agree01").prop("checked", true);
      $("#join_agree02").prop("checked", true);
    } else {
      $("#join_agree01").prop("checked", false);
      $("#join_agree02").prop("checked", false);
    }
  });
  //체크박스, 연락처 미체크시 안넘어가게고치기
  // 미체크된게 있으면 전체동의 해제되고 모두 체크되면 전체동의도 체크
  $(".join_agree").click(function () {
    let checked = $(this).is(":checked");
    if (!checked) {
      $("#j-form_agreeall").prop("checked", false);
    } else {
      $("#j-form_agreeall").prop("checked", true);
    }
  });
  //체크박스 체크된 갯수 확인해서 전체동의 체크/해제
  $(".join_agree").click(function () {
    let total = $(".join_agree").length; //전체 체크박스수
    let checked = $(".join_agree-label:checked").length; //체크된 체크박스 수
    //
    if (total != checked) {
      // console.log(total);
      // console.log(checked);
      $("#j-form_agreeall").prop("checked", false);
    } else {
      $("#j-form_agreeall").prop("checked", true);
    }
  });
  // 폼
  $("#save_frm").click(function () {
    let checked = $("#j-form_agreeall").is(":checked");
    if (!checked) {
      console.log("체크안됨.");
      alert("약관에 동의해주세요.");
      $("#user_id").focus();
      return false;
    }

    if (!$("#user_id").val()) {
      //아이디값을 입력하지 않은 경우
      alert("아이디를 입력해주세요");
      $("#user_id").focus(); //초점을 아이디 입력박스에 만든다
      return false;
    }

    if ($("#id_check_msg").attr("data-check") != "1") {
      alert("아이디를 확인해주세요");
      $("#id").focus();
      return false;
    }

    if (!$("#user_password").val()) {
      alert("비밀번호를 입력해주세요");
      $("#user_password").focus();
      return false;
    }

    if ($("#user_password").val() != $("#user_password2").val()) {
      alert("비밀번호가 일치하지 않습니다.");
      $("#user_password2").focus();
      return false;
    }

    if ($("#pass_check_msg").attr("data-check") != "1") {
      $("#user_password").focus();
      return false;
    }

    if (!$("#user_password2").val()) {
      alert("비밀번호를 확인해주세요");
      $("#user_password2").focus();
      return false;
    }

    if (!$("#user_name").val()) {
      alert("이름을 입력해주세요");
      $("#user_name").focus();
      return false;
    }

    if (!$("#user_info").val()) {
      alert("학번을 입력해주세요");
      $("#user_info").focus();
      return false;
    }
    if ($("#info_check_msg").attr("data-check") != "1") {
      alert("학번을 확인해주세요  .");
      $("#user_info").focus();
      return false;
    }
    if (!$("#user_email").val()) {
      alert("이메일주소를 입력해주세요");
      $("#user_email").focus();
      return false;
    }

    if (!$("#user_phone").val()) {
      alert("연락처를 입력해주세요");
      $("#phone").focus();
      return false;
    }
    if (f.mb_email.value.length > 0) {
      // 이메일 형식 검사
      var regExp =
        /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/;
      if (f.mb_email.value.match(regExp) == null) {
        alert("이메일 주소가 형식에 맞지 않습니다.");
        f.mb_email.focus();
        return false;
      }
    }


    // return false;
    $("#member_form").submit();
  });
});
