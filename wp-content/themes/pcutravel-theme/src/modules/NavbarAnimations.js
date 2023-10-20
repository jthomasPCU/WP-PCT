import e from 'jquery';

class NavScroll {
    constructor() {
        this.events();
    }

    events() {
        function is_page($pageid) {
            if (jQuery('body').hasClass('page-id-'+$pageid)) { return true; } else { return false; }
        }

        // window.onscroll = this.scrolled;
        document.querySelector(".navbar-toggler").addEventListener("click", this.navbarClicked);

    	// Pages IDs have no hero images: 12, 15, 19, 90, 100 
	    if (!is_page(12) && !is_page(15) && !is_page(19) && !is_page(90) && !is_page(100)) {

                document.getElementById("topbar").classList.add("fixed-top");
                window.onscroll = this.scrolled;
            } else {
                const o = document.getElementById("header");
                const navUL = document.getElementById("menu-primary-top");
                const navLink = document.querySelectorAll(".nav-link");
                const navbar = document.getElementById("navbar");
                
                o.style.backgroundColor = "#ffffff";
                o.classList.add('white--no-hero');
                document.getElementById("logo").src = "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg";
                navLink.forEach(element => element.style.color = "#42414b");
                navUL.classList.add('white-link');
                navbar.classList.add('navbar-light');
                navbar.classList.remove('navbar-dark');
            }
    }

    // Methods
    scrolled() {
        const o = document.getElementById("header");
        const navUL = document.getElementById("menu-primary-top");
        const navLink = document.querySelectorAll(".nav-link");
        const navbar = document.getElementById("navbar");
        const topbar = document.getElementById("topbar");
        
        // Scroll up to the top
        if (document.body.scrollTop == 0 || document.documentElement.scrollTop == 0) {
            topbar.classList.remove('white');
        }        

        // Scroll Down
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            o.style.backgroundColor = "#ffffff";
            o.classList.add('white');
            document.getElementById("logo").src = "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg";
            navLink.forEach(element => element.style.color = "#42414b");
            navUL.classList.add('white-link');
            navbar.classList.add('navbar-light');
            navbar.classList.remove('navbar-dark');

        // Scroll up to the top
        } else {
            o.style.backgroundColor = "transparent"; 
            o.classList.remove('white');
            document.getElementById("logo").src = "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-white.svg";
            document.getElementById("logo").style.display = "inline"; 
            navLink.forEach(element => element.style.color = "#ffffff80");
            navUL.classList.remove('white-link');
            navbar.classList.add('navbar-dark');
            navbar.classList.remove('navbar-light');
        } 
    };

    navbarClicked () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            window.setTimeout(function() {
                e(".navbar-toggler").hasClass("collapsed") ? 
                    ( 
                        e("#topbar").removeClass("white")
                    ) 
                    : 
                    ( e("#topbar").addClass("white"), 
                    e("#topbar").height(document.getElementById('header').offsetHeight +
                    document.getElementById('menu-primary-top').offsetHeight),
                    
                    e("#logo").attr("src", "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg")  
            )}, 100); 
        } else {
            window.setTimeout(function() {
                e(".navbar-toggler").hasClass("collapsed") ? 
                ( 
                    e("#logo").attr("src", "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-white.svg"),
                    e("#topbar").removeClass("white")
                ) 
                : 
                ( e("#topbar").addClass("white"), 
                e("#topbar").height(document.getElementById('header').offsetHeight +
                document.getElementById('menu-primary-top').offsetHeight),
                e("#logo").attr("src", "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg")  
            )}, 100); 
        }
    }
}

export default NavScroll;