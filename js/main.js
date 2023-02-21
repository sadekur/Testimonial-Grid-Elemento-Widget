$(".card").hover(
  function () {
    $(this).siblings(".card").addClass("card-blur");
  },
  $(".card").hover(function () {
    $(this).siblings(".card").removeClass("card-blur");
  })
);
