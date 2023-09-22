
"use strict";

// Class definition
var KTEventHandler = function() {
////////////////////////////
// ** Private Variables  ** //
////////////////////////////
var _handlers = {};

////////////////////////////
// ** Private Methods  ** //
////////////////////////////
var _triggerEvent = function(element, name, target) {
var returnValue = true;
var eventValue;

if ( KTUtil.data(element).has(name) === true ) {
    var handlerIds = KTUtil.data(element).get(name);
    var handlerId;

    for (var i = 0; i < handlerIds.length; i++) {
        handlerId = handlerIds[i];
        
        if ( _handlers[name] && _handlers[name][handlerId] ) {
            var handler = _handlers[name][handlerId];
            var value;

            if ( handler.name === name ) {
                if ( handler.one == true ) {
                    if ( handler.fired == false ) {
                        _handlers[name][handlerId].fired = true;

                        eventValue = handler.callback.call(this, target);
                    }
                } else {
                    eventValue = handler.callback.call(this, target);
                }

                if ( eventValue === false ) {
                    returnValue = false;
                }
            }
        }
    }            
}

return returnValue;
}

var _addEvent = function(element, name, callback, one) {
var handlerId = KTUtil.getUniqueId('event');
var handlerIds = KTUtil.data(element).get(name);

if ( !handlerIds ) {
    handlerIds = [];
} 

handlerIds.push(handlerId);

KTUtil.data(element).set(name, handlerIds);

if ( !_handlers[name] ) {
    _handlers[name] = {};
}

_handlers[name][handlerId] = {
    name: name,
    callback: callback,
    one: one,
    fired: false
};

return handlerId;
}

var _removeEvent = function(element, name, handlerId) {
var handlerIds = KTUtil.data(element).get(name);
var index = handlerIds && handlerIds.indexOf(handlerId);

if (index !== -1) {
    handlerIds.splice(index, 1);
    KTUtil.data(element).set(name, handlerIds);
}

if (_handlers[name] && _handlers[name][handlerId]) {
    delete _handlers[name][handlerId];
}
}

////////////////////////////
// ** Public Methods  ** //
////////////////////////////
return {
trigger: function(element, name, target) {
    return _triggerEvent(element, name, target);
},

on: function(element, name, handler) {
    return _addEvent(element, name, handler);
},

one: function(element, name, handler) {
    return _addEvent(element, name, handler, true);
},

off: function(element, name, handlerId) {
    return _removeEvent(element, name, handlerId);
},

debug: function() {
    for (var b in _handlers) {
        if ( _handlers.hasOwnProperty(b) ) console.log(b);
    }
}
}
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
module.exports = KTEventHandler;
}

"use strict";

// Class definition
var KTFeedback = function(options) {
////////////////////////////
// ** Private Variables  ** //
////////////////////////////
var the = this;

// Default options
var defaultOptions = {
'width' : 100,
'placement' : 'top-center',
'content' : '',
'type': 'popup'
};

////////////////////////////
// ** Private methods  ** //
////////////////////////////

var _construct = function() {
_init();
}

var _init = function() {
// Variables
the.options = KTUtil.deepExtend({}, defaultOptions, options);
the.uid = KTUtil.getUniqueId('feedback');
the.element;
the.shown = false;

// Event Handlers
_handlers();

// Bind Instance
KTUtil.data(the.element).set('feedback', the);
}

var _handlers = function() {
KTUtil.addEvent(the.element, 'click', function(e) {
    e.preventDefault();

    _go();
});
}

var _show = function() {
if ( KTEventHandler.trigger(the.element, 'kt.feedback.show', the) === false ) {
    return;
}

if ( the.options.type === 'popup') {
    _showPopup();
}

KTEventHandler.trigger(the.element, 'kt.feedback.shown', the);

return the;
}

var _hide = function() {
if ( KTEventHandler.trigger(the.element, 'kt.feedback.hide', the) === false ) {
    return;
}

if ( the.options.type === 'popup') {
    _hidePopup();
}

the.shown = false;

KTEventHandler.trigger(the.element, 'kt.feedback.hidden', the);

return the;
}

var _showPopup = function() {
the.element = document.createElement("DIV");

KTUtil.addClass(the.element, 'feedback feedback-popup');
KTUtil.setHTML(the.element, the.options.content);

if (the.options.placement == 'top-center') {
    _setPopupTopCenterPosition();
}

document.body.appendChild(the.element);

KTUtil.addClass(the.element, 'feedback-shown');

the.shown = true;
}

var _setPopupTopCenterPosition = function() {
var width = KTUtil.getResponsiveValue(the.options.width);
var height = KTUtil.css(the.element, 'height');

KTUtil.addClass(the.element, 'feedback-top-center');

KTUtil.css(the.element, 'width', width);
KTUtil.css(the.element, 'left', '50%');
KTUtil.css(the.element, 'top', '-' + height);
}

var _hidePopup = function() {
the.element.remove();
}

var _destroy = function() {
KTUtil.data(the.element).remove('feedback');
}

// Construct class
_construct();

///////////////////////
// ** Public API  ** //
///////////////////////

// Plugin API
the.show = function() {
return _show();
}

the.hide = function() {
return _hide();
}

the.isShown = function() {
return the.shown;
}

the.getElement = function() {
return the.element;
}

the.destroy = function() {
return _destroy();
}

// Event API
the.on = function(name, handler) {
return KTEventHandler.on(the.element, name, handler);
}

the.one = function(name, handler) {
return KTEventHandler.one(the.element, name, handler);
}

the.off = function(name, handlerId) {
return KTEventHandler.off(the.element, name, handlerId);
}

the.trigger = function(name, event) {
return KTEventHandler.trigger(the.element, name, event, the, event);
}
};

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
module.exports = KTFeedback;
}





"use strict";

