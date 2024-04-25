/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/accordion.js":
/*!*****************************!*\
  !*** ./src/js/accordion.js ***!
  \*****************************/
/***/ (() => {

(function () {
  "use strict";

  // Toggle accordion content
  $("body").on("click", "[data-tw-toggle='collapse']", function () {
    _toggle(this);
  });
  function _toggle(el) {
    var event = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "toggle";
    $(el).closest(".accordion").find("[data-tw-toggle='collapse']").each(function () {
      // Trigger "hide.tw.accordion" callback function
      if (!$(this).hasClass("collapsed") && this !== el && (event == "toggle" || event == "hide")) {
        var _event = new Event("hide.tw.accordion");
        $(this).closest(".accordion-header")[0].dispatchEvent(_event);
      }

      // Trigger "show.tw.accordion" callback function
      if ($(this).hasClass("collapsed") && this === el && (event == "toggle" || event == "show")) {
        var _event2 = new Event("show.tw.accordion");
        $(this).closest(".accordion-header")[0].dispatchEvent(_event2);
      }
    });
    var collapsed = $(el).hasClass("collapsed");

    // Close active accordion
    $(el).closest(".accordion").find(".accordion-collapse").slideUp(300, function (el) {
      $(el).removeClass("show");
      $(el).closest(".accordion-item").find("[data-tw-toggle='collapse']").addClass("collapsed").attr("aria-expanded", false);
    });

    // Set active accordion
    setTimeout(function () {
      var accordionCollapse = $(el).closest(".accordion-item").find(".accordion-collapse");
      var hide = function hide() {
        $(accordionCollapse).removeClass("show");
        $(el).addClass("collapsed").attr("aria-expanded", false);
        $(el).closest(".accordion-item").find(".accordion-collapse").slideUp();
      };
      var show = function show() {
        $(accordionCollapse).addClass("show");
        $(el).removeClass("collapsed").attr("aria-expanded", true);
        $(el).closest(".accordion-item").find(".accordion-collapse").slideDown();
      };
      if (event === "toggle") {
        !collapsed ? hide() : show();
      } else if (event === "show") {
        show();
      } else {
        hide();
      }
    }, 300);
  }

  // Create instance
  function createInstance(el) {
    return {
      show: function show() {
        _toggle(el, "show");
      },
      hide: function hide() {
        _toggle(el, "hide");
      },
      toggle: function toggle() {
        _toggle(el);
      }
    };
  }

  // Register instance
  (function init() {
    $("[data-tw-toggle='collapse']").each(function () {
      $(this).closest(".accordion-header")[0]["__accordion"] = createInstance(this);
    });
    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Accordion = {
      getInstance: function getInstance(el) {
        return el.__accordion;
      },
      getOrCreateInstance: function getOrCreateInstance(el) {
        return el.__accordion === undefined ? createInstance(el) : el.__accordion;
      }
    };
  })();
})();

/***/ }),

/***/ "./src/js/alert.js":
/*!*************************!*\
  !*** ./src/js/alert.js ***!
  \*************************/
/***/ (() => {

(function () {
  "use strict";

  // Close active alert
  $("body").on("click", "[data-tw-dismiss='alert']", function () {
    _hide($(this).closest(".alert"));
  });
  function _show(el) {
    $(el).fadeIn(300, function () {
      $(this).addClass("show");

      // Trigger "shown.tw.alert" callback function
      var event = new Event("shown.tw.alert");
      $(el)[0].dispatchEvent(event);
    });

    // Trigger "show.tw.alert" callback function
    var event = new Event("show.tw.alert");
    $(el)[0].dispatchEvent(event);
  }
  function _hide(el) {
    $(el).fadeOut(300, function () {
      $(this).removeClass("show");

      // Trigger "hidden.tw.alert" callback function
      var event = new Event("hidden.tw.alert");
      $(el)[0].dispatchEvent(event);
    });

    // Trigger "hide.tw.alert" callback function
    var event = new Event("hide.tw.alert");
    $(el)[0].dispatchEvent(event);
  }
  function _toggle(el) {
    $(el).hasClass("show") ? _hide(el) : _show(el);
  }

  // Create instance
  function createInstance(el) {
    return {
      show: function show() {
        _show(el);
      },
      hide: function hide() {
        _hide(el);
      },
      toggle: function toggle() {
        _toggle(el);
      }
    };
  }

  // Register instance
  (function init() {
    $(".alert").each(function () {
      this["__alert"] = createInstance(this);
    });
    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Alert = {
      getInstance: function getInstance(el) {
        return el.__alert;
      },
      getOrCreateInstance: function getOrCreateInstance(el) {
        return el.__alert === undefined ? createInstance(el) : el.__alert;
      }
    };
  })();
})();

/***/ }),

