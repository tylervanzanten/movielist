# PHP IMDb.com Grabber

**This class enables you to retrieve data from IMDb.com with PHP.**

*The script is a proof of concept. It's working pretty well, but you shouldn't use it since IMDb does not allow this method of data grabbing! Personally, I do not use or promote this script. You’re responsible IF you’re using it.*

The technique used is called “[web scraping](http://en.wikipedia.org/wiki/Web_scraping "Web scraping")”. That means: If IMDb changes anything on their HTML, the script is going to fail.

---

Did you know about the available IMDb.com API? The price to use it is around $15.000. This might be fine for commercial projects, but it's impossible to afford for private/non-commercial ones.

---

**If you want to thank me for my work and the support, feel free to do this through PayPal (use mail@fabian-beiner.de as payment destination) or just buy me a book at [Amazon](http://www.amazon.de/registry/wishlist/8840JITISN9L) – thank you! :-)**

## License

Since version 5.5.0 the script is licensed under [CC BY-NC-SA 3.0](http://creativecommons.org/licenses/by-nc-sa/3.0/).

## Changes

5.5.19
- Fixed IMDB_FULL_CAST and IMDB_YEAR.
- getSitesAsUrl() only returns a link, if the url starts with "http".


# Title

This page was written by Tyler VanZanten

It uses mySQL database to store a list of Movies.



I did not write any of the files found in the imdbphp folder.  All of those files are from a project on [GitHub](https://github.com/FabianBeiner/PHP-IMDB-Grabber).
That code enables the fetching of info from imdb.com