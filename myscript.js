var x = 3;
var n_quest = 1;
$(document).ready(function(){
  $(".question").hide();
  $(`#question${n_quest}`).show();

  var max_question = $(".question").length;
  if (n_quest == max_question) {
    $("#submit").show();
    $("#nextquestion").hide();
  } else {
    $("#submit").hide();
    $("#nextquestion").show();
  }
  if (n_quest == 1) {
    $("#prevquestion").hide();
  } else {
    $("#prevquestion").show();
  }

  $(document).click(function() {

    if (n_quest == max_question) {
      $("#submit").show();
      $("#nextquestion").hide();
    } else {
      $("#submit").hide();
      $("#nextquestion").show();
    }
    if (n_quest == 1) {
      $("#prevquestion").hide();
    } else {
      $("#prevquestion").show();
    }

  });

  $("#more").click(function() {
    if (x <= 6) {
      var txt1 = `<div id="answer${x}"><div class="form-group" style="margin-top: 30px"><label for="answer[${x}]">Answer ${x}</label><textarea class="form-control" type="text" name="answer[${x}]" value="" rows="2"></textarea></div><div class="form-check"><input class="form-check-input" name="check[${x}]" type="checkbox" value="" id="flexCheckDefault"><label class="form-check-label" for="flexCheckDefault">Correct answer</label></div></div>`;
      $("#answers").append(txt1);
      x+=1;
    } else {
      $("#more").after("<p>You can submit 8 answers maximum.</p>")
    }
  });

  $("#less").click(function() {
    if (x >= 4) {
      x-=1;
      $(`#answer${x}`).remove();
    };
  });

  $(".question-box").click(function() {
    n_quest = parseInt($(this).attr('name'));
    $(".question").hide();
    $(`#question${n_quest}`).show();
  });

  $("#nextquestion").click(function() {
    $(`#question${n_quest}`).hide();
    n_quest += 1;
    $(`#question${n_quest}`).show();
  });
  
  $("#prevquestion").click(function() {
    $(`#question${n_quest}`).hide();
    n_quest -= 1;
    $(`#question${n_quest}`).show();
  });

  $(".mark").click(function() {
    var button_n = $(this).attr("name");
    var icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16"><path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path></svg>'
    if ($(this).attr("value") == "unflagged") {
      $(`#button${button_n}`).css("background", "#6da4d1");
      $(this).html(icon + "Unflag this question");
      $(this).val("flagged");
    } else {
      $(`#button${button_n}`).css("background", "rgb(239, 239, 239)");
      $(this).html(icon + "Flag this question");
      $(this).val("unflagged");
    }
  });

  if (typeof correct !== 'undefined') {
    $.each(correct, function (index, item) {
      var items = $.map(item, function(value, index) {
        return [value];
      });
      if (items.every(item => item != 2)) {
        $(`#button${index}`).css("background", "#ff7d7d");
      } else if (items.every(item => item == 2)) {
        $(`#button${index}`).css("background", "#b8ffb0");        
      } else {
        $(`#button${index}`).css("background", "#ffc559");
      }
      $.each(item, function (index, item) {
        if (item == 0) {
          $(`#answer${index}`).css("background", "#ff7d7d");
        } else if (item == 1) {
          $(`#answer${index}`).css("background", "#b8ffb0");
        } else if (item == 2) {
          $(`#answer${index}`).css("background", "#b8ffb0");
        }
      });
    });
    $.each(correct, function (index, item) {
      $.each(item, function (index, item) {
        $(`#answer${item}`).css("background", "green");
      });
    });
  }

  $("#save").click(function() {
    $.ajax({
      type: "POST",
      url: "review.php",
      data: "save=1",
      success: function () {
        $("#success").hide();
        $("#save").after("<p id='success' class='text-muted m-0'>Questionnaire saved to your profile.");
      },
      error: function () {
        alert("Questionnaire could not be saved.");
      }
    });
  });
});