/***/ "./src/js/dropdown.js":
/*!****************************!*\
  !*** ./src/js/dropdown.js ***!
  \****************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
(function () {
  "use strict";

  // Hide dropdown
  function _hide() {
    $(".dropdown-menu").each( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
      var _this = this;
      var randId, dropdownToggle, event;
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            if (!($(this).attr("id") !== undefined && $('[data-dropdown-replacer="' + $(this).attr("id") + '"]').length && $(this).data("dropdown-programmatically") === undefined)) {
              _context.next = 10;
              break;
            }
            randId = $(this).attr("id");
            dropdownToggle = $('[data-dropdown-replacer="' + randId + '"]').parent().find("[data-tw-toggle='dropdown']"); // Animate dropdown
            $(this).removeClass("show");

            // Trigger "hide.tw.dropdown" callback function
            event = new Event("hide.tw.dropdown");
            $(dropdownToggle).parent()[0].dispatchEvent(event);
            _context.next = 8;
            return setTimeout(function () {
              // Move dropdown element to body
              $('[data-dropdown-replacer="' + randId + '"]').replaceWith(_this);

              // Reset attribute
              $(_this).removeAttr("style");
              $(_this).removeAttr("data-popper-placement");

              // Set aria-expanded to false
              $(dropdownToggle).attr("aria-expanded", false);

              // Trigger "hidden.tw.dropdown" callback function
              var event = new Event("hidden.tw.dropdown");
              $(dropdownToggle).parent()[0].dispatchEvent(event);
            }, 200);
          case 8:
            _context.next = 11;
            break;
          case 10:
            if ($(this).attr("id") !== undefined && !$('[data-dropdown-replacer="' + $(this).attr("id") + '"]').length && $(this).hasClass("show") && $(this).data("dropdown-programmatically") === undefined) {
              $(this).remove();
            } else if ($(this).data("dropdown-programmatically") == "initiate") {
              // Set programmatically attribute state
              $(this).attr("data-dropdown-programmatically", "showed");
            } else if ($(this).data("dropdown-programmatically") == "showed") {
              // Remove programmatically attribute state
              $(this).removeAttr("data-dropdown-programmatically");

              // Hide dropdown
              _hide();
            }
          case 11:
          case "end":
            return _context.stop();
        }
      }, _callee, this);
    })));
  }

  // Find visible dropdown toggle
  function findVisibleDropdownToggle(dropdownToggle) {
    return dropdownToggle.filter(function (key, dropdownToggle) {
      return dropdownToggle.offsetParent !== null;
    });
  }

  // Show dropdown
  function show(_x) {
    return _show.apply(this, arguments);
  } // Toggle dropdown programmatically
  function _show() {
    _show = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(dropdown) {
      var dropdownBox, dropdownToggle, placement, randId, event;
      return _regeneratorRuntime().wrap(function _callee2$(_context2) {
        while (1) switch (_context2.prev = _context2.next) {
          case 0:
            dropdownBox = $(dropdown).find(".dropdown-menu").first();
            dropdownToggle = findVisibleDropdownToggle($(dropdown).find("[data-tw-toggle='dropdown']"));
            placement = $(dropdown).data("tw-placement") ? $(dropdown).data("tw-placement") : "bottom-end";
            randId = "_" + Math.random().toString(36).substr(2, 9); // Hide dropdown
            _hide();
            if (!$(dropdownBox).length) {
              _context2.next = 19;
              break;
            }
            // Set aria-expanded to true
            $(dropdownToggle).attr("aria-expanded", true);

            // Set dropdown width
            $(dropdown).css("position") == "static" ? $(dropdown).css("position", "relative") : "";
            $(dropdownBox).show();
            $(dropdownBox).css("width", $(dropdownBox).css("width"));

            // Move dropdown element to body
            $('<div data-dropdown-replacer="' + randId + '"></div>').insertAfter(dropdownBox);
            $(dropdownBox).attr("id", randId).appendTo("body");

            // Check if dropdown is used inside modal
            $(".modal.show").each(function () {
              if ($(this).find('[data-dropdown-replacer="' + randId + '"]')) {
                $(dropdownBox).css("z-index", $(this).css("z-index"));
              }
            });

            // Init popper
            Popper.createPopper(dropdownToggle[0], dropdownBox[0], {
              placement: placement
            });

            // Show dropdown
            $(dropdownBox).addClass("show");

            // Trigger "show.tw.dropdown" callback function
            event = new Event("show.tw.dropdown");
            $(dropdown)[0].dispatchEvent(event);
            _context2.next = 19;
            return setTimeout(function () {
              // Trigger "shown.tw.dropdown" callback function
              var event = new Event("shown.tw.dropdown");
              $(dropdown)[0].dispatchEvent(event);
            }, 200);
          case 19:
          case "end":
            return _context2.stop();
        }
      }, _callee2);
    }));
    return _show.apply(this, arguments);
  }
  function toggleProgrammatically(dropdown) {
    var dropdownBox = $(dropdown).find(".dropdown-menu").first();
    if ($(dropdownBox).length) {
      showProgrammatically(dropdown);
    } else {
      _hide();
    }
  }

  // Show dropdown programmatically
  function showProgrammatically(dropdown) {
    if ($(dropdown).find(".dropdown-menu").length) {
      $(dropdown).find(".dropdown-menu").attr("data-dropdown-programmatically", "initiate");
    } else {
      var randId = $("[data-dropdown-replacer]").data("dropdown-replacer");
      $("#" + randId).attr("data-dropdown-programmatically", "initiate");
    }
    show(dropdown);
  }

  // Create instance
  function createInstance(dropdownToggle) {
    var dropdown = $(dropdownToggle).closest(".dropdown");
    return {
      show: function show() {
        showProgrammatically(dropdown);
      },
      hide: function hide() {
        _hide();
      },
      toggle: function toggle() {
        toggleProgrammatically(dropdown);
      }
    };
  }

  // Dropdown event listener
  $("body").on("click", function (event) {
    var dropdown = $(event.target).closest(".dropdown");
    var dropdownToggle = $(dropdown).find("[data-tw-toggle='dropdown']");
    var dropdownBox = $(dropdown).find(".dropdown-menu").first();
    var activeDropdownBox = $(event.target).closest(".dropdown-menu").first();
    var dismissButton = $(event.target).data("tw-dismiss");
    if (!$(dropdown).length && !$(activeDropdownBox).length || $(dropdownToggle).length && !$(dropdownBox).length || dismissButton == "dropdown") {
      // Hide dropdown
      _hide();
    } else if (!$(activeDropdownBox).length) {
      // Show dropdown
      show(dropdown);
    }
  });

  // Keyboard event
  document.addEventListener("keydown", function (event) {
    if (event.code == "Escape") {
      _hide();
    }
  });

  // Register instance
  (function init() {
    $("[data-tw-toggle='dropdown']").each(function () {
      this["__dropdown"] = createInstance(this);
    });
    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Dropdown = {
      getInstance: function getInstance(el) {
        return el.__dropdown;
      },
      getOrCreateInstance: function getOrCreateInstance(el) {
        return el.__dropdown === undefined ? createInstance(el) : el.__dropdown;
      }
    };
  })();
})();

/***/ }),

