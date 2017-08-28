/*!
 * @copyright &copy; Kartik Visweswaran, Krajee.com, 2013 - 2016
 * @version 4.0.1
 *
 * A simple yet powerful JQuery star rating plugin that allows rendering fractional star ratings and supports
 * Right to Left (RTL) input.
 * 
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */
! function(e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? module.exports = e(require("jquery")) : e(window.jQuery)
}(function(e) {
    "use strict";
    e.fn.ratingLocales = {};
    var t, a, n, r, i, l, s, o, c, u, h;
    t = ".rating", a = 0, n = 5, r = .5, i = function(t, a) {
        return null === t || void 0 === t || 0 === t.length || a && "" === e.trim(t)
    }, l = function(e, t) {
        return e ? " " + t : ""
    }, s = function(e, t) {
        e.removeClass(t).addClass(t)
    }, o = function(e) {
        var t = ("" + e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        return t ? Math.max(0, (t[1] ? t[1].length : 0) - (t[2] ? +t[2] : 0)) : 0
    }, c = function(e, t) {
        return parseFloat(e.toFixed(t))
    }, u = function(e, a, n, r) {
        var i = r ? a : a.split(" ").join(t + " ") + t;
        e.off(i).on(i, n)
    }, h = function(t, a) {
        var n = this;
        n.$element = e(t), n._init(a)
    }, h.prototype = {
        constructor: h,
        _parseAttr: function(e, t) {
            var l, s, o, c, u = this,
                h = u.$element,
                d = h.attr("type");
            if ("range" === d || "number" === d) {
                switch (s = t[e] || h.data(e) || h.attr(e), e) {
                    case "min":
                        o = a;
                        break;
                    case "max":
                        o = n;
                        break;
                    default:
                        o = r
                }
                l = i(s) ? o : s, c = parseFloat(l)
            } else c = parseFloat(t[e]);
            return isNaN(c) ? o : c
        },
        _setDefault: function(e, t) {
            var a = this;
            i(a[e]) && (a[e] = t)
        },
        _listenClick: function(e, t) {
            return e.stopPropagation(), e.preventDefault(), e.handled === !0 ? !1 : (t(e), void(e.handled = !0))
        },
        _starClick: function(e) {
            var t, a = this;
            a._listenClick(e, function(e) {
                return a.inactive ? !1 : (t = a._getTouchPosition(e), a._setStars(t), a.$element.trigger("change").trigger("rating.change", [a.$element.val(), a._getCaption()]), void(a.starClicked = !0))
            })
        },
        _starMouseMove: function(e) {
            var t, a, n = this;
            !n.hoverEnabled || n.inactive || e && e.isDefaultPrevented() || (n.starClicked = !1, t = n._getTouchPosition(e), a = n.calculate(t), n._toggleHover(a), n.$element.trigger("rating.hover", [a.val, a.caption, "stars"]))
        },
        _starMouseLeave: function(e) {
            var t, a = this;
            !a.hoverEnabled || a.inactive || a.starClicked || e && e.isDefaultPrevented() || (t = a.cache, a._toggleHover(t), a.$element.trigger("rating.hoverleave", ["stars"]))
        },
        _clearClick: function(e) {
            var t = this;
            t._listenClick(e, function() {
                t.inactive || (t.clear(), t.clearClicked = !0)
            })
        },
        _clearMouseMove: function(e) {
            var t, a, n, r, i = this;
            !i.hoverEnabled || i.inactive || !i.hoverOnClear || e && e.isDefaultPrevented() || (i.clearClicked = !1, t = '<span class="' + i.clearCaptionClass + '">' + i.clearCaption + "</span>", a = i.clearValue, n = i.getWidthFromValue(a) || 0, r = {
                caption: t,
                width: n,
                val: a
            }, i._toggleHover(r), i.$element.trigger("rating.hover", [a, t, "clear"]))
        },
        _clearMouseLeave: function(e) {
            var t, a = this;
            !a.hoverEnabled || a.inactive || a.clearClicked || !a.hoverOnClear || e && e.isDefaultPrevented() || (t = a.cache, a._toggleHover(t), a.$element.trigger("rating.hoverleave", ["clear"]))
        },
        _resetForm: function(e) {
            var t = this;
            e && e.isDefaultPrevented() || t.inactive || t.reset()
        },
        _setTouch: function(e, t) {
            var a, n, r, l, s, o, c, u = this,
                h = "ontouchstart" in window || window.DocumentTouch && document instanceof window.DocumentTouch;
            h && !u.inactive && (a = e.originalEvent, n = i(a.touches) ? a.changedTouches : a.touches, r = u._getTouchPosition(n[0]), t ? (u._setStars(r), u.$element.trigger("change").trigger("rating.change", [u.$element.val(), u._getCaption()]), u.starClicked = !0) : (l = u.calculate(r), s = l.val <= u.clearValue ? u.fetchCaption(u.clearValue) : l.caption, o = u.getWidthFromValue(u.clearValue), c = l.val <= u.clearValue ? o + "%" : l.width, u._setCaption(s), u.$filledStars.css("width", c)))
        },
        _initTouch: function(e) {
            var t = this,
                a = "touchend" === e.type;
            t._setTouch(e, a)
        },
        _initSlider: function(e) {
            var t = this;
            i(t.$element.val()) && t.$element.val(0), t.initialValue = t.$element.val(), t._setDefault("min", t._parseAttr("min", e)), t._setDefault("max", t._parseAttr("max", e)), t._setDefault("step", t._parseAttr("step", e)), (isNaN(t.min) || i(t.min)) && (t.min = a), (isNaN(t.max) || i(t.max)) && (t.max = n), (isNaN(t.step) || i(t.step) || 0 === t.step) && (t.step = r), t.diff = t.max - t.min
        },
        _initHighlight: function(e) {
            var t, a = this,
                n = a._getCaption();
            e || (e = a.$element.val()), t = a.getWidthFromValue(e) + "%", a.$filledStars.width(t), a.cache = {
                caption: n,
                width: t,
                val: e
            }
        },
        _getContainerCss: function() {
            var e = this;
            return "rating-container" + l(e.theme, "theme-" + e.theme) + l(e.rtl, "rating-rtl") + l(e.size, "rating-" + e.size) + l(e.animate, "rating-animate") + l(e.disabled || e.readonly, "rating-disabled") + l(e.containerClass, e.containerClass)
        },
        _checkDisabled: function() {
            var e = this,
                t = e.$element,
                a = e.options;
            e.disabled = void 0 === a.disabled ? t.attr("disabled") || !1 : a.disabled, e.readonly = void 0 === a.readonly ? t.attr("readonly") || !1 : a.readonly, e.inactive = e.disabled || e.readonly, t.attr({
                disabled: e.disabled,
                readonly: e.readonly
            })
        },
        _addContent: function(e, t) {
            var a = this,
                n = a.$container,
                r = "clear" === e;
            return a.rtl ? r ? n.append(t) : n.prepend(t) : r ? n.prepend(t) : n.append(t)
        },
        _generateRating: function() {
            var t, a, n, r = this,
                i = r.$element;
            a = r.$container = e(document.createElement("div")).insertBefore(i), s(a, r._getContainerCss()), r.$rating = t = e(document.createElement("div")).attr("class", "rating").appendTo(a).append(r._getStars("empty")).append(r._getStars("filled")), r.$emptyStars = t.find(".empty-stars"), r.$filledStars = t.find(".filled-stars"), r._renderCaption(), r._renderClear(), r._initHighlight(), a.append(i), r.rtl && (n = Math.max(r.$emptyStars.outerWidth(), r.$filledStars.outerWidth()), r.$emptyStars.width(n))
        },
        _getCaption: function() {
            var e = this;
            return e.$caption && e.$caption.length ? e.$caption.html() : e.defaultCaption
        },
        _setCaption: function(e) {
            var t = this;
            t.$caption && t.$caption.length && t.$caption.html(e)
        },
        _renderCaption: function() {
            var t, a = this,
                n = a.$element.val(),
                r = a.captionElement ? e(a.captionElement) : "";
            if (a.showCaption) {
                if (t = a.fetchCaption(n), r && r.length) return s(r, "caption"), r.html(t), void(a.$caption = r);
                a._addContent("caption", '<div class="caption">' + t + "</div>"), a.$caption = a.$container.find(".caption")
            }
        },
        _renderClear: function() {
            var t, a = this,
                n = a.clearElement ? e(a.clearElement) : "";
            if (a.showClear) {
                if (t = a._getClearClass(), n.length) return s(n, t), n.attr({
                    title: a.clearButtonTitle
                }).html(a.clearButton), void(a.$clear = n);
                a._addContent("clear", '<div class="' + t + '" title="' + a.clearButtonTitle + '">' + a.clearButton + "</div>"), a.$clear = a.$container.find("." + a.clearButtonBaseClass)
            }
        },
        _getClearClass: function() {
            return this.clearButtonBaseClass + " " + (this.inactive ? "" : this.clearButtonActiveClass)
        },
        _getTouchPosition: function(e) {
            var t = i(e.pageX) ? e.originalEvent.touches[0].pageX : e.pageX;
            return t - this.$rating.offset().left
        },
        _toggleHover: function(e) {
            var t, a, n, r = this;
            e && (r.hoverChangeStars && (t = r.getWidthFromValue(r.clearValue), a = e.val <= r.clearValue ? t + "%" : e.width, r.$filledStars.css("width", a)), r.hoverChangeCaption && (n = e.val <= r.clearValue ? r.fetchCaption(r.clearValue) : e.caption, n && r._setCaption(n + "")))
        },
        _init: function(t) {
            var a = this,
                n = a.$element.addClass("hide");
            return a.options = t, e.each(t, function(e, t) {
                a[e] = t
            }), (a.rtl || "rtl" === n.attr("dir")) && (a.rtl = !0, n.attr("dir", "rtl")), a.starClicked = !1, a.clearClicked = !1, a._initSlider(t), a._checkDisabled(), a.displayOnly && (a.inactive = !0, a.showClear = !1, a.showCaption = !1), a._generateRating(), a._listen(), n.removeClass("rating-loading")
        },
        _listen: function() {
            var t = this,
                a = t.$element,
                n = a.closest("form"),
                r = t.$rating,
                i = t.$clear;
            return u(r, "touchstart touchmove touchend", e.proxy(t._initTouch, t)), u(r, "click touchstart", e.proxy(t._starClick, t)), u(r, "mousemove", e.proxy(t._starMouseMove, t)), u(r, "mouseleave", e.proxy(t._starMouseLeave, t)), t.showClear && i.length && (u(i, "click touchstart", e.proxy(t._clearClick, t)), u(i, "mousemove", e.proxy(t._clearMouseMove, t)), u(i, "mouseleave", e.proxy(t._clearMouseLeave, t))), n.length && u(n, "reset", e.proxy(t._resetForm, t)), a
        },
        _getStars: function(e) {
            var t, a = this,
                n = '<span class="' + e + '-stars">';
            for (t = 1; t <= a.stars; t++) n += '<span class="star">' + a[e + "Star"] + "</span>";
            return n + "</span>"
        },
        _setStars: function(e) {
            var t = this,
                a = arguments.length ? t.calculate(e) : t.calculate(),
                n = t.$element;
            return n.val(a.val), t.$filledStars.css("width", a.width), t._setCaption(a.caption), t.cache = a, n
        },
        showStars: function(e) {
            var t = this,
                a = parseFloat(e);
            return t.$element.val(isNaN(a) ? t.clearValue : a), t._setStars()
        },
        calculate: function(e) {
            var t = this,
                a = i(t.$element.val()) ? 0 : t.$element.val(),
                n = arguments.length ? t.getValueFromPosition(e) : a,
                r = t.fetchCaption(n),
                l = t.getWidthFromValue(n);
            return l += "%", {
                caption: r,
                width: l,
                val: n
            }
        },
        getValueFromPosition: function(e) {
            var t, a, n = this,
                r = o(n.step),
                i = n.$rating.width();
            return a = n.diff * e / (i * n.step), a = n.rtl ? Math.floor(a) : Math.ceil(a), t = c(parseFloat(n.min + a * n.step), r), t = Math.max(Math.min(t, n.max), n.min), n.rtl ? n.max - t : t
        },
        getWidthFromValue: function(e) {
            var t, a, n = this,
                r = n.min,
                i = n.max,
                l = n.$emptyStars;
            return !e || r >= e || r === i ? 0 : (a = l.outerWidth(), t = a ? l.width() / a : 1, e >= i ? 100 : (e - r) * t * 100 / (i - r))
        },
        fetchCaption: function(e) {
            var t, a, n, r, l, s = this,
                u = parseFloat(e) || s.clearValue,
                h = s.starCaptions,
                d = s.starCaptionClasses;
            return u && u !== s.clearValue && (u = c(u, o(s.step))), r = "function" == typeof d ? d(u) : d[u], n = "function" == typeof h ? h(u) : h[u], a = i(n) ? s.defaultCaption.replace(/\{rating}/g, u) : n, t = i(r) ? s.clearCaptionClass : r, l = u === s.clearValue ? s.clearCaption : a, '<span class="' + t + '">' + l + "</span>"
        },
        destroy: function() {
            var t = this,
                a = t.$element;
            return i(t.$container) || t.$container.before(a).remove(), e.removeData(a.get(0)), a.off("rating").removeClass("hide")
        },
        create: function(e) {
            var t = this,
                a = e || t.options || {};
            return t.destroy().rating(a)
        },
        clear: function() {
            var e = this,
                t = '<span class="' + e.clearCaptionClass + '">' + e.clearCaption + "</span>";
            return e.inactive || e._setCaption(t), e.showStars(e.clearValue).trigger("change").trigger("rating.clear")
        },
        reset: function() {
            var e = this;
            return e.showStars(e.initialValue).trigger("rating.reset")
        },
        update: function(e) {
            var t = this;
            return arguments.length ? t.showStars(e) : t.$element
        },
        refresh: function(t) {
            var a = this,
                n = a.$element;
            return t ? a.destroy().rating(e.extend(!0, a.options, t)).trigger("rating.refresh") : n
        }
    }, e.fn.rating = function(t) {
        var a = Array.apply(null, arguments),
            n = [];
        switch (a.shift(), this.each(function() {
            var r, l = e(this),
                s = l.data("rating"),
                o = "object" == typeof t && t,
                c = o.language || l.data("language") || "en",
                u = {};
            s || ("en" === c || i(e.fn.ratingLocales[c]) || (u = e.fn.ratingLocales[c]), r = e.extend(!0, {}, e.fn.rating.defaults, e.fn.ratingLocales.en, u, o, l.data()), s = new h(this, r), l.data("rating", s)), "string" == typeof t && n.push(s[t].apply(s, a))
        }), n.length) {
            case 0:
                return this;
            case 1:
                return void 0 === n[0] ? this : n[0];
            default:
                return n
        }
    }, e.fn.rating.defaults = {
        theme: "",
        language: "en",
        stars: 5,
        filledStar: '<i class="glyphicon glyphicon-star"></i>',
        emptyStar: '<i class="glyphicon glyphicon-star-empty"></i>',
        containerClass: "",
        size: "md",
        animate: !0,
        displayOnly: !1,
        rtl: !1,
        showClear: !0,
        showCaption: !0,
        starCaptionClasses: {.5: "label label-danger", 1: "label label-danger", 1.5: "label label-warning", 2: "label label-warning", 2.5: "label label-info", 3: "label label-info", 3.5: "label label-primary", 4: "label label-primary", 4.5: "label label-success", 5: "label label-success"
        },
        clearButton: '<i class="glyphicon glyphicon-minus-sign"></i>',
        clearButtonBaseClass: "clear-rating",
        clearButtonActiveClass: "clear-rating-active",
        clearCaptionClass: "label label-default",
        clearValue: null,
        captionElement: null,
        clearElement: null,
        hoverEnabled: !0,
        hoverChangeCaption: !0,
        hoverChangeStars: !0,
        hoverOnClear: !0
    }, e.fn.ratingLocales.en = {
        defaultCaption: "{rating} Bintang",
        starCaptions: {.5: "Setengah Bintang", 1: "Satu Bintang", 1.5: "Satu & Setengah Bintang", 2: "Dua Bintang", 2.5: "Dua & Setengah Bintang", 3: "Tiga Bintang", 3.5: "Tiga & Setengah Bintang", 4: "Empat Bintang", 4.5: "Empat & Setengah Bintang", 5: "Lima Bintang"
        },
        clearButtonTitle: "Clear",
        clearCaption: "Pilih Rating"
    }, e.fn.rating.Constructor = h, e(document).ready(function() {
        var t = e("input.rating");
        t.length && t.removeClass("rating-loading").addClass("rating-loading").rating()
    })
});