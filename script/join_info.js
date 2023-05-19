// 회원가입 입력양식에 대한 유효성 검사
$(document).ready(function () {
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
  // 폼
  $("#save_frm").click(function () {

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
    if (!$("#user_email").val()) {
      alert("이메일주소를 입력해주세요");
      $("#user_email").focus();
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
