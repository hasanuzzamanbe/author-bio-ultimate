jQuery(document).ready(function(){
    jQuery(".authbiotablinks").click(function openCity(evt) {
        let i, tabcontent, authbiotablinks;
        let tabname = jQuery(this).data('tab_name');
        tabcontent = document.getElementsByClassName("auth_bio_tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        authbiotablinks = document.getElementsByClassName("authbiotablinks");
        for (i = 0; i < authbiotablinks.length; i++) {
            authbiotablinks[i].className = authbiotablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabname).style.display = "block";
        evt.currentTarget.className += " active";
    })
});
