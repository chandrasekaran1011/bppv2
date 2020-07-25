var interval;
$(document).on("mousemove keyup keypress", function() {
    clearTimeout(interval);
    //do any process and then call the function again
    settimeout();
});

function settimeout() {
    interval = setTimeout(function() {
        location.reload();
    }, 1200000);
}
