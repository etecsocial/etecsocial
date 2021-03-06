// Bar chart ( New Clients)
$("#clients-bar").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 70, 50, 75, 65, 80, 70, 65, 90, 65, 80, 70, 65, 90], {
    type: 'bar',
    height: '25',
    width: '100%',
    barWidth: 10,
    barSpacing: 4,
    barColor: '#C7FCC9',
    negBarColor: '#81d4fa',
    zeroColor: '#81d4fa',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

// Line chart ( New Invoice)
$("#invoice-line").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9, 5], {
    type: 'line',
    width: '100%',
    height: '25',
    lineWidth: 2,
    lineColor: '#E1D0FF',
    fillColor: 'rgba(233, 30, 99, 0.4)',
    highlightSpotColor: '#E1D0FF',
    highlightLineColor: '#E1D0FF',
    minSpotColor: '#f44336',
    maxSpotColor: '#4caf50',
    spotColor: '#E1D0FF',
    spotRadius: 4,
    
   // //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});


// Tristate chart (Today Profit)
$("#profit-tristate").sparkline([2, 3, 0, 4, -5, -6, 7, -2, 3, 0, 2, 3, -1, 0, 2, 3, 3, -1, 0, 2, 3], {
    type: 'tristate',
    width: '100%',
    height: '25',
    posBarColor: '#B9DBEC',
    negBarColor: '#C7EBFC',
    barWidth: 10,
    barSpacing: 4,
    zeroAxis: false,
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

// Bar + line composite charts (Total Sales)
$('#sales-compositebar').sparkline([4, 6, 7, 7, 4, 3, 2, 3, 1, 4, 6, 5, 9, 4, 6, 7, 7, 4, 6, 5, 9, 4, 6, 7], {
    type: 'bar',
    barColor: '#F6CAFD',
    height: '25',
    width: '100%',
    barWidth: '10',
    barSpacing: 2,
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});
$('#sales-compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 8, 4, 2, 5, 6, 7], {
    composite: true,
    type: 'line',
    width: '100%',
    lineWidth: 2,
    lineColor: '#fff3e0',
    fillColor: 'rgba(153,114,181,0.3)',
    highlightSpotColor: '#fff3e0',
    highlightLineColor: '#fff3e0',
    minSpotColor: '#f44336',
    maxSpotColor: '#4caf50',
    spotColor: '#fff3e0',
    spotRadius: 4,
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});


// Project Line chart ( Project Box )
$("#project-line-1").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7], {
    type: 'line',
    width: '100%',
    height: '30',
    lineWidth: 2,
    lineColor: '#00bcd4',
    fillColor: 'rgba(0, 188, 212, 0.5)',
});

