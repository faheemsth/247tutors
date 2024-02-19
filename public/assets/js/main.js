$(function () {
    $(".card-center").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    infinite: true,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    autoplay: true,
                    arrows: false,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    arrows: false,
                },
            },
        ],
    });

    // signup form

    var form_count = 1;
    var total_forms = $("fieldset").length;

    // Hide all fieldsets except the first one
    $("fieldset:not(:first)").hide();

    // Function to set the progress bar
    function setProgressBar(curStep) {
        var percent = ((curStep - 1) / (total_forms - 1)) * 100;
        $(".progress-bar")
            .css("width", percent + "%")
            .html(percent.toFixed(0) + "%");
    }

    // Function to show the next step and hide the current step
    function showNextStep() {
        var currentFieldset = $("fieldset:visible");
        var nextFieldset = currentFieldset.next("fieldset");

        if (nextFieldset.length > 0) {
            currentFieldset.hide();
            nextFieldset.show();
            form_count++;
            setProgressBar(form_count);
        }
    }

    // Function to show the previous step and hide the current step
    function showPreviousStep() {
        var currentFieldset = $("fieldset:visible");
        var previousFieldset = currentFieldset.prev("fieldset");

        if (previousFieldset.length > 0) {
            currentFieldset.hide();
            previousFieldset.show();
            form_count--;
            setProgressBar(form_count);
        }
    }

    function nameValidation() {
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var error_found = false;

        if (fname.trim() == "") {
            $(".fname-error").removeClass("d-none");
            error_found = true;
        }

        if (lname.trim() == "") {
            $(".lname-error").removeClass("d-none");
            error_found = true;
        }

        if (error_found) {
            return false;
        }

        return true;
    }

    function contactValidation() {
        var phone = $(".phone-signup").val();
        var email = $(".email-signup").val();
        var error_found = false;

        if (phone.trim() == "") {
            $(".phone-error").removeClass("d-none");
            error_found = true;
        }

        if (email == "") {
            $(".email-signup-error").removeClass("d-none");
            error_found = true;
        }

        if (error_found) {
            return false;
        }

        return true;
    }


    

    // Handle the "Next" button click
    $(".next").click(function () {
        // validate firstname and lastname
        // if (form_count == 2) {
        //     nameValidation();
        // }

        // if (form_count == 3) {
        //     contactValidation();
        // }

        if(form_count == 4){
            var subject_id = $(this).attr('data-subject-id');
            $(".subject-id").val(subject_id);
        }

        showNextStep();
    });

    // Handle the "Previous" button click
    $(".previous").click(function () {
        showPreviousStep();
    });

    // Handle the "Submit" button click (you can adjust this as needed)
    $(".submit").click(function () {
        // You can add your form submission logic here
        alert("Form submitted!");
    });

    $(".input-phone").intlInputPhone();

    ////////////////////////////////////Login////////////////////////////////
    $("#email").on("click", function () {
        $(".email-error").addClass("d-none");
    });

    $("#password").on("click", function () {
        $(".password-error").addClass("d-none");
    });

    $(".login-with-password").on("click", function () {
        var email = $("#email").val();

        if (email.trim() == "") {
            $(".email-error").removeClass("d-none");
            return false;
        }
        $(".password-data").removeClass("d-none");

        $(this).addClass("d-none");
        $(".login-btn").removeClass("d-none");
        return false;
    });

    $(".login-btn").on("click", function () {
        var password = $("#password").val();
        if (password.trim() == "") {
            $(".password-error").removeClass("d-none");
            return false;
        }

        return true;
    });
    ////////////////////////////////////Login End////////////////////////////////

    $(".user-role").on("click", function () {
        var role_id = $(this).attr("data-role-id");
        $(".role_id").val(role_id);
    });
});
