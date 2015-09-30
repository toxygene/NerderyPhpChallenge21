# Nerdery PHP Challenge #21
Justin Hendrickson

## Summary
This PHP challenge caught my attention immediately; it was a perfect storm of extending on things I knew and utilizing various skills I had learned while working at the Nerdery; push and pull parsers, streams, optimization, and language parsing.

From the beginning, I knew I could just write a recursive function to find the path, but it would be slow and memory intesive when handling large files. Instead, I decided to draw on knowledge I had gained from my first project at the Nerdery -- optimizing an XML import script that took 8+ hours and 2+ GB of memory to use a SAX parser. I immediately set out to find a streaming JSON parser.

I found a few reasonable candidates, but most of them were push parser and what I really wanted was a pull parser. Eventually, I found a good library (https://github.com/shevron/ext-jsonreader) but it was a PHP extension and I didn't want that to be a barrier to testing the code.

So, I did the only logical thing: I wrote my own. As I progressed, I found a need for an abstraction of reading from a stream and peeking at characters in the stream, so I spun off a separate library for that.

## Usage
> `php find-path-to-needle-in-json-file.php [needle] [file]`