/***/ "./src/js/modal.js":
/*!*************************!*\
  !*** ./src/js/modal.js ***!
  \*************************/
/***/ (() => {

(function () {
  // Get highest z-index
  function getHighestZindex() {
    var zIndex = 9999;
    $(".modal").each(function () {
      if ($(this).css("z-index") !== "auto" && $(this).css("z-index") > zIndex) {
        zIndex = parseInt($(this).css("z-index"));
      }
    });
    return zIndex;
  }

  // Get scrollbar width
  function getScrollbarWidth(el) {
    return window.innerWidth - $(el)[0].clientWidth;
  }

  // Show modal with z-index
  function _show(el) {
    if (!$("[data-modal-replacer='" + $(el).attr("id") + "']").length) {
      // Move modal element to body
      $('<div data-modal-replacer="' + $(el).attr("id") + '"></div>').insertAfter(el);
      $(el).css({
        "margin-top": 0,
        "margin-left": 0
      });
      $(el).attr("aria-hidden", false).appendTo("body");

      // Show modal by highest z-index
      setTimeout(function () {
        $(el).addClass("show").css("z-index", getHighestZindex() + 1);

        // Trigger "shown.tw.modal" callback function
        var event = new Event("shown.tw.modal");
        $(el)[0].dispatchEvent(event);
      }, 200);

      // Setting up modal scroll
      $("body").css("padding-right", parseInt($("body").css("padding-right")) + getScrollbarWidth("html") + "px").addClass("overflow-y-hidden");
      $(".modal").removeClass("overflow-y-auto").css("padding-left", "0px");
      $(el).addClass("overflow-y-auto").css("padding-left", getScrollbarWidth(el) + "px").addClass($(".modal.show").length ? "modal-overlap" : "");

      // Trigger "show.tw.modal" callback function
      var event = new Event("show.tw.modal");
      $(el)[0].dispatchEvent(event);
    }
  }

  // Hide modal & remove modal scroll
  function _hide(el) {
    if ($(el).hasClass("modal") && $(el).hasClass("show")) {
      var transitionDuration = parseFloat($(el).css("transition-duration").split(",")[1]) * 1000;
      $(el).attr("aria-hidden", true).removeClass("show");
      setTimeout(function () {
        $(el).removeAttr("style").removeClass("modal-overlap").removeClass("overflow-y-auto");

        // Add scroll to highest z-index modal if exist
        $(".modal").each(function () {
          if (parseInt($(this).css("z-index")) === getHighestZindex()) {
            $(this).addClass("overflow-y-auto").css("padding-left", getScrollbarWidth(this) + "px");
          }
        });

        // Return back scroll to body if no more modal showed up
        if (getHighestZindex() == 9999) {
          $("body").removeClass("overflow-y-hidden").css("padding-right", "");
        }

        // Return back modal element to it's first place
        $('[data-modal-replacer="' + $(el).attr("id") + '"]').replaceWith(el);

        // Trigger "hidden.tw.modal" callback function
        var event = new Event("hidden.tw.modal");
        $(el)[0].dispatchEvent(event);
      }, transitionDuration);

      // Trigger "hide.tw.modal" callback function
      var event = new Event("hide.tw.modal");
      $(el)[0].dispatchEvent(event);
    }
  }

  // Toggle modal
  function _toggle(el) {
    if ($(el).hasClass("modal") && $(el).hasClass("show")) {
      _hide(el);
    } else {
      _show(el);
    }
  }

  // Create instance
  function createInstance(el) {
    return {
      show: function show() {
        _show(el);
      },
      hide: function hide() {
        _hide(el);
      },
      toggle: function toggle() {
        _toggle(el);
      }
    };
  }

  // Show modal
  $("body").on("click", '[data-tw-toggle="modal"]', function () {
    _show($(this).attr("data-tw-target"));
  });

  // Hide modal
  $("body").on("click", function (event) {
    if ($(event.target).hasClass("modal") && $(event.target).hasClass("show")) {
      // Check if modal backdrop is not static
      if ($(event.target).data("tw-backdrop") !== "static") {
        _hide(event.target);
      } else {
        $(event.target).addClass("modal-static");
        setTimeout(function () {
          $(event.target).removeClass("modal-static");
        }, 600);
      }
    }
  });

  // Dismiss modal by link
  $("body").on("click", '[data-tw-dismiss="modal"]', function () {
    var modal = $(this).closest(".modal")[0];
    _hide(modal);
  });

  // Keyboard event
  document.addEventListener("keydown", function (event) {
    if (event.code == "Escape") {
      var el = $(".modal.show").last();
      if ($(el).hasClass("modal") && $(el).hasClass("show") && ($(el).data("tw-keyboard") === undefined || $(el).data("tw-keyboard") !== "false")) {
        // Check if modal backdrop is not static
        if ($(el).data("tw-backdrop") !== "static") {
          _hide(el);
        } else {
          $(el).addClass("modal-static");
          setTimeout(function () {
            $(el).removeClass("modal-static");
          }, 600);
        }
      }
    }
  });

  // Register instance
  (function init() {
    $(".modal").each(function () {
      this["__modal"] = createInstance(this);
    });
    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Modal = {
      getInstance: function getInstance(el) {
        return el.__modal;
      },
      getOrCreateInstance: function getOrCreateInstance(el) {
        return el.__modal === undefined ? createInstance(el) : el.__modal;
      }
    };
  })();
})();

/***/ }),

