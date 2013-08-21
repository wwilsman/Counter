# Counter

Count down (or up) to a specified date.

*&copy; 2013 [Wil Wilsman](http://wilwilsman.com)* <hello@wilwilsman.com>

## API

Check out the example page [here](http://wwilsman.github.io/Counter/).

To set a date to count down (or up) to add `?d=` to the URL followed by the date (ISO8601).

You can optionally ommit anything that is not a digit from the date, but it will assume the date givin starts with the year.

[http://wwilsman.github.io/Counter/?d=201308211430](http://wwilsman.github.io/Counter/?d=201308211430)

*More documentation to come*


## Counter.js



### Counter.options

Exposes the options for dynamic changes.



### Counter.init(\[date\])

Initializes the counter.

**Parameters**

**[date]**:  *string*,  - The date to set the counter to.



### Counter.build()

Turns the template into a DOM Object and sets options accordingly.

**Returns**

*Object*,  The DOM Object created from the tmeplate.



### Counter.dateDiff()

Gets the difference between dates as defined in the options.

**Returns**

*Object*,  The differences between the dates.

