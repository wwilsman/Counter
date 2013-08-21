# Counter

Count down (or up) to a specified date.

*&copy; 2013 [Wil Wilsman](http://wilwilsman.com)* <hello@wilwilsman.com>

## API

Check out the example page [here](http://counter.wilwilsman.com/).

To set a date to count down (or up) to add `?d=` to the URL followed by the date (ISO8601).

You can optionally ommit anything that is not a digit from the date, but it will assume the date givin starts with the year.

[http://counter.wilwilsman.com/?d=201308211430](http://counter.wilwilsman.com/?d=201308211430)

*More documentation to come*


## Counter.js

Create a new Counter:

	var cnt_el = document.getElementById('counter'),
	    counter = new Counter(cnt_el);

Create a new Counter, overriding default options:

	var date_str = "2013-08-21T14:30:00",
		days_el = document.getElementById('days'),
		hours_el = document.getElementById('hours'),
		minutes_el = document.getElementById('minutes'),
		seconds_el = document.getElementById('seconds'),
		millisecs_el = document.getElementById('millisecs'),
		counter = new Counter({
			date: date_str,
			days: days_el,
			hours: hours_el,
			minutes: minutes_el,
			seconds: seconds_el,
			millisecs: millisecs_el,
		});

*Omitting some options when overriding defaults will not calculate that number and the remaining amount of time will be added to the next number.*

To initialize the Counter:

*Without overriding defaults:*

	counter.init("2013-08-21T14:30:00");

*Overriding defaults:*

	counter.init();



### Counter.options

Exposes the options for dynamic changes.



### Counter.init(\[date\])

Initializes the counter.

**Parameters**

**[date]**:  *string*,  - The date to set the counter to.



### Counter.build()

Turns the template into a DOM Object and sets options accordingly.

**Returns**

*Object*,  The DOM Object created from the template.



### Counter.dateDiff()

Gets the difference between dates as defined in the options.

**Returns**

*Object*,  The differences between the dates.