/***/ "./src/js/starter.js":
/*!***************************!*\
  !*** ./src/js/starter.js ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _accordion__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./accordion */ "./src/js/accordion.js");
/* harmony import */ var _accordion__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_accordion__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./alert */ "./src/js/alert.js");
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_alert__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _dropdown__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./dropdown */ "./src/js/dropdown.js");
/* harmony import */ var _dropdown__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_dropdown__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modal */ "./src/js/modal.js");
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_modal__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _svg_loader__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./svg-loader */ "./src/js/svg-loader.js");
/* harmony import */ var _svg_loader__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_svg_loader__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _tab__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./tab */ "./src/js/tab.js");
/* harmony import */ var _tab__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_tab__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _transition__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./transition */ "./src/js/transition.js");
/* harmony import */ var _transition__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_transition__WEBPACK_IMPORTED_MODULE_6__);








/***/ }),

/***/ "./src/js/svg-loader.js":
/*!******************************!*\
  !*** ./src/js/svg-loader.js ***!
  \******************************/
/***/ (() => {

(function () {
  "use strict";

  var initSvgLoader = function svgLoader(init) {
    $("[data-loading-icon]").each(function () {
      var color = $(this).data("color") !== undefined ? $(this).data("color") : $("body").css("color");
      var classAttr = $(this).attr("class") !== undefined ? $(this).attr("class") : "";
      var icons = [{
        name: "audio",
        svg: "\n                    <svg width=\"15\" viewBox=\"0 0 55 80\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <g transform=\"matrix(1 0 0 -1 0 80)\">\n                            <rect width=\"10\" height=\"20\" rx=\"3\">\n                                <animate attributeName=\"height\"\n                                    begin=\"0s\" dur=\"4.3s\"\n                                    values=\"20;45;57;80;64;32;66;45;64;23;66;13;64;56;34;34;2;23;76;79;20\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </rect>\n                            <rect x=\"15\" width=\"10\" height=\"80\" rx=\"3\">\n                                <animate attributeName=\"height\"\n                                    begin=\"0s\" dur=\"2s\"\n                                    values=\"80;55;33;5;75;23;73;33;12;14;60;80\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </rect>\n                            <rect x=\"30\" width=\"10\" height=\"50\" rx=\"3\">\n                                <animate attributeName=\"height\"\n                                    begin=\"0s\" dur=\"1.4s\"\n                                    values=\"50;34;78;23;56;23;34;76;80;54;21;50\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </rect>\n                            <rect x=\"45\" width=\"10\" height=\"30\" rx=\"3\">\n                                <animate attributeName=\"height\"\n                                    begin=\"0s\" dur=\"2s\"\n                                    values=\"30;45;13;80;56;72;45;76;34;23;67;30\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </rect>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "ball-triangle",
        svg: "\n                    <svg width=\"20\" viewBox=\"0 0 57 57\" xmlns=\"http://www.w3.org/2000/svg\" class=\"".concat(classAttr, "\">\n                        <g fill=\"none\" fill-rule=\"evenodd\">\n                            <g transform=\"translate(1 1)\">\n                                <circle cx=\"5\" cy=\"50\" r=\"5\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"cy\"\n                                        begin=\"0s\" dur=\"2.2s\"\n                                        values=\"50;5;50;50\"\n                                        calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                    <animate attributeName=\"cx\"\n                                        begin=\"0s\" dur=\"2.2s\"\n                                        values=\"5;27;49;5\"\n                                        calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"27\" cy=\"5\" r=\"5\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"cy\"\n                                        begin=\"0s\" dur=\"2.2s\"\n                                        from=\"5\" to=\"5\"\n                                        values=\"5;50;50;5\"\n                                        calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                    <animate attributeName=\"cx\"\n                                        begin=\"0s\" dur=\"2.2s\"\n                                        from=\"27\" to=\"27\"\n                                        values=\"27;49;5;27\"\n                                        calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"49\" cy=\"50\" r=\"5\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"cy\"\n                                        begin=\"0s\" dur=\"2.2s\"\n                                        values=\"50;50;5;50\"\n                                        calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                    <animate attributeName=\"cx\"\n                                        from=\"49\" to=\"49\"\n                                        begin=\"0s\" dur=\"2.2s\"\n                                        values=\"49;5;27;49\"\n                                        calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                            </g>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "bars",
        svg: "\n                    <svg width=\"20\" viewBox=\"0 0 135 140\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <rect y=\"10\" width=\"15\" height=\"120\" rx=\"6\">\n                            <animate attributeName=\"height\"\n                                begin=\"0.5s\" dur=\"1s\"\n                                values=\"120;110;100;90;80;70;60;50;40;140;120\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                            <animate attributeName=\"y\"\n                                begin=\"0.5s\" dur=\"1s\"\n                                values=\"10;15;20;25;30;35;40;45;50;0;10\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </rect>\n                        <rect x=\"30\" y=\"10\" width=\"15\" height=\"120\" rx=\"6\">\n                            <animate attributeName=\"height\"\n                                begin=\"0.25s\" dur=\"1s\"\n                                values=\"120;110;100;90;80;70;60;50;40;140;120\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                            <animate attributeName=\"y\"\n                                begin=\"0.25s\" dur=\"1s\"\n                                values=\"10;15;20;25;30;35;40;45;50;0;10\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </rect>\n                        <rect x=\"60\" width=\"15\" height=\"140\" rx=\"6\">\n                            <animate attributeName=\"height\"\n                                begin=\"0s\" dur=\"1s\"\n                                values=\"120;110;100;90;80;70;60;50;40;140;120\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                            <animate attributeName=\"y\"\n                                begin=\"0s\" dur=\"1s\"\n                                values=\"10;15;20;25;30;35;40;45;50;0;10\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </rect>\n                        <rect x=\"90\" y=\"10\" width=\"15\" height=\"120\" rx=\"6\">\n                            <animate attributeName=\"height\"\n                                begin=\"0.25s\" dur=\"1s\"\n                                values=\"120;110;100;90;80;70;60;50;40;140;120\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                            <animate attributeName=\"y\"\n                                begin=\"0.25s\" dur=\"1s\"\n                                values=\"10;15;20;25;30;35;40;45;50;0;10\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </rect>\n                        <rect x=\"120\" y=\"10\" width=\"15\" height=\"120\" rx=\"6\">\n                            <animate attributeName=\"height\"\n                                begin=\"0.5s\" dur=\"1s\"\n                                values=\"120;110;100;90;80;70;60;50;40;140;120\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                            <animate attributeName=\"y\"\n                                begin=\"0.5s\" dur=\"1s\"\n                                values=\"10;15;20;25;30;35;40;45;50;0;10\" calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </rect>\n                    </svg>\n                ")
      }, {
        name: "circles",
        svg: "\n                    <svg width=\"20\" viewBox=\"0 0 135 135\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <path d=\"M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z\">\n                            <animateTransform\n                                attributeName=\"transform\"\n                                type=\"rotate\"\n                                from=\"0 67 67\"\n                                to=\"-360 67 67\"\n                                dur=\"2.5s\"\n                                repeatCount=\"indefinite\"/>\n                        </path>\n                        <path d=\"M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z\">\n                            <animateTransform\n                                attributeName=\"transform\"\n                                type=\"rotate\"\n                                from=\"0 67 67\"\n                                to=\"360 67 67\"\n                                dur=\"8s\"\n                                repeatCount=\"indefinite\"/>\n                        </path>\n                    </svg>\n                ")
      }, {
        name: "grid",
        svg: "\n                    <svg width=\"20\" viewBox=\"0 0 105 105\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <circle cx=\"12.5\" cy=\"12.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"0s\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"12.5\" cy=\"52.5\" r=\"12.5\" fill-opacity=\".5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"100ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"52.5\" cy=\"12.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"300ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"52.5\" cy=\"52.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"600ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"92.5\" cy=\"12.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"800ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"92.5\" cy=\"52.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"400ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"12.5\" cy=\"92.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"700ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"52.5\" cy=\"92.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"500ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"92.5\" cy=\"92.5\" r=\"12.5\">\n                            <animate attributeName=\"fill-opacity\"\n                            begin=\"200ms\" dur=\"1s\"\n                            values=\"1;.2;1\" calcMode=\"linear\"\n                            repeatCount=\"indefinite\" />\n                        </circle>\n                    </svg>\n                ")
      }, {
        name: "hearts",
        svg: "\n                    <svg width=\"30\" viewBox=\"0 0 140 64\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <path d=\"M30.262 57.02L7.195 40.723c-5.84-3.976-7.56-12.06-3.842-18.063 3.715-6 11.467-7.65 17.306-3.68l4.52 3.76 2.6-5.274c3.717-6.002 11.47-7.65 17.305-3.68 5.84 3.97 7.56 12.054 3.842 18.062L34.49 56.118c-.897 1.512-2.793 1.915-4.228.9z\" fill-opacity=\".5\">\n                            <animate attributeName=\"fill-opacity\"\n                                begin=\"0s\" dur=\"1.4s\"\n                                values=\"0.5;1;0.5\"\n                                calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </path>\n                        <path d=\"M105.512 56.12l-14.44-24.272c-3.716-6.008-1.996-14.093 3.843-18.062 5.835-3.97 13.588-2.322 17.306 3.68l2.6 5.274 4.52-3.76c5.84-3.97 13.592-2.32 17.307 3.68 3.718 6.003 1.998 14.088-3.842 18.064L109.74 57.02c-1.434 1.014-3.33.61-4.228-.9z\" fill-opacity=\".5\">\n                            <animate attributeName=\"fill-opacity\"\n                                begin=\"0.7s\" dur=\"1.4s\"\n                                values=\"0.5;1;0.5\"\n                                calcMode=\"linear\"\n                                repeatCount=\"indefinite\" />\n                        </path>\n                        <path d=\"M67.408 57.834l-23.01-24.98c-5.864-6.15-5.864-16.108 0-22.248 5.86-6.14 15.37-6.14 21.234 0L70 16.168l4.368-5.562c5.863-6.14 15.375-6.14 21.235 0 5.863 6.14 5.863 16.098 0 22.247l-23.007 24.98c-1.43 1.556-3.757 1.556-5.188 0z\" />\n                    </svg>\n                ")
      }, {
        name: "oval",
        svg: "\n                    <svg width=\"25\" viewBox=\"-2 -2 42 42\" xmlns=\"http://www.w3.org/2000/svg\" stroke=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <g fill=\"none\" fill-rule=\"evenodd\">\n                            <g transform=\"translate(1 1)\" stroke-width=\"4\">\n                                <circle stroke-opacity=\".5\" cx=\"18\" cy=\"18\" r=\"18\"/>\n                                <path d=\"M36 18c0-9.94-8.06-18-18-18\">\n                                    <animateTransform\n                                        attributeName=\"transform\"\n                                        type=\"rotate\"\n                                        from=\"0 18 18\"\n                                        to=\"360 18 18\"\n                                        dur=\"1s\"\n                                        repeatCount=\"indefinite\"/>\n                                </path>\n                            </g>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "puff",
        svg: "\n                    <svg width=\"25\" viewBox=\"0 0 44 44\" xmlns=\"http://www.w3.org/2000/svg\" stroke=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <g fill=\"none\" fill-rule=\"evenodd\" stroke-width=\"4\">\n                            <circle cx=\"22\" cy=\"22\" r=\"1\">\n                                <animate attributeName=\"r\"\n                                    begin=\"0s\" dur=\"1.8s\"\n                                    values=\"1; 20\"\n                                    calcMode=\"spline\"\n                                    keyTimes=\"0; 1\"\n                                    keySplines=\"0.165, 0.84, 0.44, 1\"\n                                    repeatCount=\"indefinite\" />\n                                <animate attributeName=\"stroke-opacity\"\n                                    begin=\"0s\" dur=\"1.8s\"\n                                    values=\"1; 0\"\n                                    calcMode=\"spline\"\n                                    keyTimes=\"0; 1\"\n                                    keySplines=\"0.3, 0.61, 0.355, 1\"\n                                    repeatCount=\"indefinite\" />\n                            </circle>\n                            <circle cx=\"22\" cy=\"22\" r=\"1\">\n                                <animate attributeName=\"r\"\n                                    begin=\"-0.9s\" dur=\"1.8s\"\n                                    values=\"1; 20\"\n                                    calcMode=\"spline\"\n                                    keyTimes=\"0; 1\"\n                                    keySplines=\"0.165, 0.84, 0.44, 1\"\n                                    repeatCount=\"indefinite\" />\n                                <animate attributeName=\"stroke-opacity\"\n                                    begin=\"-0.9s\" dur=\"1.8s\"\n                                    values=\"1; 0\"\n                                    calcMode=\"spline\"\n                                    keyTimes=\"0; 1\"\n                                    keySplines=\"0.3, 0.61, 0.355, 1\"\n                                    repeatCount=\"indefinite\" />\n                            </circle>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "rings",
        svg: "\n                    <svg width=\"30\" viewBox=\"0 0 45 45\" xmlns=\"http://www.w3.org/2000/svg\" stroke=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <g fill=\"none\" fill-rule=\"evenodd\" transform=\"translate(1 1)\" stroke-width=\"3\">\n                            <circle cx=\"22\" cy=\"22\" r=\"6\" stroke-opacity=\"0\">\n                                <animate attributeName=\"r\"\n                                    begin=\"1.5s\" dur=\"3s\"\n                                    values=\"6;22\"\n                                    calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                                <animate attributeName=\"stroke-opacity\"\n                                    begin=\"1.5s\" dur=\"3s\"\n                                    values=\"1;0\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                                <animate attributeName=\"stroke-width\"\n                                    begin=\"1.5s\" dur=\"3s\"\n                                    values=\"2;0\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </circle>\n                            <circle cx=\"22\" cy=\"22\" r=\"6\" stroke-opacity=\"0\">\n                                <animate attributeName=\"r\"\n                                    begin=\"3s\" dur=\"3s\"\n                                    values=\"6;22\"\n                                    calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                                <animate attributeName=\"stroke-opacity\"\n                                    begin=\"3s\" dur=\"3s\"\n                                    values=\"1;0\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                                <animate attributeName=\"stroke-width\"\n                                    begin=\"3s\" dur=\"3s\"\n                                    values=\"2;0\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </circle>\n                            <circle cx=\"22\" cy=\"22\" r=\"8\">\n                                <animate attributeName=\"r\"\n                                    begin=\"0s\" dur=\"1.5s\"\n                                    values=\"6;1;2;3;4;5;6\"\n                                    calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            </circle>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "spinning-circles",
        svg: "\n                    <svg width=\"20\" viewBox=\"0 0 58 58\" xmlns=\"http://www.w3.org/2000/svg\" class=\"".concat(classAttr, "\">\n                        <g fill=\"none\" fill-rule=\"evenodd\">\n                            <g transform=\"translate(2 1)\" stroke=\"").concat(color, "\" stroke-width=\"1.5\">\n                                <circle cx=\"42.601\" cy=\"11.462\" r=\"5\" fill-opacity=\"1\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"1;0;0;0;0;0;0;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"49.063\" cy=\"27.063\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;1;0;0;0;0;0;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"42.601\" cy=\"42.663\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;0;1;0;0;0;0;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"27\" cy=\"49.125\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;0;0;1;0;0;0;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"11.399\" cy=\"42.663\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;0;0;0;1;0;0;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"4.938\" cy=\"27.063\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;0;0;0;0;1;0;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"11.399\" cy=\"11.462\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;0;0;0;0;0;1;0\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                                <circle cx=\"27\" cy=\"5\" r=\"5\" fill-opacity=\"0\" fill=\"").concat(color, "\">\n                                    <animate attributeName=\"fill-opacity\"\n                                        begin=\"0s\" dur=\"1.3s\"\n                                        values=\"0;0;0;0;0;0;0;1\" calcMode=\"linear\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                            </g>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "tail-spin",
        svg: "\n                    <svg width=\"20\" viewBox=\"0 0 38 38\" xmlns=\"http://www.w3.org/2000/svg\" class=\"".concat(classAttr, "\">\n                        <defs>\n                            <linearGradient x1=\"8.042%\" y1=\"0%\" x2=\"65.682%\" y2=\"23.865%\" id=\"a\">\n                                <stop stop-color=\"").concat(color, "\" stop-opacity=\"0\" offset=\"0%\"/>\n                                <stop stop-color=\"").concat(color, "\" stop-opacity=\".631\" offset=\"63.146%\"/>\n                                <stop stop-color=\"").concat(color, "\" offset=\"100%\"/>\n                            </linearGradient>\n                        </defs>\n                        <g fill=\"none\" fill-rule=\"evenodd\">\n                            <g transform=\"translate(1 1)\">\n                                <path d=\"M36 18c0-9.94-8.06-18-18-18\" id=\"Oval-2\" stroke=\"url(#a)\" stroke-width=\"3\">\n                                    <animateTransform\n                                        attributeName=\"transform\"\n                                        type=\"rotate\"\n                                        from=\"0 18 18\"\n                                        to=\"360 18 18\"\n                                        dur=\"0.9s\"\n                                        repeatCount=\"indefinite\" />\n                                </path>\n                                <circle fill=\"").concat(color, "\" cx=\"36\" cy=\"18\" r=\"1\">\n                                    <animateTransform\n                                        attributeName=\"transform\"\n                                        type=\"rotate\"\n                                        from=\"0 18 18\"\n                                        to=\"360 18 18\"\n                                        dur=\"0.9s\"\n                                        repeatCount=\"indefinite\" />\n                                </circle>\n                            </g>\n                        </g>\n                    </svg>\n                ")
      }, {
        name: "three-dots",
        svg: "\n                    <svg width=\"25\" viewBox=\"0 0 120 30\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"".concat(color, "\" class=\"").concat(classAttr, "\">\n                        <circle cx=\"15\" cy=\"15\" r=\"15\">\n                            <animate attributeName=\"r\" from=\"15\" to=\"15\"\n                                    begin=\"0s\" dur=\"0.8s\"\n                                    values=\"15;9;15\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            <animate attributeName=\"fill-opacity\" from=\"1\" to=\"1\"\n                                    begin=\"0s\" dur=\"0.8s\"\n                                    values=\"1;.5;1\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"60\" cy=\"15\" r=\"9\" fill-opacity=\"0.3\">\n                            <animate attributeName=\"r\" from=\"9\" to=\"9\"\n                                    begin=\"0s\" dur=\"0.8s\"\n                                    values=\"9;15;9\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            <animate attributeName=\"fill-opacity\" from=\"0.5\" to=\"0.5\"\n                                    begin=\"0s\" dur=\"0.8s\"\n                                    values=\".5;1;.5\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                        </circle>\n                        <circle cx=\"105\" cy=\"15\" r=\"15\">\n                            <animate attributeName=\"r\" from=\"15\" to=\"15\"\n                                    begin=\"0s\" dur=\"0.8s\"\n                                    values=\"15;9;15\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                            <animate attributeName=\"fill-opacity\" from=\"1\" to=\"1\"\n                                    begin=\"0s\" dur=\"0.8s\"\n                                    values=\"1;.5;1\" calcMode=\"linear\"\n                                    repeatCount=\"indefinite\" />\n                        </circle>\n                    </svg>\n                ")
      }];
      var self = this;
      icons.forEach(function (icon) {
        if ($(self).data("loading-icon") == icon.name) {
          $(self).replaceWith(icon.svg);
        }
      });
    });
    return svgLoader;
  }();

  // Register instance
  (function init() {
    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.svgLoader = function () {
      initSvgLoader();
    };
  })();
})();

