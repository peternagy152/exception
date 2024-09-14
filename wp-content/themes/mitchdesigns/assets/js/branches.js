let urlParamss = new URLSearchParams(window.location.search);
var current_lang = urlParamss.get('lang');
if(!current_lang){
  current_lang = 'ar';
}


// jQuery(window).scroll(function () {
//   if ($(".spinner").is(":visible")) {
//     if ($(".single_team").length) {
//       Footeroffset = jQuery(".single_team").last().offset().top;
//     }
//     winPosBtn = jQuery(window).scrollTop();
//     winH = jQuery(window).outerHeight();
//     if (winPosBtn + winH > Footeroffset + 5) {
//       get_branche_ajax("loadmore");
//       //console.log("read");
//     }
//   }
// });

      // load more on scroll and click, filter, and sort
      $posts_per_page = 20;
      $loading_more = false;
      var jqxhr_add_get_branche_ajax = { abort: function () { } };
      function get_branche_ajax(action, view = "") {
        //console.log("called get_branche_ajax");
        // jqxhr_add_get_branche_ajax.abort();
        var ajax_url = mitch_ajax_url;
        $count = $(".list_branches").attr("data-count");
        $page = $(".list_branches").attr("data-page");
        $posts = $(".list_branches").attr("data-posts");
        // $order = $(".products").attr("data-sort");
        // $model = $(".products").attr("data-model");
        // $year = $(".products").attr("data-year");
        $cat = $(".list_branches").attr("data-cat");
        // $lang = $(".products").attr("data-lang");
      
        if (($loading_more || $posts_per_page >= $posts) && action == "loadmore") {
          // console.log("khalstt " + $posts);
          return;
        }
        $loading_more = true;
        jqxhr_add_get_branche_ajax = $.ajax({
          type: "POST",
          url: ajax_url,
          data: {
            action: "get_branche_ajax",
            count: $count,
            page: $page,
            cat: $cat,
            fn_action: action,
            lang: current_lang,
          },
          success: function (posts) {
            // get_branche_ajax_count(action);
            $loading_more = false;
            if (action == "loadmore") {
              $(".list_branches").ap(posts);
              $(".list_branches").attr("data-page", parseInt($page) + 1);
              $(".spinner").attr("data-page", parseInt($page) + 1);
              //console.log($(".products").attr("data-page"));
              $posts_per_page += parseInt($count);
              $posts = $(".list_branches").attr("data-posts");
              //console.log("$posts_per_page", $posts_per_page);
              //console.log("$posts", $posts);
              if ($posts_per_page >= $posts) {
                /// Begin of get out of stock products function
                $(".spinner").hide();
              } else {
                if ($posts_per_page < $posts) {
                  $(".spinner").show();
                }
              }
            } else {
              $("#ajax_loader_branch").hide();
              $(".list_branches").html(posts);
              if (parseInt($page) % 2 == 0 && $posts_per_page < $posts) {
                $(".spinner").show();
              } else if (parseInt($page) % 2 == 1 && $posts_per_page < $posts) {
                $(".spinner").show();
              } else if ($posts_per_page >= $posts) {
                /// Begin of get out of stock products function
                $(".spinner").hide();
              }
            }
          },
        });
      }


      // var jqxhr_add_get_branche_ajax_count = { abort: function () { } };
      // function get_branche_ajax_count(view) {
      //   jqxhr_add_get_branche_ajax_count.abort();
      //   // console.log('get_branche_ajax_count');
      //   var ajax_url = mitch_ajax_url;
      //   $count = $(".list_branches").attr("data-count");
      //   $page = $(".list_branches").attr("data-page");
      //   $posts = $(".list_branches").attr("data-posts");
      //   // $order = $(".products").attr("data-sort");
      //   // $model = $(".products").attr("data-model");
      //   // $year = $(".products").attr("data-year");
      //   $cat = $(".list_branches").attr("data-cat");
      //   // $lang = $(".products").attr("data-lang");
      //   setTimeout(function () {
      //     jqxhr_add_get_branche_ajax_count = $.ajax({
      //       type: "POST",
      //       url: ajax_url,
      //       data: {
      //         action: "get_branche_ajax_count",
      //         count: $count,
      //         page: $page,
      //         // order: $order,
      //         // model: $model,
      //         // year: $year,
      //         cat: $cat,
      //       },
      //       success: function (posts) {
      //         // console.log('posts', posts);
      //         // if (20 >= parseInt(posts)) {
      //         //   $(".spinner").addClass("hide");
      //         // } else if (parseInt(posts) == 0) {
      //         //   $(".spinner").removeClass("hide");
      //         // } else {
      //         //   $(".spinner").removeClass("hide");
      //         // }
      //         $(".list_branches").attr("data-posts", posts);
      //         // $(".spinner").attr("data-posts", posts);
      //       },
      //     });
      //   });
      // }