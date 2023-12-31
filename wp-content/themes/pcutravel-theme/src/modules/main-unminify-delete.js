jQuery(document).ready(function (e) {
    function o(o, n, t, a) {
        var r = e(o),
            i = t - n,
            s = Math.abs(Math.floor(a / i));
        s = Math.max(s, 50);
        var l,
            d = new Date().getTime() + a;
        function u() {
            var e = new Date().getTime(),
                o = Math.max((d - e) / a, 0),
                n = Math.round(t - o * i);
            r.html(n.toLocaleString()), n == t && clearInterval(l);
        }
        (l = setInterval(u, s)), u();
    }
    e("#left-stat").length &&
        e(window).on("scroll", function () {
            if (e("#left-stat").isInViewport() && !e("#left-stat").hasClass("animated")) {
                var n = e("#left-stat").attr("data-value");
                e("#left-stat").addClass("animated"), o("#left-stat", 0, n, 3e3);
            }
            if (e("#middle-stat").isInViewport() && !e("#middle-stat").hasClass("animated")) {
                var t = e("#middle-stat").attr("data-value");
                e("#middle-stat").addClass("animated"), o("#middle-stat", 0, t, 3e3);
            }
            if (e("#animated-logo").isInViewport() && !e("#animated-logo").hasClass("played")) {
                e("#animated-logo").addClass("played");
                var a = document.getElementById("animated-logo");
                a && a.play();
            }
        });
}),
    jQuery(document).ready(function (e) {
        var o = e("#userLoginSpinner"),
            n = e("#userForgotPasswordSpinner"),
            t = e("#noActionSpinner"),
            a = { username: "", password: "", fromPanel: !1 };
        function r(o, n) {
            return "" == o.trim()
                ? (e("#userLoginMessage").find(".message").text("Username required."), e("#userLoginMessage").modal(), !0)
                : "" == n.trim() && (e("#userLoginMessage").find(".message").text("Password required."), e("#userLoginMessage").modal(), !0);
        }
        function i(n, a, r, i) {
            e.ajax({ url: r, method: "POST", contentType: "application/json", headers: { credentials: n + ":" + a }, beforeSend: function (e, o) {} })
                .done(function (e) {
                    window.location.href = i + "?token=" + e.token;
                })
                .fail(function (n) {
                    o.modal("hide"), t.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.TokenFailed), e("#userLoginMessage").modal();
                });
        }
        function s(e, o) {
            window.location.href = o;
        }
        e(".login-panel .toggle").on("click", function (o) {
            o.preventDefault(),
                ($loginpanel = e(".login-panel")),
                ($panel = e(".login-panel .panel")),
                $loginpanel.hasClass("open")
                    ? ($loginpanel.addClass("closing"),
                      $loginpanel.animate({ width: "120px" }, 500, function () {
                          $loginpanel.removeClass("open"), $loginpanel.removeClass("closing");
                      }))
                    : ($loginpanel.addClass("opening"),
                      $loginpanel.animate({ width: "420px" }, 500, function () {
                          $loginpanel.addClass("open"), $loginpanel.removeClass("opening");
                      }));
        }),
            e(".cancel-button").on("click", function (o) {
                o.preventDefault(), e(".login-panel .toggle").click();
            }),
            e("#login-link").on("click", function (o) {
                o.preventDefault(), e("#forgot-password-form").hide(), e(".forgot-password").show(), e("#login-form").show(), e(".login").hide();
            }),
            e("#forgot-password-link").on("click", function (o) {
                o.preventDefault(), e("#login-form").hide(), e(".login").show(), e("#forgot-password-form").show(), e(".forgot-password").hide();
            }),
            e("#login-form").on("submit", function (n) {
                n.preventDefault(),
                    e(".login-panel .toggle").click(),
                    (a.username = e(".login-panel input[name=username]").val()),
                    (a.password = e(".login-panel input[name=password]").val()),
                    (a.fromPanel = !0),
                    r(a.username, a.password) || o.modal("show");
            }),
            e(".login-widget .login").on("click", function (n) {
                n.preventDefault(), (a.username = e(".login-widget input[name=username]").val()), (a.password = e(".login-widget input[name=password]").val()), (a.fromPanel = !1), r(a.username, a.password) || o.modal("show");
            }),
            e("#forgot-password-form").on("submit", function (o) {
                if ((o.preventDefault(), e(".login-panel .toggle").click(), "" == e("#email").val().trim())) return e("#userLoginMessage").find(".message").text("Email required."), void e("#userLoginMessage").modal();
                n.modal("show");
            }),
            e("#userForgotPasswordSpinner").on("shown.bs.modal", function () {
                var o = e("#email").val();
                e.ajax({ url: PointComfort.API + "/api/forgot-password/", method: "POST", data: JSON.stringify({ email: o }), contentType: "application/json" })
                    .done(function (t) {
                        if (t.success) {
                            var a = (function (o) {
                                if (!o.sites || 0 == o.sites.length) return e("#userLoginMessage").find(".message").text(PointComfort.Errors.EmailNotFound), e("#userLoginMessage").modal(), null;
                                if (1 == o.sites.length) return o.sites[0];
                                var t = e("#userForgotPasswordDecisionModal"),
                                    a = t.find("form");
                                return (
                                    a.html(""),
                                    e.each(o.sites, function (o, n) {
                                        var t = e('<div class="form-group"></div>'),
                                            r = e(0 == o ? '<input type="radio" name="site" checked="checked" />' : '<input type="radio" name="site" />'),
                                            i = e("<label></label>");
                                        r.attr("value", o), r.data("site", n), i.html("&nbsp;" + n.name), t.append(r).append(i), a.append(t);
                                    }),
                                    n.modal("hide"),
                                    t.modal(),
                                    null
                                );
                            })(t.data);
                            null !== a && s(o, a.url);
                        } else n.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.EmailNotFound), e("#userLoginMessage").modal();
                    })
                    .fail(function () {
                        n.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.EmailNotFound), e("#userLoginMessage").modal();
                    });
            }),
            e("#userLoginSpinner").on("shown.bs.modal", function () {
                "True" === e("#UsePortalLogin").val()
                    ? e
                          .ajax({ url: e("#PortalLoginURL").val(), method: "POST", data: JSON.stringify(a), contentType: "application/json" })
                          .done(function (n) {
                              n.success ? (window.location.href = n.redirect) : (o.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.LoginFailed), e("#userLoginMessage").modal());
                          })
                          .fail(function (n) {
                              o.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.LoginError), e("#userLoginMessage").modal();
                          })
                    : e
                          .ajax({ url: PointComfort.API + "/api/login/", method: "POST", data: JSON.stringify({ username: a.username, password: a.password }), contentType: "application/json" })
                          .done(function (n) {
                              if (n.success) {
                                  var t = (function (n) {
                                      if (!n.roles || 0 == n.roles.length) return e("#userLoginMessage").find(".message").text(PointComfort.Errors.LoginFailed), e("#userLoginMessage").modal(), null;
                                      if (1 == n.roles.length) return n.roles[0];
                                      var t = e("#userLoginDecisionModal"),
                                          a = t.find("form");
                                      return (
                                          a.html(""),
                                          e.each(n.roles, function (o, n) {
                                              var t = e('<div class="form-group"></div>'),
                                                  r = e(0 == o ? '<input type="radio" name="role" checked="checked" />' : '<input type="radio" name="role" />'),
                                                  i = e("<label></label>");
                                              r.attr("value", o), r.data("role", n), i.html("&nbsp;" + n.name), t.append(r).append(i), a.append(t);
                                          }),
                                          o.modal("hide"),
                                          t.modal(),
                                          null
                                      );
                                  })(n.data);
                                  null !== t && i(a.username, a.password, t.loginAPI, t.redirectUrl);
                              } else o.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.LoginFailed), e("#userLoginMessage").modal();
                          })
                          .fail(function () {
                              o.modal("hide"), e("#userLoginMessage").find(".message").text(PointComfort.Errors.LoginError), e("#userLoginMessage").modal();
                          });
            }),
            e("#userLoginMessage").on("hidden.bs.modal", function () {
                a.fromPanel && e(".login-panel .toggle").click();
            }),
            e("#selectLoginPortal").on("click", function () {
                var o = e("#userLoginDecisionModal"),
                    n = o.find("input[type=radio]:checked").data("role");
                o.modal("hide"), t.modal("show"), i(a.username, a.password, n.loginAPI, n.redirectUrl);
            }),
            e("#selectForgotPasswordPortal").on("click", function () {
                var o = e("#email").val(),
                    n = e("#userForgotPasswordDecisionModal"),
                    a = n.find("input[type=radio]:checked").data("site");
                n.modal("hide"), t.modal("show"), s(o, a.url);
            });
    });