// Class definition
var KTStepper = function(element, options) {
//////////////////////////////
// ** Private variables  ** //
//////////////////////////////
var the = this;

if ( typeof element === "undefined" || element === null ) {
return;
}

// Default Options
var defaultOptions = {
startIndex: 1,
animation: false,
animationSpeed: '0.3s',
animationNextClass: 'animate__animated animate__slideInRight animate__fast',
animationPreviousClass: 'animate__animated animate__slideInLeft animate__fast'
};

////////////////////////////
// ** Private methods  ** //
////////////////////////////

var _construct = function() {
if ( KTUtil.data(element).has('stepper') === true ) {
    the = KTUtil.data(element).get('stepper');
} else {
    _init();
}
}

var _init = function() {
the.options = KTUtil.deepExtend({}, defaultOptions, options);
the.uid = KTUtil.getUniqueId('stepper');

the.element = element;

// Set initialized
the.element.setAttribute('data-kt-stepper', 'true');

// Elements
the.steps = KTUtil.findAll(the.element, '[data-kt-stepper-element="nav"]');
the.btnNext = KTUtil.find(the.element, '[data-kt-stepper-action="next"]');
the.btnPrevious = KTUtil.find(the.element, '[data-kt-stepper-action="previous"]');
the.btnSubmit = KTUtil.find(the.element, '[data-kt-stepper-action="submit"]');

// Variables
the.totalStepsNumber = the.steps.length;
the.passedStepIndex = 0;
the.currentStepIndex = 1;
the.clickedStepIndex = 0;

// Set Current Step
if ( the.options.startIndex > 1 ) {
    _goTo(the.options.startIndex);
}

// Event listeners
the.nextListener = function(e) {
    e.preventDefault();

    KTEventHandler.trigger(the.element, 'kt.stepper.next', the);
};

the.previousListener = function(e) {
    e.preventDefault();

    KTEventHandler.trigger(the.element, 'kt.stepper.previous', the);
};

the.stepListener = function(e) {
    e.preventDefault();

    if ( the.steps && the.steps.length > 0 ) {
        for (var i = 0, len = the.steps.length; i < len; i++) {
            if ( the.steps[i] === this ) {
                the.clickedStepIndex = i + 1;

                KTEventHandler.trigger(the.element, 'kt.stepper.click', the);

                return;
            }
        }
    }
};

// Event Handlers
KTUtil.addEvent(the.btnNext, 'click', the.nextListener);

KTUtil.addEvent(the.btnPrevious, 'click', the.previousListener);

the.stepListenerId = KTUtil.on(the.element, '[data-kt-stepper-action="step"]', 'click', the.stepListener);

// Bind Instance
KTUtil.data(the.element).set('stepper', the);
}

var _goTo = function(index) {
// Trigger "change" event
KTEventHandler.trigger(the.element, 'kt.stepper.change', the);

// Skip if this step is already shown
if ( index === the.currentStepIndex || index > the.totalStepsNumber || index < 0 ) {
    return;
}

// Validate step number
index = parseInt(index);

// Set current step
the.passedStepIndex = the.currentStepIndex;
the.currentStepIndex = index;

// Refresh elements
_refreshUI();

// Trigger "changed" event
KTEventHandler.trigger(the.element, 'kt.stepper.changed', the);

return the;
}

var _goNext = function() {
return _goTo( _getNextStepIndex() );
}

var _goPrevious = function() {
return _goTo( _getPreviousStepIndex() );
}

var _goLast = function() {
return _goTo( _getLastStepIndex() );
}

var _goFirst = function() {
return _goTo( _getFirstStepIndex() );
}

var _refreshUI = function() {
var state = '';

if ( _isLastStep() ) {
    state = 'last';
} else if ( _isFirstStep() ) {
    state = 'first';
} else {
    state = 'between';
}

// Set state class
KTUtil.removeClass(the.element, 'last');
KTUtil.removeClass(the.element, 'first');
KTUtil.removeClass(the.element, 'between');

KTUtil.addClass(the.element, state);

// Step Items
var elements = KTUtil.findAll(the.element, '[data-kt-stepper-element="nav"], [data-kt-stepper-element="content"], [data-kt-stepper-element="info"]');

if ( elements && elements.length > 0 ) {
    for (var i = 0, len = elements.length; i < len; i++) {
        var element = elements[i];
        var index = KTUtil.index(element) + 1;

        KTUtil.removeClass(element, 'current');
        KTUtil.removeClass(element, 'completed');
        KTUtil.removeClass(element, 'pending');

        if ( index == the.currentStepIndex ) {
            KTUtil.addClass(element, 'current');

            if ( the.options.animation !== false && element.getAttribute('data-kt-stepper-element') == 'content' ) {
                KTUtil.css(element, 'animationDuration', the.options.animationSpeed);

                var animation = _getStepDirection(the.passedStepIndex) === 'previous' ?  the.options.animationPreviousClass : the.options.animationNextClass;
                KTUtil.animateClass(element, animation);
            }
        } else {
            if ( index < the.currentStepIndex ) {
                KTUtil.addClass(element, 'completed');
            } else {
                KTUtil.addClass(element, 'pending');
            }
        }
    }
}
}

var _isLastStep = function() {
return the.currentStepIndex === the.totalStepsNumber;
}

var _isFirstStep = function() {
return the.currentStepIndex === 1;
}

var _isBetweenStep = function() {
return _isLastStep() === false && _isFirstStep() === false;
}

var _getNextStepIndex = function() {
if ( the.totalStepsNumber >= ( the.currentStepIndex + 1 ) ) {
    return the.currentStepIndex + 1;
} else {
    return the.totalStepsNumber;
}
}

var _getPreviousStepIndex = function() {
if ( ( the.currentStepIndex - 1 ) > 1 ) {
    return the.currentStepIndex - 1;
} else {
    return 1;
}
}

var _getFirstStepIndex = function(){
return 1;
}

var _getLastStepIndex = function() {
return the.totalStepsNumber;
}

var _getTotalStepsNumber = function() {
return the.totalStepsNumber;
}

var _getStepDirection = function(index) {
if ( index > the.currentStepIndex ) {
    return 'next';
} else {
    return 'previous';
}
}

var _getStepContent = function(index) {
var content = KTUtil.findAll(the.element, '[data-kt-stepper-element="content"]');

if ( content[index-1] ) {
    return content[index-1];
} else {
    return false;
}
}

var _destroy = function() {
// Event Handlers
KTUtil.removeEvent(the.btnNext, 'click', the.nextListener);

KTUtil.removeEvent(the.btnPrevious, 'click', the.previousListener);

KTUtil.off(the.element, 'click', the.stepListenerId);

KTUtil.data(the.element).remove('stepper');
}

// Construct Class
_construct();

///////////////////////
// ** Public API  ** //
///////////////////////

// Plugin API
the.getElement = function(index) {
return the.element;
}

the.goTo = function(index) {
return _goTo(index);
}

the.goPrevious = function() {
return _goPrevious();
}

the.goNext = function() {
return _goNext();
}

the.goFirst = function() {
return _goFirst();
}

the.goLast = function() {
return _goLast();
}

the.getCurrentStepIndex = function() {
return the.currentStepIndex;
}

the.getNextStepIndex = function() {
return _getNextStepIndex();
}

the.getPassedStepIndex = function() {
return the.passedStepIndex;
}

the.getClickedStepIndex = function() {
return the.clickedStepIndex;
}

the.getPreviousStepIndex = function() {
return _getPreviousStepIndex();
}

the.destroy = function() {
return _destroy();
}

// Event API
the.on = function(name, handler) {
return KTEventHandler.on(the.element, name, handler);
}

the.one = function(name, handler) {
return KTEventHandler.one(the.element, name, handler);
}

the.off = function(name, handlerId) {
return KTEventHandler.off(the.element, name, handlerId);
}

the.trigger = function(name, event) {
return KTEventHandler.trigger(the.element, name, event, the, event);
}
};

