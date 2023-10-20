import e from 'jquery';

class HomeSlider {
    constructor() {

// Words Slider        
jQuery(document).ready(function(e) {
    if (e(".start-your-quote").length) {
        var o = 1250;
        !async function() {
            await t(1e3),
            async function() {
                var a, r, i, s = ["word1", "word2", "word3", "word4", "word5", "word6"];
                for (a = 0; a < s.length; a++) {
                    var l;
                    l = a == s.length - 1 ? 0 : a + 1,
                    n(s[a]),
                    r = s[l],
                    i = void 0,
                    (i = document.getElementById(r)).style.display = "inline-block",
                    e(i).removeClass("fadeout"),
                    e(i).addClass("fadein"),
                    await t(o)
                }
            }()
        }()
    }
    async function n(n) {
        var a = document.getElementById(n);
        e(a).removeClass("fadein"),
        e(a).addClass("fadeout"),
        await t(o),
        a.style.display = "none"
    }
    function t(e) {
        return new Promise(o=>setTimeout(o, e))
    }
}),

// Images Slider
jQuery(document).ready(function(e) {
    var templateUrl = directory_uri.stylesheet_directory_uri;

    if (document.getElementsByClassName("start-your-quote").length > 0) {
        for (var o = ["pct_noble_cheetahs_sm.jpg", "pct_super_skier_sm.jpg", "pct_tropic_sunset_sm.jpg", "pct_scuba_snacks_sm.jpg", "PCT_cheetah_bridge_sm.jpg", "PCT_awesome_kayaker_sm.jpg", "PCT_lady_tourist_on_camel_sm.jpg", "PCT_reef_snorkler_sm.jpg"], n = templateUrl + "/images/default-source/triptime-banner/", t = o.length, a = document.getElementsByTagName("homeheader")[0], r = [], i = document.createElement("div"), s = 0; s <= t; s++)
            if (r[s] = document.createElement("div"),
            i = r[s],
            a.insertBefore(i, a.childNodes[s]),
            a.childNodes[s].setAttribute("class", "featured-image mySlides w3-animate-left"),
            0 === s) {
                var l = o[Math.floor(Math.random() * t)];
                a.childNodes[0].setAttribute("style", "background-image: url('" + n + l + "')")
            } else
                a.childNodes[s].setAttribute("style", "background-image: url('" + n + o[s - 1] + "')");
        var d = 0;
        !function e() {
            var o;
            var n = document.getElementsByClassName("mySlides");
            for (o = 0; o < n.length; o++)
                n[o].style.display = "none";
            d++;
            d > n.length && (d = 1);
            n[d - 1].style.display = "block";
            n[d - 1].style.width = "100%";
            n[d - 1].style.backgroundRepeat = "no-repeat";
            n[d - 1].style.backgroundSize = "cover";
            setTimeout(e, 2e4)
        }()
    }
});

}

};

export default HomeSlider;