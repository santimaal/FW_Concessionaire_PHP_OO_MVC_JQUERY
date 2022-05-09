function changeLang(lang) {
    lang = lang || localStorage.getItem('app-lang') || 'en';
    localStorage.setItem('app-lang', lang);
    var elmnts = document.querySelectorAll('[data-tr]');

    $.ajax({
        url: 'view/js/lang/' + lang + '.json',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                for (var i = 0; i < elmnts.length; i++) {
                    elmnts[i].innerHTML = data.hasOwnProperty(lang) ? data[lang][elmnts[i].dataset.tr] : elmnts[i].dataset.tr;
                }
            }
    })
}

$(document).ready(function() {
    changeLang();
    $("#btn-es").on("click", function() {
        changeLang('es')
        });
    $("#en").on("click", function() {
        changeLang('en')
        });
    $("#btn-val").on("click", function() {
        changeLang('val')
        });
});