/***/ }),

/***/ "./src/js/tab.js":
/*!***********************!*\
  !*** ./src/js/tab.js ***!
  \***********************/
/***/ (() => {

(function () {
  "use strict";

  // Show tab content
  $("body").on("click", "[role='tab']", function () {
    _show(this);
  });
  function _show(el) {
    $(el).closest("[role='tablist']").find("[role='tab']").each(function () {
      // Trigger "hide.tw.tab" callback function
      if ($(this).hasClass("active") && this !== el) {
        var event = new Event("hide.tw.tab");
        $(this)[0].dispatchEvent(event);
      }

      // Trigger "show.tw.tab" callback function
      if (!$(this).hasClass("active") && this === el) {
        var _event = new Event("show.tw.tab");
        $(this)[0].dispatchEvent(_event);
      }
    });

    // Set active tab nav
    $(el).closest("[role='tablist']").find("[role='tab']").removeClass("active").attr("aria-selected", false);
    $(el).addClass("active").attr("aria-selected", true);

    // Set active tab content
    var elementId = $(el).attr("data-tw-target");
    var tabContentWidth = $(elementId).closest(".tab-content").width();
    $(elementId).closest(".tab-content").children(".tab-pane").removeAttr("style").removeClass("active");
    $(elementId).css("width", tabContentWidth + "px").addClass("active");
  }

  // On window resized
  (function onResized(el) {
    addEventListener("resize", function (event) {
      $("[role='tabpanel']").each(function () {
        if ($(this).hasClass("active")) {
          var tabContentWidth = $(this).closest(".tab-content").width();
          $(this).css("width", tabContentWidth + "px");
        }
      });
    });
  })();

  // Create instance
  function createInstance(el) {
    return {
      show: function show() {
        _show(el);
      }
    };
  }

  // Register instance
  (function init() {
    $("[role='tab']").each(function () {
      this["__tab"] = createInstance(this);
    });
    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Tab = {
      getInstance: function getInstance(el) {
        return el.__tab;
      },
      getOrCreateInstance: function getOrCreateInstance(el) {
        return el.__tab === undefined ? createInstance(el) : el.__tab;
      }
    };
  })();
})();

/***/ }),