var PointComfort = {
    API: "",
    TripAPI: "",
    Errors: {
        LoginError: "An error occurred. Please try again.",
        LoginFailed: "Login failed.",
        TokenFailed: "An error occurred communicating with the portal. Please contact Point Comfort support.",
        EmailNotFound: "Email not found.",
        NoTravelersSelected: "Please select at least one traveler.",
        DocumentDownloadFailed: "Unable to download documents at this time.",
        SaveApplicationFailed: "Unable to save application at this time.",
    },
    CurrentUser: null,
    GetPortalUserInfo: async function () {
        if (null != PointComfort.CurrentUser) return PointComfort.CurrentUser;
        let e = new Promise((e, o) => {
                $.ajax({ url: "https://pointcomforttravel.com//user/json", cache: !1, method: "POST", contentType: "application/json", data: JSON.stringify({}) })
                    .done(function (o) {
                        o.success ? e(o.data) : e(null);
                    })
                    .fail(function (o) {
                        e(null);
                    });
            }),
            o = await e;
        return (PointComfort.CurrentUser = o), o;
    },
};
function isFunction(e) {
    return e && "[object Function]" === {}.toString.call(e);
}
function formatDate(e, o = "Not set.", n = "MM/DD/YYYY") {
    return e ? moment(e).format(n) : o;
}
function round(e, o) {
    return Number(Math.round(e + "e" + o) + "e-" + o);
}
jQuery(document).ready(function (e) {
    function o() {
        e.each(e(".social-posts"), function (o, n) {
            var t = e(n).find(".social-post");
            if (t.length) {
                var a = t.first().width() + 40;
                e(n)
                    .children(".row")
                    .css("width", t.length * a + "px");
            }
        });
    }
    function n() {
        e("body").hasClass("purchase-path-template") ||
            (0 == e(window).scrollTop() && e("#topbar").hasClass("white")
                ? (!e(".navbar-toggler").hasClass("collapsed") && e(".navbar-toggler").is(":visible")) || e("#topbar").removeClass("white")
                : 0 === e(window).scrollTop() || e("#topbar").hasClass("white") || e("#topbar").addClass("white"));
    }
    (e.fn.isInViewport = function () {
        if (!e(this).offset()) return !1;
        var o = e(this).offset().top,
            n = o + e(this).outerHeight(),
            t = e(window).scrollTop(),
            a = t + e(window).height();
        return n > t && n < a && o < a && o > t;
    }),
        (e.fn.animateRotate = function (o, n, t, a, r, i) {
            return this.each(function () {
                var s = e(this);
                e({ deg: o }).animate(
                    { deg: n },
                    {
                        duration: t,
                        easing: r,
                        step: function (e) {
                            s.css({ transform: "rotate(" + e + "deg)", "transform-origin": a || "center" });
                        },
                        complete: i || e.noop,
                    }
                );
            });
        }),
        e.extend({
            findFirst: function (e, o) {
                var n;
                for (n = 0; n < e.length; ++n) if (o(e[n], n)) return e[n];
            },
        }),
        e(".social-posts").length &&
            (e(window).on("resize", function () {
                o();
            }),
            o()),
        e(window).on("scroll", function () {
            n();
        }),
        n(),
        e(".navbar-toggler").on("click", function (o) {
            window.setTimeout(function () {
                e(".navbar-toggler").hasClass("collapsed") ? e("#topbar").removeClass("white") : e("#topbar").addClass("white");
            }, 100);
        }),





        e("faq").live("mouseenter", async function () {
            let o = await (async function (o) {
                var n = { entry: e(o).data("entry") };
                let t = new Promise((o, t) => {
                    e.ajax({ url: PointComfort.API + "/api/faq/entry", method: "POST", contentType: "application/json", data: JSON.stringify(n) })
                        .done(function (e) {
                            e.success ? o("<strong>" + e.data.question + "</strong><br/>" + e.data.answer) : t(new Error(e.errors[0]));
                        })
                        .fail(function (e) {
                            var o = e.errors ? e.errors[0] : "An error occurred retrieving your data.";
                            t(new Error(o));
                        });
                });
                return await t;
            })(this);
            var n = e("<div></div>").addClass("entry-popover").html(o);
            e(this).append(n);
        }),
        e("faq").live("mouseleave", function () {
            e(this).find(".entry-popover").remove();
        }),



        
        e("glossary").live("mouseenter", async function () {
            if (e(this).parent(".answer").length && !e(this).parent(".answer").height()) return;
            let o = await (async function (o) {
                var n = { entry: e(o).data("entry") };
                console.log(n);
                let t = new Promise((o, t) => {
                    e.ajax({ url: PointComfort.API + "/api/glossary/entry", method: "POST", contentType: "application/json", data: JSON.stringify(n) })
                        .done(function (e) {
                            e.success ? o("<strong>" + e.data.title + "</strong><br/>" + e.data.definition) : t(new Error(e.errors[0]));
                        })
                        .fail(function (e) {
                            var o = e.errors ? e.errors[0] : "An error occurred retrieving your data.";
                            t(new Error(o));
                        });
                });
                return await t;
            })(this);
            var n = e("<div></div>").addClass("entry-popover").html(o);
            e(this).append(n);
        }),
        e("glossary").live("mouseleave", function () {
            e(this).find(".entry-popover").remove();
        });
}),







    jQuery(document).ready(function (e) {
        if (e(".start-your-quote").length) {
            var o = 1250;
            !(async function () {
                await t(1e3),
                    (async function () {
                        var a,
                            r,
                            i,
                            s = ["word1", "word2", "word3", "word4", "word5", "word6"];
                        for (a = 0; a < s.length; a++) {
                            var l;
                            (l = a == s.length - 1 ? 0 : a + 1), n(s[a]), (r = s[l]), (i = void 0), ((i = document.getElementById(r)).style.display = "inline-block"), e(i).removeClass("fadeout"), e(i).addClass("fadein"), await t(o);
                        }
                    })();
            })();
        }
        async function n(n) {
            var a = document.getElementById(n);
            e(a).removeClass("fadein"), e(a).addClass("fadeout"), await t(o), (a.style.display = "none");
        }
        function t(e) {
            return new Promise((o) => setTimeout(o, e));
        }
    }),
    jQuery(document).ready(function (e) {
        var u = setInterval(function () {
            e(".start").addClass("zoom"),
                setTimeout(function () {
                    e(".start").removeClass("zoom");
                }, 300);
        }, 3e3);
        e(".start-your-quote button").on("click", function (o) {
            o.preventDefault(),
                e("#purchase-path-spinner").modal("show"),
                clearInterval(u),
                e(".start-your-quote .to-remove").fadeOut(),
                purchasePathApp.init(function () {
                    e("#purchase-path, #purchase-path .indicators, .quote-engine .opacity, .quote-engine .controls, .quote-engine .blue").fadeIn(500, function () {
                        e("#purchase-path-spinner").modal("hide");
                    }),
                        purchasePathApp.showQuoteEngineStep(1);
                });
        });
    });
