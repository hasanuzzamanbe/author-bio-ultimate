jQuery(document).ready(function(){
    jQuery(".tablinks").click(function openCity(evt) {
            var i, tabcontent, tablinks;
            var tabname = jQuery(this).data('tab_name');
            tabcontent = document.getElementsByClassName("auth_bio_tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabname).style.display = "block";
            evt.currentTarget.className += " active";
        })
});
