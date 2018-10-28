# Javascript Cache

A cache constructor created for caching ajax request (or whatever you like) into your browsers local or session storage to speed up your application.

## Installation
Download or clone this repository

## Usage


Load this script into your page.
	<script src=“PathToFile/cache.js”></script>
	// You can pass on an options object.
	let cache = new Cache({name:’cacheExample’,expiration: 900000,storageType:localStorage})
	/*Set for example a url with the html response from an ajax request. The second argument you give is
	needed so the set method can check for existing objects with the same key,value pair and remove it before adding a 	possible updated object.*/

	cache.set({url:’example.com/test’,html:'<p>Your html</p>’},’url’);
	cache.set({url:’example.com/test2’,html:'<p>Your second cached html</p>’},’url’);
	
	//Get your cached object by giving the key,value pair you want it to search for.
	let cached = cache.get(‘url’,’example.com/test’);
	console.log(cached.html);
	// Update the cached object
	cache.set({url:’example.com/test’,html:'<p>Your updated html</p>’},’url’);	
	let cached = cache.get(‘url’,’example.com/test’);
	console.log(cached.html);
	// remove object by giving a key,value pair
	cache.unset(‘url’,’example.com/test’);
	// see the cache array
	console.log(cache.cache())
	// set empty cache array
	cache.reset();
	console.log(cache.cache())


### Default Options
	name:cache
	expiration:900000
	storageType:localStorage
name: The name of your cache array
expiration: Time in milliseconds after which your cached object will be invalid. Default, 900000 (15 minutes)
storageType: Type of storage you want to use. Default localStorage

	

## License

Licensed under the [MIT license](http://opensource.org/licenses/MIT).