/***/ "./src/js/transition.js":
/*!******************************!*\
  !*** ./src/js/transition.js ***!
  \******************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
(function () {
  "use strict";

  function init(el) {
    var targetEl = $(el).clone().html("");
    var isShown = $($("<div></div>").append(targetEl)).find($(targetEl).data("selector")).length;
    if ($(el).data("state") === undefined) {
      $(el).data("state", !isShown ? "enter" : "leave");
      !isShown ? $(el).hide() : $(el).show();
    }
    if (isShown && $(el).data("state") === "leave") {
      $(el).data("state", "enter");
      $(el).show();

      // Enter
      $(el).addClass($(el).data("enter-from"));
      setTimeout(function () {
        $(el).addClass($(el).data("enter"));
        $(el).addClass($(el).data("enter-to"));
        $(el).removeClass($(el).data("enter-from"));
        setTimeout(function () {
          $(el).removeClass($(el).data("enter"));
        }, parseFloat($(el).css("transition-duration")) * 1000);
      });
    } else if (!isShown && $(el).data("state") === "enter") {
      $(el).data("state", "leave");

      // Leave
      $(el).addClass($(el).data("leave-from"));
      setTimeout(function () {
        $(el).addClass($(el).data("leave"));
        $(el).addClass($(el).data("leave-to"));
        $(el).removeClass($(el).data("leave-from"));
        setTimeout(function () {
          $(el).removeClass($(el).data("leave"));
          $(el).attr("class", ($(el).attr("class") !== undefined ? $(el).attr("class") : "").split(" ").filter(function (value) {
            return value.search("mt-") === -1;
          }).join(" "));
          setTimeout(function () {
            $(el).hide();
          }, 100);
        }, parseFloat($(el).css("transition-duration")) * 1000);
      });
    }
  }
  var observer = new MutationObserver(function (mutationList) {
    mutationList.forEach( /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(mutation) {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (mutation.type === "attributes") {
                init(mutation.target);
              }
            case 1:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }));
      return function (_x) {
        return _ref.apply(this, arguments);
      };
    }());
  });
  $("[data-transition]").each(function () {
    observer.observe(this, {
      attributes: true
    });
    init(this);
  });
})();

/***/ }),

/***/ "./src/css/starter.css":
/*!*****************************!*\
  !*** ./src/css/starter.css ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 			"/public/dist/js/starter": 0,
/******/ 			"public/dist/css/starter": 0
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
/******/ 		var chunkLoadingGlobal = self["webpackChunk_left4code_tw_starter"] = self["webpackChunk_left4code_tw_starter"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["public/dist/css/starter"], () => (__webpack_require__("./src/js/starter.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["public/dist/css/starter"], () => (__webpack_require__("./src/css/starter.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;