// Static methods
KTStepper.getInstance = function(element) {
if ( element !== null && KTUtil.data(element).has('stepper') ) {
return KTUtil.data(element).get('stepper');
} else {
return null;
}
}

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
module.exports = KTStepper;
}


// Global variables
window.KTUtilElementDataStore = {};
window.KTUtilElementDataStoreID = 0;
window.KTUtilDelegatedEventHandlers = {};

var KTUtil = function() {
var resizeHandlers = [];

/**
* Handle window resize event with some
* delay to attach event handlers upon resize complete
*/
var _windowResizeHandler = function() {
var _runResizeHandlers = function() {
    // reinitialize other subscribed elements
    for (var i = 0; i < resizeHandlers.length; i++) {
        var each = resizeHandlers[i];
        each.call();
    }
};

var timer;

window.addEventListener('resize', function() {
    KTUtil.throttle(timer, function() {
        _runResizeHandlers();
    }, 200);
});
};

return {
/**
 * Class main initializer.
 * @param {object} settings.
 * @returns null
 */
//main function to initiate the theme
init: function(settings) {
    _windowResizeHandler();
},

/**
 * Adds window resize event handler.
 * @param {function} callback function.
 */
addResizeHandler: function(callback) {
    resizeHandlers.push(callback);
},

/**
 * Removes window resize event handler.
 * @param {function} callback function.
 */
removeResizeHandler: function(callback) {
    for (var i = 0; i < resizeHandlers.length; i++) {
        if (callback === resizeHandlers[i]) {
            delete resizeHandlers[i];
        }
    }
},

/**
 * Trigger window resize handlers.
 */
runResizeHandlers: function() {
    _runResizeHandlers();
},

resize: function() {
    if (typeof(Event) === 'function') {
        // modern browsers
        window.dispatchEvent(new Event('resize'));
    } else {
        // for IE and other old browsers
        // causes deprecation warning on modern browsers
        var evt = window.document.createEvent('UIEvents');
        evt.initUIEvent('resize', true, false, window, 0);
        window.dispatchEvent(evt);
    }
},

/**
 * Get GET parameter value from URL.
 * @param {string} paramName Parameter name.
 * @returns {string}
 */
getURLParam: function(paramName) {
    var searchString = window.location.search.substring(1),
        i, val, params = searchString.split("&");

    for (i = 0; i < params.length; i++) {
        val = params[i].split("=");
        if (val[0] == paramName) {
            return unescape(val[1]);
        }
    }

    return null;
},

/**
 * Checks whether current device is mobile touch.
 * @returns {boolean}
 */
isMobileDevice: function() {
    var test = (this.getViewPort().width < this.getBreakpoint('lg') ? true : false);

    if (test === false) {
        // For use within normal web clients
        test = navigator.userAgent.match(/iPad/i) != null;
    }

    return test;
},

/**
 * Checks whether current device is desktop.
 * @returns {boolean}
 */
isDesktopDevice: function() {
    return KTUtil.isMobileDevice() ? false : true;
},

/**
 * Gets browser window viewport size. Ref:
 * http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
 * @returns {object}
 */
getViewPort: function() {
    var e = window,
        a = 'inner';
    if (!('innerWidth' in window)) {
        a = 'client';
        e = document.documentElement || document.body;
    }

    return {
        width: e[a + 'Width'],
        height: e[a + 'Height']
    };
},

/**
 * Checks whether given device mode is currently activated.
 * @param {string} mode Responsive mode name(e.g: desktop,
 *     desktop-and-tablet, tablet, tablet-and-mobile, mobile)
 * @returns {boolean}
 */
isBreakpointUp: function(mode) {
    var width = this.getViewPort().width;
    var breakpoint = this.getBreakpoint(mode);

    return (width >= breakpoint);
},

isBreakpointDown: function(mode) {
    var width = this.getViewPort().width;
    var breakpoint = this.getBreakpoint(mode);

    return (width < breakpoint);
},

getViewportWidth: function() {
    return this.getViewPort().width;
},

/**
 * Generates unique ID for give prefix.
 * @param {string} prefix Prefix for generated ID
 * @returns {boolean}
 */
getUniqueId: function(prefix) {
    return prefix + Math.floor(Math.random() * (new Date()).getTime());
},

/**
 * Gets window width for give breakpoint mode.
 * @param {string} mode Responsive mode name(e.g: xl, lg, md, sm)
 * @returns {number}
 */
getBreakpoint: function(breakpoint) {
    var value = this.getCssVariableValue('--kt-' + breakpoint);

    if ( value ) {
        value = parseInt(value.trim());
    } 

    return value;
},

/**
 * Checks whether object has property matchs given key path.
 * @param {object} obj Object contains values paired with given key path
 * @param {string} keys Keys path seperated with dots
 * @returns {object}
 */
isset: function(obj, keys) {
    var stone;

    keys = keys || '';

    if (keys.indexOf('[') !== -1) {
        throw new Error('Unsupported object path notation.');
    }

    keys = keys.split('.');

    do {
        if (obj === undefined) {
            return false;
        }

        stone = keys.shift();

        if (!obj.hasOwnProperty(stone)) {
            return false;
        }

        obj = obj[stone];

    } while (keys.length);

    return true;
},

/**
 * Gets highest z-index of the given element parents
 * @param {object} el jQuery element object
 * @returns {number}
 */
getHighestZindex: function(el) {
    var position, value;

    while (el && el !== document) {
        // Ignore z-index if position is set to a value where z-index is ignored by the browser
        // This makes behavior of this function consistent across browsers
        // WebKit always returns auto if the element is positioned
        position = KTUtil.css(el, 'position');

        if (position === "absolute" || position === "relative" || position === "fixed") {
            // IE returns 0 when zIndex is not specified
            // other browsers return a string
            // we ignore the case of nested elements with an explicit value of 0
            // <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
            value = parseInt(KTUtil.css(el, 'z-index'));

            if (!isNaN(value) && value !== 0) {
                return value;
            }
        }

        el = el.parentNode;
    }

    return 1;
},

/**
 * Checks whether the element has any parent with fixed positionfreg
 * @param {object} el jQuery element object
 * @returns {boolean}
 */
hasFixedPositionedParent: function(el) {
    var position;

    while (el && el !== document) {
        position = KTUtil.css(el, 'position');

        if (position === "fixed") {
            return true;
        }

        el = el.parentNode;
    }

    return false;
},

/**
 * Simulates delay
 */
sleep: function(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
},

/**
 * Gets randomly generated integer value within given min and max range
 * @param {number} min Range start value
 * @param {number} max Range end value
 * @returns {number}
 */
getRandomInt: function(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
},

/**
 * Checks whether Angular library is included
 * @returns {boolean}
 */
isAngularVersion: function() {
    return window.Zone !== undefined ? true : false;
},

// Deep extend:  $.extend(true, {}, objA, objB);
deepExtend: function(out) {
    out = out || {};

    for (var i = 1; i < arguments.length; i++) {
        var obj = arguments[i];
        if (!obj) continue;

        for (var key in obj) {
            if (!obj.hasOwnProperty(key)) {
                continue;
            }

            // based on https://javascriptweblog.wordpress.com/2011/08/08/fixing-the-javascript-typeof-operator/
            if ( Object.prototype.toString.call(obj[key]) === '[object Object]' ) {
                out[key] = KTUtil.deepExtend(out[key], obj[key]);
                continue;
            }

            out[key] = obj[key];
        }
    }

    return out;
},

// extend:  $.extend({}, objA, objB);
extend: function(out) {
    out = out || {};

    for (var i = 1; i < arguments.length; i++) {
        if (!arguments[i])
            continue;

        for (var key in arguments[i]) {
            if (arguments[i].hasOwnProperty(key))
                out[key] = arguments[i][key];
        }
    }

    return out;
},

getBody: function() {
    return document.getElementsByTagName('body')[0];
},

/**
 * Checks whether the element has given classes
 * @param {object} el jQuery element object
 * @param {string} Classes string
 * @returns {boolean}
 */
hasClasses: function(el, classes) {
    if (!el) {
        return;
    }

    var classesArr = classes.split(" ");

    for (var i = 0; i < classesArr.length; i++) {
        if (KTUtil.hasClass(el, KTUtil.trim(classesArr[i])) == false) {
            return false;
        }
    }

    return true;
},

hasClass: function(el, className) {
    if (!el) {
        return;
    }

    return el.classList ? el.classList.contains(className) : new RegExp('\\b' + className + '\\b').test(el.className);
},

addClass: function(el, className) {
    if (!el || typeof className === 'undefined') {
        return;
    }

    var classNames = className.split(' ');

    if (el.classList) {
        for (var i = 0; i < classNames.length; i++) {
            if (classNames[i] && classNames[i].length > 0) {
                el.classList.add(KTUtil.trim(classNames[i]));
            }
        }
    } else if (!KTUtil.hasClass(el, className)) {
        for (var x = 0; x < classNames.length; x++) {
            el.className += ' ' + KTUtil.trim(classNames[x]);
        }
    }
},

removeClass: function(el, className) {
  if (!el || typeof className === 'undefined') {
        return;
    }

    var classNames = className.split(' ');

    if (el.classList) {
        for (var i = 0; i < classNames.length; i++) {
            el.classList.remove(KTUtil.trim(classNames[i]));
        }
    } else if (KTUtil.hasClass(el, className)) {
        for (var x = 0; x < classNames.length; x++) {
            el.className = el.className.replace(new RegExp('\\b' + KTUtil.trim(classNames[x]) + '\\b', 'g'), '');
        }
    }
},

triggerCustomEvent: function(el, eventName, data) {
    var event;
    if (window.CustomEvent) {
        event = new CustomEvent(eventName, {
            detail: data
        });
    } else {
        event = document.createEvent('CustomEvent');
        event.initCustomEvent(eventName, true, true, data);
    }

    el.dispatchEvent(event);
},

triggerEvent: function(node, eventName) {
    // Make sure we use the ownerDocument from the provided node to avoid cross-window problems
    var doc;

    if (node.ownerDocument) {
        doc = node.ownerDocument;
    } else if (node.nodeType == 9) {
        // the node may be the document itself, nodeType 9 = DOCUMENT_NODE
        doc = node;
    } else {
        throw new Error("Invalid node passed to fireEvent: " + node.id);
    }

    if (node.dispatchEvent) {
        // Gecko-style approach (now the standard) takes more work
        var eventClass = "";

        // Different events have different event classes.
        // If this switch statement can't map an eventName to an eventClass,
        // the event firing is going to fail.
        switch (eventName) {
        case "click": // Dispatching of 'click' appears to not work correctly in Safari. Use 'mousedown' or 'mouseup' instead.
        case "mouseenter":
        case "mouseleave":
        case "mousedown":
        case "mouseup":
            eventClass = "MouseEvents";
            break;

        case "focus":
        case "change":
        case "blur":
        case "select":
            eventClass = "HTMLEvents";
            break;

        default:
            throw "fireEvent: Couldn't find an event class for event '" + eventName + "'.";
            break;
        }
        var event = doc.createEvent(eventClass);

        var bubbles = eventName == "change" ? false : true;
        event.initEvent(eventName, bubbles, true); // All events created as bubbling and cancelable.

        event.synthetic = true; // allow detection of synthetic events
        // The second parameter says go ahead with the default action
        node.dispatchEvent(event, true);
    } else if (node.fireEvent) {
        // IE-old school style
        var event = doc.createEventObject();
        event.synthetic = true; // allow detection of synthetic events
        node.fireEvent("on" + eventName, event);
    }
},

index: function( el ){
    var c = el.parentNode.children, i = 0;
    for(; i < c.length; i++ )
        if( c[i] == el ) return i;
},

trim: function(string) {
    return string.trim();
},

eventTriggered: function(e) {
    if (e.currentTarget.dataset.triggered) {
        return true;
    } else {
        e.currentTarget.dataset.triggered = true;

        return false;
    }
},

remove: function(el) {
    if (el && el.parentNode) {
        el.parentNode.removeChild(el);
    }
},

find: function(parent, query) {
    if ( parent !== null) {
        return parent.querySelector(query);
    } else {
        return null;
    }
},

findAll: function(parent, query) {
    if ( parent !== null ) {
        return parent.querySelectorAll(query);
    } else {
        return null;
    }
},

insertAfter: function(el, referenceNode) {
    return referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
},

parents: function(elem, selector) {
    // Set up a parent array
    var parents = [];

    // Push each parent element to the array
    for ( ; elem && elem !== document; elem = elem.parentNode ) {
        if (selector) {
            if (elem.matches(selector)) {
                parents.push(elem);
            }
            continue;
        }
        parents.push(elem);
    }

    // Return our parent array
    return parents;
},

children: function(el, selector, log) {
    if (!el || !el.childNodes) {
        return null;
    }

    var result = [],
        i = 0,
        l = el.childNodes.length;

    for (var i; i < l; ++i) {
        if (el.childNodes[i].nodeType == 1 && KTUtil.matches(el.childNodes[i], selector, log)) {
            result.push(el.childNodes[i]);
        }
    }

    return result;
},

child: function(el, selector, log) {
    var children = KTUtil.children(el, selector, log);

    return children ? children[0] : null;
},

matches: function(el, selector, log) {
    var p = Element.prototype;
    var f = p.matches || p.webkitMatchesSelector || p.mozMatchesSelector || p.msMatchesSelector || function(s) {
        return [].indexOf.call(document.querySelectorAll(s), this) !== -1;
    };

    if (el && el.tagName) {
        return f.call(el, selector);
    } else {
        return false;
    }
},

data: function(el) {
    return {
        set: function(name, data) {
            if (!el) {
                return;
            }

            if (el.customDataTag === undefined) {
                window.KTUtilElementDataStoreID++;
                el.customDataTag = window.KTUtilElementDataStoreID;
            }

            if (window.KTUtilElementDataStore[el.customDataTag] === undefined) {
                window.KTUtilElementDataStore[el.customDataTag] = {};
            }

            window.KTUtilElementDataStore[el.customDataTag][name] = data;
        },

        get: function(name) {
            if (!el) {
                return;
            }

            if (el.customDataTag === undefined) {
                return null;
            }

            return this.has(name) ? window.KTUtilElementDataStore[el.customDataTag][name] : null;
        },

        has: function(name) {
            if (!el) {
                return false;
            }

            if (el.customDataTag === undefined) {
                return false;
            }

            return (window.KTUtilElementDataStore[el.customDataTag] && window.KTUtilElementDataStore[el.customDataTag][name]) ? true : false;
        },

        remove: function(name) {
            if (el && this.has(name)) {
                delete window.KTUtilElementDataStore[el.customDataTag][name];
            }
        }
    };
},

outerWidth: function(el, margin) {
    var width;

    if (margin === true) {
        width = parseFloat(el.offsetWidth);
        width += parseFloat(KTUtil.css(el, 'margin-left')) + parseFloat(KTUtil.css(el, 'margin-right'));

        return parseFloat(width);
    } else {
        width = parseFloat(el.offsetWidth);

        return width;
    }
},

offset: function(el) {
    var rect, win;

    if ( !el ) {
        return;
    }

    // Return zeros for disconnected and hidden (display: none) elements (gh-2310)
    // Support: IE <=11 only
    // Running getBoundingClientRect on a
    // disconnected node in IE throws an error

    if ( !el.getClientRects().length ) {
        return { top: 0, left: 0 };
    }

    // Get document-relative position by adding viewport scroll to viewport-relative gBCR
    rect = el.getBoundingClientRect();
    win = el.ownerDocument.defaultView;

    return {
        top: rect.top + win.pageYOffset,
        left: rect.left + win.pageXOffset,
        right: window.innerWidth - (el.offsetLeft + el.offsetWidth)
    };
},

height: function(el) {
    return KTUtil.css(el, 'height');
},

outerHeight: function(el, withMargin) {
    var height = el.offsetHeight;
    var style;

    if (typeof withMargin !== 'undefined' && withMargin === true) {
        style = getComputedStyle(el);
        height += parseInt(style.marginTop) + parseInt(style.marginBottom);

        return height;
    } else {
        return height;
    }
},

visible: function(el) {
    return !(el.offsetWidth === 0 && el.offsetHeight === 0);
},

isVisibleInContainer: function (el, container, offset = 0) {
    const eleTop = el.offsetTop;
    const eleBottom = eleTop + el.clientHeight + offset;
    const containerTop = container.scrollTop;
    const containerBottom = containerTop + container.clientHeight;

    // The element is fully visible in the container
    return (
        (eleTop >= containerTop && eleBottom <= containerBottom)
    );
},

getRelativeTopPosition: function (el, container) {
    return el.offsetTop - container.offsetTop;
},

attr: function(el, name, value) {
    if (el == undefined) {
        return;
    }

    if (value !== undefined) {
        el.setAttribute(name, value);
    } else {
        return el.getAttribute(name);
    }
},

hasAttr: function(el, name) {
    if (el == undefined) {
        return;
    }

    return el.getAttribute(name) ? true : false;
},

removeAttr: function(el, name) {
    if (el == undefined) {
        return;
    }

    el.removeAttribute(name);
},

animate: function(from, to, duration, update, easing, done) {
    /**
     * TinyAnimate.easings
     *  Adapted from jQuery Easing
     */
    var easings = {};
    var easing;

    easings.linear = function(t, b, c, d) {
        return c * t / d + b;
    };

    easing = easings.linear;

    // Early bail out if called incorrectly
    if (typeof from !== 'number' ||
        typeof to !== 'number' ||
        typeof duration !== 'number' ||
        typeof update !== 'function') {
        return;
    }

    // Create mock done() function if necessary
    if (typeof done !== 'function') {
        done = function() {};
    }

    // Pick implementation (requestAnimationFrame | setTimeout)
    var rAF = window.requestAnimationFrame || function(callback) {
        window.setTimeout(callback, 1000 / 50);
    };

    // Animation loop
    var canceled = false;
    var change = to - from;

    function loop(timestamp) {
        var time = (timestamp || +new Date()) - start;

        if (time >= 0) {
            update(easing(time, from, change, duration));
        }
        if (time >= 0 && time >= duration) {
            update(to);
            done();
        } else {
            rAF(loop);
        }
    }

    update(from);

    // Start animation loop
    var start = window.performance && window.performance.now ? window.performance.now() : +new Date();

    rAF(loop);
},

actualCss: function(el, prop, cache) {
    var css = '';

    if (el instanceof HTMLElement === false) {
        return;
    }

    if (!el.getAttribute('kt-hidden-' + prop) || cache === false) {
        var value;

        // the element is hidden so:
        // making the el block so we can meassure its height but still be hidden
        css = el.style.cssText;
        el.style.cssText = 'position: absolute; visibility: hidden; display: block;';

        if (prop == 'width') {
            value = el.offsetWidth;
        } else if (prop == 'height') {
            value = el.offsetHeight;
        }

        el.style.cssText = css;

        // store it in cache
        el.setAttribute('kt-hidden-' + prop, value);

        return parseFloat(value);
    } else {
        // store it in cache
        return parseFloat(el.getAttribute('kt-hidden-' + prop));
    }
},

actualHeight: function(el, cache) {
    return KTUtil.actualCss(el, 'height', cache);
},

actualWidth: function(el, cache) {
    return KTUtil.actualCss(el, 'width', cache);
},

getScroll: function(element, method) {
    // The passed in `method` value should be 'Top' or 'Left'
    method = 'scroll' + method;
    return (element == window || element == document) ? (
        self[(method == 'scrollTop') ? 'pageYOffset' : 'pageXOffset'] ||
        (browserSupportsBoxModel && document.documentElement[method]) ||
        document.body[method]
    ) : element[method];
},

css: function(el, styleProp, value, important) {
    if (!el) {
        return;
    }

    if (value !== undefined) {
        if ( important === true ) {
            el.style.setProperty(styleProp, value, 'important');
        } else {
            el.style[styleProp] = value;
        }
    } else {
        var defaultView = (el.ownerDocument || document).defaultView;

        // W3C standard way:
        if (defaultView && defaultView.getComputedStyle) {
            // sanitize property name to css notation
            // (hyphen separated words eg. font-Size)
            styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();

            return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
        } else if (el.currentStyle) { // IE
            // sanitize property name to camelCase
            styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                return letter.toUpperCase();
            });

            value = el.currentStyle[styleProp];

            // convert other units to pixels on IE
            if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                return (function(value) {
                    var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;

                    el.runtimeStyle.left = el.currentStyle.left;
                    el.style.left = value || 0;
                    value = el.style.pixelLeft + "px";
                    el.style.left = oldLeft;
                    el.runtimeStyle.left = oldRsLeft;

                    return value;
                })(value);
            }

            return value;
        }
    }
},

