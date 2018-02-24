BarChart
========

This is a jQuery plugin that provides interactive bar chart presentation for specified user data.


## Features

- vertical and horizontal positioning
- toggling bar's sections in real-time
- support of non-date keys
- highly customizable via css
- responsive and adaptive


## Setup

```javascript
$('selector').barChart({
  vertical : true,
  height: 500,
  bars : [
    {
      name : 'Example',
      values : [ [ key, value ], [ key, value ], ... ]
    },
    ...
  ]
});
```

## Demo 

You can test a full-working demo [here](http://canddy.ru/work/barchart/)
