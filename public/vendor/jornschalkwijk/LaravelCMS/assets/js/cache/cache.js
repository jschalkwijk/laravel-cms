/**
 * @version 1.0.0
 * @author Jorn Schalkwijk - <jornschalkwijk@gmail.com>
 */

/**
 * Cache Constructor.
 * @name Cache
 * @constructor
 * @param {object} options - The options object.
 * @property {string} options.name - Name of the cache storage array
 * @property{int} options.expired - Expiration time in milliseconds (15 minutes default)
 * @property {Storage} options.storageType - Type of storage used
 * @description Storing ajax requests or other values in local- or sessionStorage to improve performance.
 */

function Cache(options = {}){
    const _this = this;
    /** @name defaults
     * @property {object} defaults - The default options
     * @property {string} defaults.name=cache - Name of the cache storage array
     * @property {int} defaults.expired=900000 - Expiration time in milliseconds (15 minutes default)
     * @property {Storage} defaults.storageType=localStorage - Type of storage used
     */
    this.defaults = {
        name:'cache',
        expired:900000,
        storageType: localStorage,
    };
    /** @name opt
     * @property {object} opt - Merges the given and default options to the opt(options) used in the constructor
     * @return {Object} opt - Object with the options
     * */
    // merge values from the options object to the defaults object and create new object
    this.opt = Object.assign({}, this.defaults, options);

    /**
     * @method cache
     * @return {Array} Currently Cached objects
     */
    this.cache = function () {
        return JSON.parse(_this.opt.storageType.getItem(_this.opt.name));
    };

    /**
     * @function initCache
     * Sets the storageType array to tyhe givin or deault name which will hold our cached objects
     * @module initCache
     */
    // Initialize the storage array if it does't exist
    (/** @lends module:initCache */function initCache() {
        if (_this.opt.storageType) {
            if (!_this.opt.storageType.getItem(_this.opt.name)) {
                // Store data
                let cache = [];
                _this.opt.storageType.setItem(_this.opt.name, JSON.stringify(cache));
            }
            console.log('init');
        } else {
            alert("Sorry, your browser do not support local or session storage.");
        }
    }());

    /**
     * @method get
     * Get an Object from the cache Array
     * @param {string} key - Key name which holds the value you want to get.
     * @param {string} value - Value you want to check for its existence.
     * @return {Boolean|Object} - If the item exist and i snot expired the item is returned, else false
     */
    this.get = function (key, value) {
        if (_this.opt.storageType.getItem(_this.opt.name)) {
            let cache = this.cache();
            console.log(cache);
            // _this.opt.storageType.setItem(_this.opt.name, JSON.stringify([]));
            if (cache.find(obj => (obj[key] === value)) !== undefined) {
                let data = cache.find(obj => (obj[key] === value));
                if(data && ((new Date().getTime() - data.timestamp) < _this.opt.expired)){
                    console.log('not expired');
                    return data;
                } else {
                    console.log('expired');
                    return false;
                }
            } else {
                return false;
            }
        }
    };

    /**
     * @method set
     * Adds the values object to the cache array. Removes existing object to avoid duplicates
     * @param {Object} values - Values you want to cache, it should a value that you can use as a primary key to search for when retrieving.
     * @param {string} primaryKey - The key used when we search for a possible existing object, if so it will be unset to avoid duplicates.
     * The primaryKey needs to exist in the values Object.
     * @return {Boolean|Object} - If the item exist and i snot expired the item is returned, else false
     */
    this.set = function (values = {}, primaryKey) {
        // remove value from array which has this reference value
        this.unset(primaryKey,values[primaryKey]);
        // Set timestamp in milliseconds
        values.timestamp = new Date().getTime();
        // Get current stored array and update with new data
        let updatedCache = this.cache();
        updatedCache.push(values);
        //overwrite the old array with the update array
        _this.opt.storageType.setItem(_this.opt.name, JSON.stringify(updatedCache));
        console.log(this.cache());
    };

    /**
     * @method unset
     * Search for an object and removes it from the cache if it exists.
     * @param {string} key - Key name which holds the value you want to unset.
     * @param {string} value - Value you want to check for its existence.
     * @return {Boolean|Object} - If the item exist and i snot expired the item is returned, else false
     */
    this.unset = function (key,value) {
        let cache = JSON.parse(_this.opt.storageType.getItem(_this.opt.name));
        let removeIndex = cache.map(function (item) {
            return item[key];
        }).indexOf(value);// get index of object with url given
        if (removeIndex === -1) {
            removeIndex = 0;
            return false;
        }
        cache.splice(removeIndex, 1);
        _this.opt.storageType.setItem(_this.opt.name, JSON.stringify(cache));
    };
    /**
     * @method reset
     * Sets the cache array to an empty array
     * @return {Boolean}
     */
    this.reset = function () {
        _this.opt.storageType.setItem(_this.opt.name, JSON.stringify([]));
    };
}