slide: function(el, dir, speed, callback, recalcMaxHeight) {
    if (!el || (dir == 'up' && KTUtil.visible(el) === false) || (dir == 'down' && KTUtil.visible(el) === true)) {
        return;
    }

    speed = (speed ? speed : 600);
    var calcHeight = KTUtil.actualHeight(el);
    var calcPaddingTop = false;
    var calcPaddingBottom = false;

    if (KTUtil.css(el, 'padding-top') && KTUtil.data(el).has('slide-padding-top') !== true) {
        KTUtil.data(el).set('slide-padding-top', KTUtil.css(el, 'padding-top'));
    }

    if (KTUtil.css(el, 'padding-bottom') && KTUtil.data(el).has('slide-padding-bottom') !== true) {
        KTUtil.data(el).set('slide-padding-bottom', KTUtil.css(el, 'padding-bottom'));
    }

    if (KTUtil.data(el).has('slide-padding-top')) {
        calcPaddingTop = parseInt(KTUtil.data(el).get('slide-padding-top'));
    }

    if (KTUtil.data(el).has('slide-padding-bottom')) {
        calcPaddingBottom = parseInt(KTUtil.data(el).get('slide-padding-bottom'));
    }

    if (dir == 'up') { // up
        el.style.cssText = 'display: block; overflow: hidden;';

        if (calcPaddingTop) {
            KTUtil.animate(0, calcPaddingTop, speed, function(value) {
                el.style.paddingTop = (calcPaddingTop - value) + 'px';
            }, 'linear');
        }

        if (calcPaddingBottom) {
            KTUtil.animate(0, calcPaddingBottom, speed, function(value) {
                el.style.paddingBottom = (calcPaddingBottom - value) + 'px';
            }, 'linear');
        }

        KTUtil.animate(0, calcHeight, speed, function(value) {
            el.style.height = (calcHeight - value) + 'px';
        }, 'linear', function() {
            el.style.height = '';
            el.style.display = 'none';

            if (typeof callback === 'function') {
                callback();
            }
        });


    } else if (dir == 'down') { // down
        el.style.cssText = 'display: block; overflow: hidden;';

        if (calcPaddingTop) {
            KTUtil.animate(0, calcPaddingTop, speed, function(value) {//
                el.style.paddingTop = value + 'px';
            }, 'linear', function() {
                el.style.paddingTop = '';
            });
        }

        if (calcPaddingBottom) {
            KTUtil.animate(0, calcPaddingBottom, speed, function(value) {
                el.style.paddingBottom = value + 'px';
            }, 'linear', function() {
                el.style.paddingBottom = '';
            });
        }

        KTUtil.animate(0, calcHeight, speed, function(value) {
            el.style.height = value + 'px';
        }, 'linear', function() {
            el.style.height = '';
            el.style.display = '';
            el.style.overflow = '';

            if (typeof callback === 'function') {
                callback();
            }
        });
    }
},