$("#project-line-2").sparkline([6, 7, 5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9, 5, 3, 2, 2, 4], {
    type: 'line',
    width: '100%',
    height: '30',
    lineWidth: 2,
    lineColor: '#00bcd4',
    fillColor: 'rgba(0, 188, 212, 0.5)',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

$("#project-line-3").sparkline([2, 4, 6, 7, 5, 6, 7, 9, 5, 6, 7, 9, 9, 5, 3, 2, 9, 5, 3, 2, 2, 4, 6, 7], {
    type: 'line',
    width: '100%',
    height: '30',
    lineWidth: 2,
    lineColor: '#00bcd4',
    fillColor: 'rgba(0, 188, 212, 0.5)',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

$("#project-line-4").sparkline([9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7], {
    type: 'line',
    width: '100%',
    height: '30',
    lineWidth: 2,
    lineColor: '#00bcd4',
    fillColor: 'rgba(0, 188, 212, 0.5)',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});




// Sales chart (Sider Bar Chat)
$("#sales-line-1").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6], {
    type: 'line',
    height: '30',
    lineWidth: 2,
    lineColor: '#00bcd4',
    fillColor: 'rgba(0, 188, 212, 0.5)',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

$("#sales-line-2").sparkline([6, 7, 5, 6, 7, 9, 9, 5, 3, 2, 2], {
    type: 'line',
    height: '30',
    lineWidth: 2,
    lineColor: '#00bcd4',
    fillColor: 'rgba(0, 188, 212, 0.5)',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

$("#sales-bar-1").sparkline([2, 4, 6, 7, 5, 6, 7, 9, 5, 6, 7], {
    type: 'bar',
    height: '25',
    barWidth: 2,
    barSpacing: 1,
    barColor: '#4CAF50',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});

$("#sales-bar-2").sparkline([9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7], {
    type: 'bar',
    height: '25',
    barWidth: 2,
    barSpacing: 1,
    barColor: '#FF4081',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});


/*
Sparkline sample charts
*/


$("#bar-chart-sample").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 70, 50, 75, 65, 80, 70], {
    type: 'bar',
    height: '100',
    width: '50%',
    barWidth: 20,
    barSpacing: 10,
    barColor: '#00BCD4',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});


$("#line-chart-sample").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9], {
    type: 'line',
    width: '50%',
    height: '100',
    lineWidth: 2,
    lineColor: '#ffcc80',
    fillColor: 'rgba(255, 152, 0, 0.5)',
    highlightSpotColor: '#ffcc80',
    highlightLineColor: '#ffcc80',
    minSpotColor: '#f44336',
    maxSpotColor: '#4caf50',
    spotColor: '#ffcc80',
    spotRadius: 4,
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class')
});


$("#pie-chart-sample").sparkline([50,60,80,110], {
    type: 'pie',
    width: '150',
    height: '150',
    //tooltipFormat: $.spformat('{{value}}', 'tooltip-class'),
    sliceColors: ['#f4511e','#ffea00','#c6ff00','#00e676','#1de9b6','#00e5ff','#651fff','#f50057']
});

/*!
 * Name: Con - Admin Dashboard with Material Design
 * Version: 2.0.3
 * Author: nK
 * Website: http://nkdev.info
 * Support: http://nk.ticksy.com
 * Purchase: http://themeforest.net/item/con-material-admin-dashboard-template/10621512?ref=nKdev
 * License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
 * Copyright 2015.
 */
! function(t, i) {
    i["true"] = t, window.conApp = {}, ! function(t) {
        "use strict";
        var i = function(i, n) {
            this.options = n, this.$yay = t(i), this.$content = this.$yay.find("~ .content-wrap"), this.$nano = this.$yay.find(".nano"), this.$html = t("html"), this.$body = t("body"), this.$window = t(window), this.changed = !1, this.init()
        };
        i.DEFAULTS = {
            duration: 300,
            resizeWnd: 1e3
        }, i.prototype.init = function() {
            var i = this;
            i.$body.addClass("yay-notransition"), i.$nano.nanoScroller({
                preventPageScrolling: !0
            }), t(".yay-toggle").on("click", function(t) {
                t.preventDefault(), i.toggleYay()
            }), i.$content.on("click", function() {
                i.isHideOnContentClick() && i.hideYay()
            }), i.$yay.on("click", "li a.yay-sub-toggle", function(n) {
                n.preventDefault(), i.toggleSub(t(this))
            }), "push" == i.showType() && i.isShow() && i.$body.css("overflow", "hidden"), i.$yay.hasClass("yay-gestures") && i.useGestures(), i.$window.on("resize", function() {
                i.windowResize()
            }), i.windowResize(), setTimeout(function() {
                i.$body.removeClass("yay-notransition")
            }, 1), conApp.yaySelectItem = function(t) {
                var n = i.$yay.find('[href*="' + t + '"]');
                if (n.length) {
                    i.$yay.find(".active").removeClass("active");
                    var o = n.parent("li").parent("ul").siblings(".yay-sub-toggle"),
                        e = !o.parent(".open").length;
                    o.length && e && i.toggleSub(o), n.parent("li").addClass("active")
                }
            }
        }, i.prototype.isShow = function() {
            return !this.$body.hasClass("yay-hide")
        }, i.prototype.showType = function() {
            return this.$yay.hasClass("yay-overlay") ? "overlay" : this.$yay.hasClass("yay-push") ? "push" : this.$yay.hasClass("yay-shrink") ? "shrink" : void 0
        }, i.prototype.isHideOnContentClick = function() {
            return this.$yay.hasClass("yay-overlap-content")
        }, i.prototype.isStatic = function() {
            return this.$yay.hasClass("yay-static")
        }, i.prototype.toggleYay = function(t) {
            var i = this,
                n = !i.isShow();
            t && ("show" == t && !n || "hide" == t && n) || (i.options.changed = !0, n ? i.showYay() : i.hideYay())
        }, i.prototype.showYay = function() {
            var t = this;
            t.$body.removeClass("yay-hide"), "push" == t.showType() && (t.$body.css("overflow-x", "hidden"), t.$html.css("overflow-x", "hidden")), setTimeout(function() {
                t.$nano.nanoScroller(), t.$window.resize()
            }, t.options.duration)
        }, i.prototype.hideYay = function() {
            var t = this;
            t.$body.addClass("yay-hide"), t.$nano.nanoScroller({
                destroy: !0
            }), setTimeout(function() {
                "push" == t.showType() && (t.$body.css("overflow-x", "visible"), t.$html.css("overflow-x", "visible")), t.$window.resize()
            }, t.options.duration)
        }, i.prototype.toggleSub = function(t) {
            var i = this,
                n = t.parent(),
                o = n.find("> ul"),
                e = n.hasClass("open");
            o.length && (e ? i.closeSub(o) : i.openSub(o, n))
        }, i.prototype.closeSub = function(i) {
            var n = this;
            i.css("display", "block").stop().slideUp(n.options.duration, "swing", function() {
                t(this).find("li a.yay-sub-toggle").next().attr("style", ""), n.$nano.nanoScroller()
            }), i.parent().removeClass("open"), i.find("li a.yay-sub-toggle").parent().removeClass("open")
        }, i.prototype.openSub = function(t, i) {
            var n = this;
            t.css("display", "none").stop().slideDown(n.options.duration, "swing", function() {
                n.$nano.nanoScroller()
            }), i.addClass("open"), n.closeSub(i.siblings(".open").find("> ul"))
        }, i.prototype.useGestures = function() {
            var t = this,
                i = 0,
                n = 0,
                o = 0;
            t.$window.on("touchstart", function(t) {
                n = (t.originalEvent.touches ? t.originalEvent.touches[0] : t).pageX, o = (t.originalEvent.touches ? t.originalEvent.touches[0] : t).pageX, i = 1
            }), t.$window.on("touchmove", function(t) {
                i && (o = (t.originalEvent.touches ? t.originalEvent.touches[0] : t).pageX)
            }), t.$window.on("touchend", function() {
                if (i) {
                    var e = n - o,
                        s = t.$html.hasClass("rtl");
                    if (i = 0, Math.abs(e) < 100) return;
                    s && (e *= -1, n = t.$window.width() - n), 0 > e ? 40 > n && t.showYay() : t.hideYay()
                }
            })
        };
        var n;
        i.prototype.windowResize = function() {
            var t = this;
            t.options.changed || (clearTimeout(n), n = setTimeout(function() {
                t.$window.width() < t.options.resizeWnd && t.toggleYay("hide")
            }, 50))
        }, conApp.initSidebar = function() {
            t(".yaybar").each(function() {
                {
                    var n = t.extend({}, i.DEFAULTS, t(this).data(), "object" == typeof option && option);
                    new i(this, n)
                }
            })
        }, "undefined" == typeof conAngular && conApp.initSidebar()
    }(jQuery), ! function(t) {
        "use strict";
        var i = function(i, n) {
            this.options = n, this.$element = t(i), this.init()
        };
        i.DEFAULTS = {
            fallback: ["Seattle", ""],
            icons: ["wi-tornado", "wi-night-thunderstorm", "wi-storm-showers", "wi-thunderstorm", "wi-storm-showers", "wi-rain-mix", "wi-rain-mix", "wi-rain-mix", "wi-rain-mix", "wi-snow", "wi-rain-mix", "wi-snow", "wi-snow", "wi-snow", "wi-snow", "wi-rain-mix", "wi-snow", "wi-rain-mix", "wi-rain-wind", "wi-cloudy-windy", "wi-cloudy-windy", "wi-cloudy-windy", "wi-cloudy-windy", "wi-cloudy-windy", "wi-cloudy-gusts", "wi-cloudy-gusts", "wi-cloudy", "wi-night-cloudy", "wi-day-cloudy", "wi-night-cloudy", "wi-day-cloudy", "wi-night-clear", "wi-day-sunny", "wi-night-clear", "wi-day-sunny", "wi-rain-mix", "wi-day-sunny", "wi-storm-showers", "wi-storm-showers", "wi-storm-showers", "wi-rain", "wi-rain-mix", "wi-snow", "wi-rain-mix", "wi-night-cloudy", "wi-storm-showers", "wi-rain-wind", "wi-storm-showers"]
        }, i.prototype.init = function() {
            var t = this;
            "geolocation" in navigator ? navigator.geolocation.getCurrentPosition(function(i) {
                t.loadWeather(i.coords.latitude + "," + i.coords.longitude)
            }) : t.loadWeather(t.options.fallback[0], t.options.fallback[1])
        }, i.prototype.loadWeather = function(i, n) {
            var o = this;
            t.simpleWeather({
                location: i,
                woeid: n,
                unit: "c",
                success: function(t) {
                    var i = ['<div class="row">', '<div class="temp col s7">', t.temp + "&deg;" + t.units.temp, ' <span class="alt">' + t.alt.temp + "&deg;F</span>", "</div>", '<div class="city col s5"><i class="fa fa-map-marker"></i> ' + t.city + "</div>", "</div>", '<div class="icon"><i class="wi ' + o.options.icons[t.code] + '"></i></div>', '<div class="currently">' + t.currently + "</div>"].join("");
                    o.$element.html(i)
                },
                error: function(t) {
                    o.$element.html("<h4>" + t.error + "</h4><p>" + t.message + "</p>")
                }
            })
        }, conApp.initCardWeather = function() {
            t(".weather-card").each(function() {
                new i(this, i.DEFAULTS)
            })
        }, "undefined" == typeof conAngular && conApp.initCardWeather()
    }(jQuery), ! function(t) {
        "use strict";
        var i = function(i, n) {
            this.options = n, this.$card = t(i), this.$closeBtn = this.$card.find("> .title > .close"), this.$minimizeBtn = this.$card.find("> .title > .minimize"), this.$content = this.$card.find("> .content"), this.$window = t(window)
        };
        i.DEFAULTS = {
            duration: 300
        }, i.prototype.init = function() {
            var t = this;
            t.$closeBtn.on("click", function(i) {
                i.preventDefault(), t.close()
            }), t.$minimizeBtn.on("click", function(i) {
                i.preventDefault(), t.minimize()
            })
        }, i.prototype.close = function() {
            var t = this;
            t.$card.velocity({
                opacity: 0,
                translateY: -20
            }, t.options.duration).velocity("slideUp", t.options.duration, function() {
                t.$card.remove()
            })
        }, i.prototype.minimize = function() {
            var t = this;
            t.$card.hasClass("minimized") ? t.$content.css("display", "none").velocity("slideDown", "swing", t.options.duration) : t.$content.css("display", "block").velocity("slideUp", "swing", t.options.duration), t.$card.toggleClass("minimized"), t.$window.resize()
        }, conApp.initCards = function() {
            t(".card").each(function() {
                var n = t.extend({}, i.DEFAULTS, t(this).data(), "object" == typeof option && option),
                    o = new i(this, n);
                o.init()
            })
        }, "undefined" == typeof conAngular && conApp.initCards()
    }(jQuery), ! function(t) {
        "use strict";

        function i(i) {
            return this.each(function() {
                var o = t(this),
                    e = o.data("mdlayer"),
                    s = t.extend({}, n.DEFAULTS, o.data(), "object" == typeof i && i);
                e || o.data("mdlayer", e = new n(this, s)), "string" == typeof i && e[i] && e[i](), "undefined" == typeof i && e.toggle()
            })
        }
        var n = function(i, n) {
            this.options = n, this.$body = t("body"), this.$navbar = t(".navbar-top:eq(0)"), this.$layer = t(i), this.$overlay = this.$layer.find("> .layer-overlay"), this.$content = this.$layer.find("> .layer-content"), this.contDuration = .8 * this.options.duration, this.isOpened = this.$layer.hasClass("layer-opened"), this.busy = !1, this.startStyles = {
                left: 0,
                top: 0,
                width: 0,
                height: 0,
                marginTop: 0,
                marginLeft: 0
            }, this.useSVG = document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1") && !/^((?!chrome).)*safari/i.test(navigator.userAgent), this.init()
        };
        n.DEFAULTS = {
            duration: 600,
            fixScrollbar: !1,
            onhide: !1,
            onshow: !1
        }, n.prototype.init = function() {
            var t = this;
            t.useSVG ? t.prepareSVG() : t.$overlay.css({
                position: "absolute",
                borderRadius: "50%",
                zIndex: 0
            }), this.$content[0] && (this.$content[0].style.background = "none"), t.$content.css({
                zIndex: 2
            })
        }, n.prototype.prepareSVG = function() {
            var t = this.$overlay.css("background-color"),
                i = ['<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">', '<g><circle cx="0" cy="0" r="0" fill="' + t + '"></circle></g>', "</svg>"].join("");
            this.$overlay.css({
                position: "absolute",
                width: "100%",
                height: "100%",
                background: "none",
                zIndex: 0,
                transform: "scale(1)"
            }).html(i), this.$overlay[0] && (this.$overlay[0].style.background = "none")
        }, n.prototype.setPosition = function(t) {
            return this.useSVG ? (t.find("g").attr({
                transform: "translate(" + this.startStyles.left + ", " + this.startStyles.top + ")"
            }), t = t.find("circle"), t.attr({
                r: this.startStyles.radius
            })) : t.css({
                left: this.startStyles.left,
                top: this.startStyles.top,
                width: 2 * this.startStyles.radius,
                height: 2 * this.startStyles.radius,
                marginTop: -this.startStyles.radius,
                marginLeft: -this.startStyles.radius
            }), t
        }, n.prototype.toggle = function(t) {
            return this.busy || "show" == t && this.isOpened || "hide" == t && !this.isOpened ? !1 : (this.busy = !0, this.calculateStartStyles(), void(this.isOpened ? this.hide(1) : this.show(1)))
        }, n.prototype.show = function(t) {
            if (!t) return this.toggle("show"), !1;
            var i = this;
            i.options.fixScrollbar && (i.checkScrollbar(), i.setScrollbar(), i.$body.addClass("layer-fix-scroll")), i.setPosition(i.$overlay).velocity({
                scale: 0
            }, 0).velocity({
                translateZ: 0,
                scale: 1
            }, i.options.duration, function() {
                i.isOpened = !0, i.options.onshow && i.options.onshow(), i.busy = !1
            }), i.$content.hide().delay(i.contDuration).velocity("fadeIn", i.contDuration), setTimeout(function() {
                i.$layer.addClass("layer-opened").show()
            })
        }, n.prototype.hide = function(t) {
            if (!t) return this.toggle("hide"), !1;
            var i = this;
            i.$content.velocity("fadeOut", i.contDuration), i.setPosition(i.$overlay).velocity({
                scale: 1
            }, 0).velocity({
                translateZ: 0,
                scale: 0
            }, i.options.duration, function() {
                i.isOpened = !1, i.$layer.removeClass("layer-opened").hide(), i.options.onhide && i.options.onhide(), i.options.fixScrollbar && (i.$body.removeClass("layer-fix-scroll"), i.resetScrollbar()), i.busy = !1
            })
        }, n.prototype.calculateStartStyles = function() {
            var i = this,
                n = i.$layer;
            this.isOpened || n.css({
                visibility: "hidden",
                display: "block"
            });
            var o = {
                top: n.position().top,
                left: n.position().left,
                width: n.width(),
                height: "fixed" == n.css("position") ? t(window).height() : n.height()
            };
            this.isOpened || n.css({
                display: "none",
                visibility: "visible"
            }), i.startStyles = {
                left: window.mousePos.x - o.left,
                top: window.mousePos.y - o.top
            }, i.startStyles.left < 0 && (i.startStyles.left = 0), i.startStyles.top < 0 && (i.startStyles.top = 0), t.extend(i.startStyles, {
                radius: Math.sqrt(Math.pow(o.width, 2) + Math.pow(o.height, 2))
            })
        }, n.prototype.checkScrollbar = function() {
            this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight, this.scrollbarWidth = this.measureScrollbar()
        }, n.prototype.setScrollbar = function() {
            var t = parseInt(this.$body.css("padding-right") || 0, 10);
            this.bodyIsOverflowing && (this.$body.css("padding-right", t + this.scrollbarWidth), this.$navbar.css("padding-right", t + this.scrollbarWidth))
        }, n.prototype.resetScrollbar = function() {
            this.$body.css("padding-right", ""), this.$navbar.css("padding-right", "")
        }, n.prototype.measureScrollbar = function() {
            var t = document.createElement("div");
            t.className = "layer-scrollbar-measure", this.$body.append(t);
            var i = t.offsetWidth - t.clientWidth;
            return this.$body[0].removeChild(t), i
        }, t.fn.MDLayer = i, t.fn.MDLayer.Constructor = n, window.mousePos = {
            x: 0,
            y: 0
        }, t(document).on("mousemove", function(t) {
            window.mousePos.x = t.clientX || t.pageX, window.mousePos.y = t.clientY || t.pageY
        })
    }(jQuery), ! function(t) {
        var i = function(i, n) {
            this.options = n, this.$chat = t(i), this.$window = t(window), this.$document = t(document), this.$chatForm = this.$chat.find(".send > form"), this.$msgNano = this.$chat.find(".messages .nano"), this.$msgCont = this.$msgNano.find("> .nano-content"), this.$msgInput = this.$chat.find("input[name=chat-message]")
        };
        i.DEFAULTS = {
            msgDuration: 300,
            msgDemo: "Demo chat message ;)"
        }, i.prototype.init = function() {
            var i = this;
            i.initLayer(), i.$chatForm.on("submit", function(t) {
                t.preventDefault(), i.sendMsg()
            }), i.$chat.on("click", ".contacts .user", function(t) {
                t.stopPropagation(), i.$chat.addClass("open-messages")
            }), i.$chat.on("click", ".messages .topbar > .chat-back", function(t) {
                t.stopPropagation(), t.preventDefault(), i.$chat.removeClass("open-messages")
            }), i.$chat.on("click", function(i) {
                t(i.target).hasClass("chat-toggle") || t(i.target).parent().hasClass("chat-toggle") || i.stopPropagation()
            }), i.$chat.find(".nano").each(function() {
                var i = "";
                t(this).hasClass("scroll-bottom") ? i = "bottom" : t(this).hasClass("scroll-top") && (i = "top"), t(this).nanoScroller({
                    preventPageScrolling: !0,
                    scroll: i
                })
            })
        }, i.prototype.initLayer = function() {
            var t = this;
            t.$chat.MDLayer({
                duration: 400,
                onshow: function() {
                    t.$window.resize()
                }
            }), t.$document.on("click", ".chat-toggle", function(i) {
                i.preventDefault(), i.stopPropagation(), t.$chat.MDLayer()
            }), t.$document.on("click", function() {
                t.$chat.MDLayer("hide")
            }), t.$document.on("keyup", function(i) {
                27 == i.keyCode && t.$chat.MDLayer("hide")
            })
        }, i.prototype.sendMsg = function() {
            var i = this,
                n = i.$msgInput.val();
            if (n) {
                i.$msgInput.val("");
                var o = t('<div class="chatm from-me">' + n + "</div>");
                i.$msgCont.append('<div class="clear"></div>').append(o), o.velocity({
                    scale: 0,
                    opacity: 0
                }, 0).velocity({
                    scale: 1,
                    opacity: 1
                }, i.options.msgDuration), i.$msgNano.nanoScroller().nanoScroller({
                    scroll: "bottom"
                })
            }
        }, conApp.initChat = function() {
            t(".chat").each(function() {
                var n = t.extend({}, i.DEFAULTS, t(this).data(), "object" == typeof option && option),
                    o = new i(this, n);
                o.init()
            })
        }, "undefined" == typeof conAngular && conApp.initChat()
    }(jQuery), ! function(t) {
        "use strict";
        t.fn.conSparkline = function(i, n) {
            var o = t(this),
                e = t(window),
                s = function() {
                    if (t.fn.sparkline) {
                        var e = {};
                        "bar" == n.type && /%/g.test(n.width) && (e.barSpacing = 1, e.barWidth = o.width() / i.length), o.sparkline(i, t.extend(n, e))
                    }
                };
            s();
            var a;
            e.on("resize", function() {
                clearTimeout(a), a = setTimeout(s, 50)
            })
        }
    }(jQuery), ! function(t) {
        "use strict";
        var i = function(i, n) {
            this.options = n, this.$todo = t(i), this.$add = this.$todo.find("#todo-add")
        };
        i.DEFAULTS = {
            demoTask: "This is Lorem ipsum task"
        }, i.prototype.init = function() {
            var i = this;
            i.$add.on("keypress", function(t) {
                13 == t.which && i.addTask()
            }), this.$todo.on("click", ".todo-task .todo-remove", function(n) {
                n.preventDefault(), n.stopPropagation(), i.removeTask(t(this).parents(".todo-task:eq(0)"))
            })
        }, i.prototype.addTask = function() {
            var i = "todo-task-" + this.getUniqueID(),
                n = this.$add.val() || this.options.demoTask,
                o = ['<div class="todo-task" style="display: none">', '<input type="checkbox" id="' + i + '">', '<label for="' + i + '">' + n + ' <span class="todo-remove mdi-action-delete"></span></label>', "</div>"].join("");
            o = t(o), this.$add.val(""), this.$add.parent().before(o), o.velocity("slideDown", 300)
        }, i.prototype.removeTask = function(i) {
            i.velocity({
                opacity: 0
            }, 200, function() {
                t(this).velocity("slideUp", 200, function() {
                    t(this).remove()
                })
            })
        };
        var n = 100;
        i.prototype.getUniqueID = function() {
            return t("#todo-task-" + n)[0] ? (n++, this.getUniqueID()) : n
        }, conApp.initCardTodo = function() {
            t(".todo-card").each(function() {
                var n = t.extend({}, i.DEFAULTS, t(this).data(), "object" == typeof option && option),
                    o = new i(this, n);
                o.init()
            })
        }, "undefined" == typeof conAngular && conApp.initCardTodo()
    }(jQuery), ! function(t) {
        "use strict";
        var i, n, o, e = function(i) {
                i && (this.bubbles = [], this.$element = t(i), o = i.getContext("2d"), this.init())
            },
            s = function() {
                function t(t) {
                    e.pos.y = t ? n + Math.random() * n * .2 : n + 20, e.pos.x = Math.random() * i, e.scale = .1 + .7 * Math.random(), e.velocity = .5 * Math.random(), e.alpha = .1 + .2 * Math.random()
                }
                var e = this;
                e.pos = {}, this.draw = function() {
                    e.alpha <= 0 && t(), e.pos.y -= e.velocity, e.alpha -= 4e-4, o.beginPath(), o.arc(e.pos.x, e.pos.y, 10 * e.scale, 0, 2 * Math.PI, !1), o.fillStyle = "rgba(105, 109, 136," + e.alpha + ")", o.fill()
                }, t(!0)
            };
        e.prototype.init = function() {
            var n = this;
            n.updateSizes(), t(window).on("resize", function() {
                n.updateSizes()
            }), n.$element.css({
                position: "fixed",
                top: 0,
                left: 0,
                zIndex: 1
            });
            for (var o = 0;.5 * i > o; o++) {
                var e = new s;
                n.bubbles.push(e)
            }
            n.animate()
        }, e.prototype.updateSizes = function() {
            i = window.innerWidth, n = window.innerHeight, this.$element.attr({
                width: i,
                height: n
            })
        }, e.prototype.animate = function() {
            var t = this;
            o.clearRect(0, 0, i, n);
            for (var e in t.bubbles) t.bubbles[e].draw();
            requestAnimationFrame(function() {
                t.animate()
            })
        }, new e(t("#bubble-canvas")[0])
    }(jQuery), conApp.initMaterialPlugins = function() {
        "undefined" != typeof $.fn.material_select && $("select:not(.select2)").material_select(), "undefined" != typeof $.fn.dropdown && $(".dropdown-button").each(function() {
            var t = "true" == $(this).attr("data-hover") || !1,
                i = "false" == $(this).attr("data-constrainwidth") || !0,
                n = $(this).attr("data-induration") || 300,
                o = $(this).attr("data-outduration") || 300;
            $(this).dropdown({
                hover: t,
                constrain_width: i,
                inDuration: n,
                outDuration: o
            })
        }), "undefined" != typeof $.fn.collapsible && $(".collapsible").each(function() {
            $(this).collapsible({
                accordion: "accordion" === $(this).attr("data-collapsible")
            })
        }), "undefined" != typeof $.fn.leanModal && $(".modal-trigger").each(function() {
            var t = "true" == $(this).attr("data-dismissible") || !1,
                i = $(this).attr("data-opacity") || .5,
                n = $(this).attr("data-induration") || 300,
                o = $(this).attr("data-outduration") || 300;
            $(this).leanModal({
                dismissible: t,
                opacity: i,
                in_duration: n,
                out_duration: o
            })
        })
    }, conApp.initPlugins = function() {
        "undefined" != typeof $.fn.select2 && $(".select2").each(function() {
                $(this).wrap('<div style="width:100%;position:relative;"></div>').select2()
            }), "undefined" != typeof $.fn.tagsInput && $(".input-tag").tagsInput({
                width: "100%",
                height: "auto"
            }), "undefined" != typeof $.fn.pikaday && $(".pikaday").pikaday(), "undefined" != typeof $.fn.clockpicker && $(".clockpicker").clockpicker(), "undefined" != typeof $.fn.spectrum && $(".spectrum").spectrum({
                showButtons: !1
            }), "undefined" != typeof $.fn.inputmask && $("input[data-inputmask]").inputmask(), "undefined" != typeof $.fn.pickadate && $(".datepicker").pickadate(), "undefined" != typeof prettyPrint && prettyPrint(), "undefined" != typeof $.fn.markItUp && $(".markItUp").markItUp(mySettings), "undefined" != typeof Sortable && $(".sortable").each(function() {
                var t = {
                    group: "widgets"
                };
                $(this).find(".card > .title")[0] && (t.handle = ".title"), Sortable.create(this, t)
            }), $(".alert").on("click", ".close", function() {
                $(this).parents(".alert").velocity({
                    opacity: 0,
                    translateY: -20
                }, 300).velocity("slideUp", 300, function() {
                    $(this).remove()
                })
            }),
            function() {
                var t = $("#inputIconSearch");
                0 !== t.length && t.on("keyup", function() {
                    var i = t.val();
                    $(".icon-preview").hide(), $('.icon-preview:contains("' + i + '")').show(), $(".icon-card").hide(), $('.icon-card:contains("' + i + '")').show()
                })
            }()
    }, conApp.initSearchBar = function() {
        var t = $(".search-bar:eq(0)");
        t.MDLayer({
            duration: 500,
            fixScrollbar: !0,
            onshow: function() {
                t.find("input").focus()
            }
        }), $(document).on("click", ".search-bar-toggle", function(i) {
            i.preventDefault(), i.stopPropagation(), t.MDLayer()
        }), $(document).on("keyup", function(i) {
            27 == i.keyCode && t.MDLayer("hide")
        })
    }, jQuery(function() {
        var t = jQuery;
        "undefined" == typeof conAngular && (conApp.initSearchBar(), conApp.initPlugins(), conApp.initMaterialPlugins()), t(window).on("resize", function() {
            if ("undefined" != typeof nv && nv.graphs.length)
                for (var t in nv.graphs) nv.graphs[t].update()
        })
    })
}({}, function() {
    return this
}());