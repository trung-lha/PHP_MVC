var display = 1;

function show_hide () {
    if (display == 1){
        document.getElementById("add-form").style.display = "block";
        return display = 0;
    } else {
        document.getElementById("add-form").style.display = "none";
        return display = 1;
    }
}