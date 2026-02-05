function initPageTransitions() {
    function showPage() {
        document.body.classList.remove('page-hidden');
    }
    // Ensure page is shown immediately
    showPage();
    document.addEventListener('DOMContentLoaded', showPage);
    window.addEventListener('pageshow', showPage);
    window.addEventListener('load', showPage);
    window.addEventListener('popstate', showPage);
    Array.from(document.querySelectorAll('.transition-link')).forEach(function(el){
        el.addEventListener('click', function(e){
            var href = el.getAttribute('href');
            if (!href) return;
            e.preventDefault();
            document.body.classList.add('page-hidden');
            setTimeout(function(){ window.location.href = href; }, 220);
        });
    });
}