slideUp: function(el, speed, callback) {
    KTUtil.slide(el, 'up', speed, callback);
},

slideDown: function(el, speed, callback) {
    KTUtil.slide(el, 'down', speed, callback);
},

show: function(el, display) {
    if (typeof el !== 'undefined') {
        el.style.display = (display ? display : 'block');
    }
},

hide: function(el) {
    if (typeof el !== 'undefined') {
        el.style.display = 'none';
    }
},

addEvent: function(el, type, handler, one) {
    if (typeof el !== 'undefined' && el !== null) {
        el.addEventListener(type, handler);
    }
},

removeEvent: function(el, type, handler) {
    if (el !== null) {
        el.removeEventListener(type, handler);
    }
},

on: function(element, selector, event, handler) {
    if ( element === null ) {
        return;
    }

    var eventId = KTUtil.getUniqueId('event');

    window.KTUtilDelegatedEventHandlers[eventId] = function(e) {
        var targets = element.querySelectorAll(selector);
        var target = e.target;

        while ( target && target !== element ) {
            for ( var i = 0, j = targets.length; i < j; i++ ) {
                if ( target === targets[i] ) {
                    handler.call(target, e);
                }
            }

            target = target.parentNode;
        }
    }

    KTUtil.addEvent(element, event, window.KTUtilDelegatedEventHandlers[eventId]);

    return eventId;
},

