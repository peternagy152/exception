$(document).ready(function () {
    // Menu-Step && All-Step when click Next & Prev
        const nextButton = $("#nextButton");
        const prevButton = $("#prevButton");

        nextButton.click(function() {
            // All step Change Class active When click next
            const currentActiveStep = $(".step.active");
            const nextActiveStep = currentActiveStep.next(".step");

            // All Menu Step Change Class Done And Select When click next
            const currentActiveMenu = $(".single_step.select");
            const nextActiveMenu = currentActiveMenu.next(".single_step");

            if (nextActiveStep.length) {
                //Change class and remove class in All Step
                currentActiveStep.removeClass("active");
                nextActiveStep.addClass("active");

                //Change class and remove class in Menu Step
                currentActiveMenu.removeClass("select")
                currentActiveMenu.addClass("done")
                nextActiveMenu.addClass("select")
            }
            $(".btn_prev").removeClass("hidden_prev");

            if (nextActiveStep.attr("id") === "section7") {
                $(".btn_next_pop").addClass("show");
                $(".btn_next").addClass("hide");
            }
        });

        prevButton.click(function() {
            // All step Change Class active When click prev
            const currentActiveStep = $(".step.active");
            const prevActiveStep = currentActiveStep.prev(".step");

            // All Menu Step Change Class Done And Select When click prev
            const currentActiveMenu = $(".single_step.select");
            const prevActiveMenu = currentActiveMenu.prev(".single_step");

            if (prevActiveStep.length) {
                //Change class and remove class in All Step
                currentActiveStep.removeClass("active");
                prevActiveStep.addClass("active");

                //Change class and remove class in Menu Step
                currentActiveMenu.removeClass("select")
                currentActiveMenu.removeClass("done")
                prevActiveMenu.removeClass("done")
                prevActiveMenu.addClass("select")

                $(".btn_next").removeClass("hidden_next");
                if (prevActiveStep.attr("id") === "section2") {
                    $(".spriteContainer").removeClass('white black black-white');
                    $("#section3 select").prop('selectedIndex', 0);
                }
                if (prevActiveStep.attr("id") === "section4") {
                    $("#section5 select").prop('selectedIndex', 0);
                    $(".spriteContainer").removeClass(function(index, className) {
                        return className.split(' ').filter(function(c) {
                          return c.startsWith('c-');
                        }).join(' ');
                      });
                      $(".spriteContainer").removeClass(function(index, className) {
                        return className.split(' ').filter(function(c) {
                          return c.startsWith('t-');
                        }).join(' ');
                      });
                    
                }
            }
            
            
            if (prevActiveStep.is(":first-child")) {
                $(".btn_prev").addClass("hidden_prev");
            } else {
                $(".btn_prev").removeClass("hidden_prev");
            }

            if (prevActiveStep.attr("id") === "section6") {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
            }
        });

        // When chage step from Menu-Step
        $(document).on('click', '.single_step.done', function() {
            // Remove 'done' class from all next elements
            $(this).removeClass("done");
            $(this).nextAll(".single_step").removeClass("done");
            $(this).nextAll(".single_step").removeClass("select");
                      
            // Add 'select' class to the clicked element
            $(this).addClass("select");
            
            // Get the index of the clicked menu step
            const index = $(".single_step").index(this);
            
            // Remove 'active' class from all sections
            $(".step").removeClass("active");
            
            // Add 'active' class to the corresponding section based on the index
            $(".step").eq(index).addClass("active");

            // Check index 
            if (index === 0) {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
                $(".btn_prev").addClass("hidden_prev");
            }
            if (index === 1) {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
                $(".spriteContainer").removeClass('white black black-white');
                $(".spriteContainer").removeClass(function(index, className) {
                    return className.split(' ').filter(function(c) {
                      return c.startsWith('c-');
                    }).join(' ');
                  });
                  $(".spriteContainer").removeClass(function(index, className) {
                    return className.split(' ').filter(function(c) {
                      return c.startsWith('t-');
                    }).join(' ');
                  });
                  $("#section3 select").prop('selectedIndex', 0);
            }
            if (index === 2) {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
                $(".spriteContainer").removeClass(function(index, className) {
                    return className.split(' ').filter(function(c) {
                      return c.startsWith('c-');
                    }).join(' ');
                });
                $(".spriteContainer").removeClass(function(index, className) {
                return className.split(' ').filter(function(c) {
                    return c.startsWith('t-');
                }).join(' ');
                });
            }
            if (index === 3) {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
                $(".spriteContainer").removeClass(function(index, className) {
                    return className.split(' ').filter(function(c) {
                      return c.startsWith('c-');
                    }).join(' ');
                });
                $(".spriteContainer").removeClass(function(index, className) {
                return className.split(' ').filter(function(c) {
                    return c.startsWith('t-');
                }).join(' ');
                });
            }
            if (index === 4) {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
            }
            if (index === 5) {
                $(".btn_next_pop").removeClass("show");
                $(".btn_next").removeClass("hide");
            }
        });


    //Step-One
    $(document).on('click', '.shape_option .s_option .option', function() {
        $('.shape_option .s_option .option').removeClass('active');
        $(this).addClass('active'); /* remove the active class of all .image-info divs */
        // $('.btn_next').removeClass('hidden_next');
    });

    // pop sselect four icons only
    $(document).on('click', '.popup.cutouts .section_content .min_widget', function() {
        var $activeWidgets = $('.popup.cutouts .section_content .min_widget.active');
    
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(' .min_widget').removeClass('disable');
        } else {
            $(this).addClass("active");
            if ($activeWidgets.length === 3) {
                $('.min_widget:not(.active)').addClass('disable');
            }
        }
    });


    //Step-six
    $(document).on('click', '.write_text .s_option', function() {
        $('.write_text .s_option').removeClass('active');
        $(this).addClass('active'); /* remove the active class of all .image-info divs */
        // $('.btn_next').removeClass('hidden_next');
    });
    $(document).ready(function() {
        $('#addtext').on('click', function() {
            var targetElement = $('.more_text'); // The element you want to add the class to
    
            if ($(this).prop('checked')) {
                targetElement.addClass('active');
            } else {
                targetElement.removeClass('active');
            }
        });
    });

    //Step-seven
        // $('#calendar').datepicker({
        //     inline:true,
        //     firstDay: 1,
        //     showOtherMonths:true,
        //     dayNamesMin:['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
        // });
      

});

// choose color or toping
document.addEventListener('DOMContentLoaded', function() {
    const f_option1 = document.getElementById('f_option1');
    const f_option2 = document.getElementById('f_option2');
    const c_option1 = document.getElementById('c_option1');
    const c_option2 = document.getElementById('c_option2');

    f_option1.addEventListener('click', function() {
        f_option1.classList.add("active")
        f_option2.classList.remove("active")
        c_option1.classList.add("active")
        c_option2.classList.remove("active")
        $(".spriteContainer").removeClass(function(index, className) {
        return className.split(' ').filter(function(c) {
            return c.startsWith('t-');
        }).join(' ');
        });
        $("#c_option1 input[type='radio']").prop('checked', false);
    });

    f_option2.addEventListener('click', function() {
        f_option1.classList.remove("active")
        f_option2.classList.add("active")
        c_option1.classList.remove("active");
        c_option2.classList.add("active");
        $(".spriteContainer").removeClass(function(index, className) {
            return className.split(' ').filter(function(c) {
              return c.startsWith('c-');
            }).join(' ');
        });
        $("#c_option2 select").prop('selectedIndex', 0);
        
    });
});
