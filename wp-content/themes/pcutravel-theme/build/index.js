/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _css_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/style.scss */ "./css/style.scss");
/* harmony import */ var _modules_NavbarAnimations__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/NavbarAnimations */ "./src/modules/NavbarAnimations.js");
/* harmony import */ var _modules_HomeSliders__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/HomeSliders */ "./src/modules/HomeSliders.js");
/* harmony import */ var _modules_ComparePlans__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/ComparePlans */ "./src/modules/ComparePlans.js");
/* harmony import */ var _modules_AccordionFaqs__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/AccordionFaqs */ "./src/modules/AccordionFaqs.js");


// modules / classes 




const navbarAnimations = new _modules_NavbarAnimations__WEBPACK_IMPORTED_MODULE_1__["default"]();
const homeSliders = new _modules_HomeSliders__WEBPACK_IMPORTED_MODULE_2__["default"]();
const comparePlans = new _modules_ComparePlans__WEBPACK_IMPORTED_MODULE_3__["default"]();
const accordionFaqs = new _modules_AccordionFaqs__WEBPACK_IMPORTED_MODULE_4__["default"]();

/***/ }),

/***/ "./src/modules/AccordionFaqs.js":
/*!**************************************!*\
  !*** ./src/modules/AccordionFaqs.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class AccordionFaqs {
  constructor() {
    const btns = document.querySelectorAll(".acc-btn");

    // fn
    function accordion() {
      // this = the btn | icon & bg changed
      this.classList.toggle("is-open");

      // the acc-content
      const content = this.nextElementSibling;

      // IF open, close | else open
      if (content.style.maxHeight) content.style.maxHeight = null;else content.style.maxHeight = content.scrollHeight + "px";
    }

    // event
    btns.forEach(el => el.addEventListener("click", accordion));
  }
}
;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (AccordionFaqs);

/***/ }),

/***/ "./src/modules/ComparePlans.js":
/*!*************************************!*\
  !*** ./src/modules/ComparePlans.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

class ComparePlans {
  constructor() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(function () {
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(".js-toggle-compare").on("click", togglePlans);
      function togglePlans(e) {
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(".js-packages").toggle("slow");
        if (jquery__WEBPACK_IMPORTED_MODULE_0___default()('.icon-double-angle-down').hasClass('open')) {
          jquery__WEBPACK_IMPORTED_MODULE_0___default()('.icon-double-angle-down').removeClass('open');
        } else {
          jquery__WEBPACK_IMPORTED_MODULE_0___default()('.icon-double-angle-down').addClass('open');
        }
      }
    });
  }
}
;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ComparePlans);

/***/ }),

/***/ "./src/modules/HomeSliders.js":
/*!************************************!*\
  !*** ./src/modules/HomeSliders.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

class HomeSlider {
  constructor() {
    // Words Slider        
    jQuery(document).ready(function (e) {
      if (e(".start-your-quote").length) {
        var o = 1250;
        !async function () {
          await t(1e3), async function () {
            var a,
              r,
              i,
              s = ["word1", "word2", "word3", "word4", "word5", "word6"];
            for (a = 0; a < s.length; a++) {
              var l;
              l = a == s.length - 1 ? 0 : a + 1, n(s[a]), r = s[l], i = void 0, (i = document.getElementById(r)).style.display = "inline-block", e(i).removeClass("fadeout"), e(i).addClass("fadein"), await t(o);
            }
          }();
        }();
      }
      async function n(n) {
        var a = document.getElementById(n);
        e(a).removeClass("fadein"), e(a).addClass("fadeout"), await t(o), a.style.display = "none";
      }
      function t(e) {
        return new Promise(o => setTimeout(o, e));
      }
    }),
    // Images Slider
    jQuery(document).ready(function (e) {
      var templateUrl = directory_uri.stylesheet_directory_uri;
      if (document.getElementsByClassName("start-your-quote").length > 0) {
        for (var o = ["pct_noble_cheetahs_sm.jpg", "pct_super_skier_sm.jpg", "pct_tropic_sunset_sm.jpg", "pct_scuba_snacks_sm.jpg", "PCT_cheetah_bridge_sm.jpg", "PCT_awesome_kayaker_sm.jpg", "PCT_lady_tourist_on_camel_sm.jpg", "PCT_reef_snorkler_sm.jpg"], n = templateUrl + "/images/default-source/triptime-banner/", t = o.length, a = document.getElementsByTagName("homeheader")[0], r = [], i = document.createElement("div"), s = 0; s <= t; s++) if (r[s] = document.createElement("div"), i = r[s], a.insertBefore(i, a.childNodes[s]), a.childNodes[s].setAttribute("class", "featured-image mySlides w3-animate-left"), 0 === s) {
          var l = o[Math.floor(Math.random() * t)];
          a.childNodes[0].setAttribute("style", "background-image: url('" + n + l + "')");
        } else a.childNodes[s].setAttribute("style", "background-image: url('" + n + o[s - 1] + "')");
        var d = 0;
        !function e() {
          var o;
          var n = document.getElementsByClassName("mySlides");
          for (o = 0; o < n.length; o++) n[o].style.display = "none";
          d++;
          d > n.length && (d = 1);
          n[d - 1].style.display = "block";
          n[d - 1].style.width = "100%";
          n[d - 1].style.backgroundRepeat = "no-repeat";
          n[d - 1].style.backgroundSize = "cover";
          setTimeout(e, 2e4);
        }();
      }
    });
  }
}
;
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HomeSlider);

/***/ }),

/***/ "./src/modules/NavbarAnimations.js":
/*!*****************************************!*\
  !*** ./src/modules/NavbarAnimations.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

class NavScroll {
  constructor() {
    this.events();
  }
  events() {
    function is_page($pageid) {
      if (jQuery('body').hasClass('page-id-' + $pageid)) {
        return true;
      } else {
        return false;
      }
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
  }
  navbarClicked() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      window.setTimeout(function () {
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(".navbar-toggler").hasClass("collapsed") ? jquery__WEBPACK_IMPORTED_MODULE_0___default()("#topbar").removeClass("white") : (jquery__WEBPACK_IMPORTED_MODULE_0___default()("#topbar").addClass("white"), jquery__WEBPACK_IMPORTED_MODULE_0___default()("#topbar").height(document.getElementById('header').offsetHeight + document.getElementById('menu-primary-top').offsetHeight), jquery__WEBPACK_IMPORTED_MODULE_0___default()("#logo").attr("src", "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg"));
      }, 100);
    } else {
      window.setTimeout(function () {
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(".navbar-toggler").hasClass("collapsed") ? (jquery__WEBPACK_IMPORTED_MODULE_0___default()("#logo").attr("src", "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-white.svg"), jquery__WEBPACK_IMPORTED_MODULE_0___default()("#topbar").removeClass("white")) : (jquery__WEBPACK_IMPORTED_MODULE_0___default()("#topbar").addClass("white"), jquery__WEBPACK_IMPORTED_MODULE_0___default()("#topbar").height(document.getElementById('header').offsetHeight + document.getElementById('menu-primary-top').offsetHeight), jquery__WEBPACK_IMPORTED_MODULE_0___default()("#logo").attr("src", "https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg"));
      }, 100);
    }
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (NavScroll);

/***/ }),

/***/ "./css/style.scss":
/*!************************!*\
  !*** ./css/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = window["jQuery"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkpcu_theme_travel"] = globalThis["webpackChunkpcu_theme_travel"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map