off: function(element, event, eventId) {
    if (!element || !window.KTUtilDelegatedEventHandlers[eventId]) {
        return;
    }

    KTUtil.removeEvent(element, event, window.KTUtilDelegatedEventHandlers[eventId]);

    delete window.KTUtilDelegatedEventHandlers[eventId];
},

one: function onetime(el, type, callback) {
    el.addEventListener(type, function callee(e) {
        // remove event
        if (e.target && e.target.removeEventListener) {
            e.target.removeEventListener(e.type, callee);
        }

        // need to verify from https://themeforest.net/author_dashboard#comment_23615588
        if (el && el.removeEventListener) {
            e.currentTarget.removeEventListener(e.type, callee);
        }

        // call handler
        return callback(e);
    });
},

hash: function(str) {
    var hash = 0,
        i, chr;

    if (str.length === 0) return hash;
    for (i = 0; i < str.length; i++) {
        chr = str.charCodeAt(i);
        hash = ((hash << 5) - hash) + chr;
        hash |= 0; // Convert to 32bit integer
    }

    return hash;
},

animateClass: function(el, animationName, callback) {
    var animation;
    var animations = {
        animation: 'animationend',
        OAnimation: 'oAnimationEnd',
        MozAnimation: 'mozAnimationEnd',
        WebkitAnimation: 'webkitAnimationEnd',
        msAnimation: 'msAnimationEnd',
    };

    for (var t in animations) {
        if (el.style[t] !== undefined) {
            animation = animations[t];
        }
    }
    
    KTUtil.addClass(el, animationName);

    KTUtil.one(el, animation, function() {
        KTUtil.removeClass(el, animationName);
    });

    if (callback) {
        KTUtil.one(el, animation, callback);
    }
},

