# WordPress On-This-Day Plugin

This simple plugin generates an RSS feed of your blog posts which were published "on this day" in the past.

For example, if today is 21st of November 2016 then this will show a list of blog posts written on

* 2015-11-21
* 2014-11-21
* 2013-11-21

And so on.

You can view a demo at https://shkspr.mobi/blog/?on_this_day

## Limitations

### Times

The entries in the RSS feed are generated on an hourly basis.

For example, if the time is 1300 the RSS feed will only show blog posts published **on or before** 1300 on their original publication day.

This allows services like IFTTT to post the feed to Twitter throughout the day rather than all at once.

### Location

This plugin lives at `https://example.com/?on_this_day`.  The results are *not* cached.

### Images

The thumbnail from the post is also included.

### Times and Locale

The RSS feed is hardcoded to `GMT` and `en-GB` - this may change in the future.

