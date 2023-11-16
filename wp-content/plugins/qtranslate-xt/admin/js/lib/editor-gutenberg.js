"use strict";function ownKeys(object,enumerableOnly){var keys=Object.keys(object);if(Object.getOwnPropertySymbols){var symbols=Object.getOwnPropertySymbols(object);if(enumerableOnly)symbols=symbols.filter(function(sym){return Object.getOwnPropertyDescriptor(object,sym).enumerable});keys.push.apply(keys,symbols)}return keys}function _objectSpread(target){for(var i=1;i<arguments.length;i++){var source=arguments[i]!=null?arguments[i]:{};if(i%2){ownKeys(Object(source),true).forEach(function(key){_defineProperty(target,key,source[key])})}else if(Object.getOwnPropertyDescriptors){Object.defineProperties(target,Object.getOwnPropertyDescriptors(source))}else{ownKeys(Object(source)).forEach(function(key){Object.defineProperty(target,key,Object.getOwnPropertyDescriptor(source,key))})}}return target}function _defineProperty(obj,key,value){if(key in obj){Object.defineProperty(obj,key,{value:value,enumerable:true,configurable:true,writable:true})}else{obj[key]=value}return obj}/**
 * middleware handler for Gutenberg editor
 *
 * $author herrvigg
 */(function(){console.log("QT-XT API: setup apiFetch");wp.apiFetch.use(function(options,next){if(!options.path||options.method!=="PUT"&&options.method!=="POST"){return next(options)}// A better event handler is needed to understand when the post is saved.
// For now "wait" by ignoring all API calls until the post is loaded in the editor.
var post=wp.data.select("core/editor").getCurrentPost();// console.log('QT-XT API: PRE handling method=' + options.method, 'path=' + options.path, 'post=', post);
if(!post.hasOwnProperty("type")){return next(options)}var typeData=wp.data.select("core").getPostType(post.type);if(!typeData.hasOwnProperty("rest_base")){return next(options)}//console.log('QT-XT API: PRE handling method=' + options.method, 'path=' + options.path, 'post=', post, 'type=', typeData);
var prefixPath="/wp/v2/"+typeData.rest_base+"/"+post.id;if(options.path.startsWith(prefixPath)&&options.method==="PUT"||options.path.startsWith(prefixPath+"/autosaves")&&options.method==="POST"){// console.log('QT-XT API: handling method=' + options.method, 'path=' + options.path, 'post=', post);
if(!post.hasOwnProperty("qtx_editor_lang")){console.log("QT-XT API: missing field [qtx_editor_lang] in post id="+post.id);return next(options)}var newOptions=_objectSpread(_objectSpread({},options),{},{data:_objectSpread(_objectSpread({},options.data),{},{"qtx_editor_lang":post.qtx_editor_lang})});console.log("QT-XT API: using options=",options);var result=next(newOptions);return result}return next(options)})})();