transitionEnd: function(el, callback) {
    var transition;
    var transitions = {
        transition: 'transitionend',
        OTransition: 'oTransitionEnd',
        MozTransition: 'mozTransitionEnd',
        WebkitTransition: 'webkitTransitionEnd',
        msTransition: 'msTransitionEnd'
    };

    for (var t in transitions) {
        if (el.style[t] !== undefined) {
            transition = transitions[t];
        }
    }

    KTUtil.one(el, transition, callback);
},

animationEnd: function(el, callback) {
    var animation;
    var animations = {
        animation: 'animationend',
        OAnimation: 'oAnimationEnd',
        MozAnimation: 'mozAnimationEnd',
        WebkitAnimation: 'webkitAnimationEnd',
        msAnimation: 'msAnimationEnd'
    };

    for (var t in animations) {
        if (el.style[t] !== undefined) {
            animation = animations[t];
        }
    }

    KTUtil.one(el, animation, callback);
},

animateDelay: function(el, value) {
    var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
    for (var i = 0; i < vendors.length; i++) {
        KTUtil.css(el, vendors[i] + 'animation-delay', value);
    }
},

animateDuration: function(el, value) {
    var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
    for (var i = 0; i < vendors.length; i++) {
        KTUtil.css(el, vendors[i] + 'animation-duration', value);
    }
},

