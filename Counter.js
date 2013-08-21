/** 
 * Counter
 *
 * Countdown (or up) to a specified date.
 * 
 * 
 * @author Wil Wilsman <hello@wilwilsman.com> - wilwilsman.com
 * @copyright (c) 2013 Wil Wilsman
 * @license MIT 
 * @version 1.0
 */

/*jslint evil: true, plusplus: true, regexp: true, indent: 2 */

/**
 * Creates an instance of Counter.
 *
 * @class Counter
 * @constructor
 * @param {Object} options - An element to append the counter to / options to overide defaults.
 */
function Counter(options) {

  "use strict";

  /** @private */
  var self = this,
    updateInterval = 10,
    container = !options.hasOwnProperty(date) ? options : null,
    times = [ 'days', 'hours', 'minutes', 'seconds', 'millisecs' ],
    opt,

    /* Default Options */
    defaults = {
      date: null,
      days: null,
      hours: null,
      minutes: null,
      seconds: null,
      millisecs: null,
      template: [
        '<div class="cnt_container">',
        '  <% for( var i = 0; i < times.length ) { %>',
        '    <div class="cnt_<%= times[i] %>">',
        '      <div class="cnt_number"></div>',
        '      <div class="cnt_label"></div>',
        '    </div>',
        '  <% } %>',
        '</div>'
      ].join('')
    },

    /**
     * Pads a number with leading zeros.
     *
     * @param {number} n - The number to pad.
     * @param {number} l - The length to pad the number to.
     * @returns {string} The padded number.
     */
    pad = function (n, l) {
      while (n.toString().length < l) { n = '0' + n; }
      return n.toString();
    },

    /**
     * Replaces the content of an element.
     *
     * @param {string} what - The replacement content.
     * @param {Object} where - The element who's contents are to be replaced.
     */
    insert = function (what, where) {
      var i;
      if (where.length) {
        for (i = 0; i < where.length; i++) { where[i].innerHTML = what; }
      } else { where.innerHTML = what; }
    },

    /**
     * Updates the counter at an interval.
     * Note: Uses setTimeout() so the interval can be dynamically changed.
     */
    intervalUpdate = function () {
      window.setTimeout(function () {
        var diff = self.dateDiff(), i;
        intervalUpdate();
        for (i = 0; i < times.length; i++) {
          if (self.options[times[i]]) { insert(diff[times[i]], self.options[times[i]]); }
        }
      }, updateInterval);
    },

    /**
     * Modified John Resig's Microtemplate - http://ejohn.org/
     *
     * @param {string} str - The template.
     * @param {Object} data - The data to pass to the template.
     */
    tmpl = function (str, data) {
      var fn = new Function("obj",
        "p=[]; with(obj){p.push('" +
        str.replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'") +
        "')} return p.join('')");
      return data ? fn(data) : fn;
    };

  /** Exposes the options for dynamic changes. */ 
  self.options = container ? {} : options;

  /* Extends options with the defaults */
  for (opt in defaults) {
    if (defaults.hasOwnProperty(opt)) {
      if (!self.options.hasOwnProperty(opt)) { self.options[opt] = defaults[opt]; }
    }
  }

  /**
   * Initializes the counter.
   *
   * @method init
   * @param {string} [date] - The date to set the counter to.
   * @returns {Counter}
   */ 
  self.init = function (date) {
    self.options.date = date || self.options.date;
    if (container) { container.appendChild(self.build()); }
    intervalUpdate();
    return self;
  };

  /**
   * Turns the template into a DOM Object and sets options accordingly.
   *
   * @method build
   * @returns {Object} The DOM Object created from the tmeplate.
   */ 
  self.build = function () {
    var counter = tmpl(self.options.template, {times: times}),
      classReg = new RegExp('(^||\\s)\\S*?(' + times.join('||') + ')(\\s||$)'),
      temporary = document.createElement('div'),
      match,
      i;

    temporary.innerHTML = counter;
    counter = temporary.childNodes;

    for (i = 0; i < counter.length; i++) {
      match = counter[i].className.match(classReg);
      if (match) { self.options[match[2]] = counter[i]; }
    }

    return counter;
  };

  /**
   * Gets the difference between dates as defined in the options.
   *
   * @method dateDiff
   * @returns {Object} The differences between the dates.
   */ 
  self.dateDiff = function () {
    var diff = { millisecs: Math.abs(Date.parse(self.options.date) - Date.now()) },
      ms = { days: 86400000, hours: 3600000, minutes: 60000, seconds: 1000 },
      msPad = 10,
      prop;

    for (prop in ms) {
      if (ms.hasOwnProperty(prop)) {
        if (self.options[prop]) {
          diff[prop] = pad(Math.floor(diff.millisecs / ms[prop]), 2);
          diff.millisecs = diff.millisecs % ms[prop];
          msPad = (ms[prop] - 1).toString().length;
          updateInterval = ms[prop];
        }
      }
    }

    if (self.options.millisecs) {
      diff.millisecs = pad(diff.millisecs, msPad);
      updateInterval = 10;
    }

    return diff;
  };
}