scrollTo: function(target, offset, duration) {
    var duration = duration ? duration : 500;
    var targetPos = target ? KTUtil.offset(target).top : 0;
    var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    var from, to;

    if (offset) {
        targetPos = targetPos - offset;
    }

    from = scrollPos;
    to = targetPos;

    KTUtil.animate(from, to, duration, function(value) {
        document.documentElement.scrollTop = value;
        document.body.parentNode.scrollTop = value;
        document.body.scrollTop = value;
    }); //, easing, done
},

scrollTop: function(offset, duration) {
    KTUtil.scrollTo(null, offset, duration);
},

isArray: function(obj) {
    return obj && Array.isArray(obj);
},

isEmpty: function(obj) {
    for (var prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            return false;
        }
    }

    return true;
},

numberString: function(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
},

isRTL: function() {
    return (document.querySelector('html').getAttribute("direction") === 'rtl');
},

snakeToCamel: function(s){
    return s.replace(/(\-\w)/g, function(m){return m[1].toUpperCase();});
},

filterBoolean: function(val) {
    // Convert string boolean
    if (val === true || val === 'true') {
        return true;
    }

    if (val === false || val === 'false') {
        return false;
    }

    return val;
},

setHTML: function(el, html) {
    el.innerHTML = html;
},

getHTML: function(el) {
    if (el) {
        return el.innerHTML;
    }
},

getDocumentHeight: function() {
    var body = document.body;
    var html = document.documentElement;

    return Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
},

getScrollTop: function() {
    return  (document.scrollingElement || document.documentElement).scrollTop;
},

colorLighten: function(color, amount) {
    const addLight = function(color, amount){
        let cc = parseInt(color,16) + amount;
        let c = (cc > 255) ? 255 : (cc);
        c = (c.toString(16).length > 1 ) ? c.toString(16) : `0${c.toString(16)}`;
        return c;
    }

    color = (color.indexOf("#")>=0) ? color.substring(1,color.length) : color;
    amount = parseInt((255*amount)/100);
    
    return color = `#${addLight(color.substring(0,2), amount)}${addLight(color.substring(2,4), amount)}${addLight(color.substring(4,6), amount)}`;
},

colorDarken: function(color, amount) {
    const subtractLight = function(color, amount){
        let cc = parseInt(color,16) - amount;
        let c = (cc < 0) ? 0 : (cc);
        c = (c.toString(16).length > 1 ) ? c.toString(16) : `0${c.toString(16)}`;

        return c;
    }
      
    color = (color.indexOf("#")>=0) ? color.substring(1,color.length) : color;
    amount = parseInt((255*amount)/100);

    return color = `#${subtractLight(color.substring(0,2), amount)}${subtractLight(color.substring(2,4), amount)}${subtractLight(color.substring(4,6), amount)}`;
},

// Throttle function: Input as function which needs to be throttled and delay is the time interval in milliseconds
throttle:  function (timer, func, delay) {
    // If setTimeout is already scheduled, no need to do anything
    if (timer) {
        return;
    }

    // Schedule a setTimeout after delay seconds
    timer  =  setTimeout(function () {
        func();

        // Once setTimeout function execution is finished, timerId = undefined so that in <br>
        // the next scroll event function execution can be scheduled by the setTimeout
        timer  =  undefined;
    }, delay);
},

// Debounce function: Input as function which needs to be debounced and delay is the debounced time in milliseconds
debounce: function (timer, func, delay) {
    // Cancels the setTimeout method execution
    clearTimeout(timer)

    // Executes the func after delay time.
    timer  =  setTimeout(func, delay);
},

parseJson: function(value) {
    if (typeof value === 'string') {
        value = value.replace(/'/g, "\"");

        var jsonStr = value.replace(/(\w+:)|(\w+ :)/g, function(matched) {
            return '"' + matched.substring(0, matched.length - 1) + '":';
        });

        try {
            value = JSON.parse(jsonStr);
        } catch(e) { }
    }

    return value;
},

getResponsiveValue: function(value, defaultValue) {
    var width = this.getViewPort().width;
    var result;

    value = KTUtil.parseJson(value);

    if (typeof value === 'object') {
        var resultKey;
        var resultBreakpoint = -1;
        var breakpoint;

        for (var key in value) {
            if (key === 'default') {
                breakpoint = 0;
            } else {
                breakpoint = this.getBreakpoint(key) ? this.getBreakpoint(key) : parseInt(key);
            }

            if (breakpoint <= width && breakpoint > resultBreakpoint) {
                resultKey = key;
                resultBreakpoint = breakpoint;
            }
        }

        if (resultKey) {
            result = value[resultKey];
        } else {
            result = value;
        }
    } else {
        result = value;
    }

    return result;
},

each: function(array, callback) {
    return [].slice.call(array).map(callback);
},

getSelectorMatchValue: function(value) {
    var result = null;
    value = KTUtil.parseJson(value);

    if ( typeof value === 'object' ) {
        // Match condition
        if ( value['match'] !== undefined ) {
            var selector = Object.keys(value['match'])[0];
            value = Object.values(value['match'])[0];

            if ( document.querySelector(selector) !== null ) {
                result = value;
            }
        }
    } else {
        result = value;
    }

    return result;
},

getConditionalValue: function(value) {
    var value = KTUtil.parseJson(value);
    var result = KTUtil.getResponsiveValue(value);

    if ( result !== null && result['match'] !== undefined ) {
        result = KTUtil.getSelectorMatchValue(result);
    }

    if ( result === null && value !== null && value['default'] !== undefined ) {
        result = value['default'];
    }

    return result;
},

getCssVariableValue: function(variableName) {
    var hex = getComputedStyle(document.documentElement).getPropertyValue(variableName);
    if ( hex && hex.length > 0 ) {
        hex = hex.trim();
    }

    return hex;
},

isInViewport: function(element) {        
    var rect = element.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
},

onDOMContentLoaded: function(callback) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback);
    } else {
        callback();
    }
},

inIframe: function() {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
},

isHexColor(code) {
    return /^#[0-9A-F]{6}$/i.test(code);
}
}
}();

