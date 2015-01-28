Authors
-------

The embryo images have been created by Colette Ten Hove and Kuan-Ju Lu, and edited by Joakim Palovaara

The root image has been created by Jos Wendrich.

Notes
-----

The following should be noted when making new images:

* The groups with a tissue class should be the ones setting the fill attribute for all sub groups.
* The top level SVG element should contain proper width and height attributes, this is required for the PNG export.
* The height should be 300px, as Safari requires this to position the tooltips properly
* A viewBox property has to be set, and this is the base for scaling the image upon PNG export. You can make the image 
  bigger there by making the viewBox bigger 
* Remove any clipPaths from being used. This will mess up IE when they remain.
* The top level SVG element should not contain any custom namespace (attributes with : in it) for the SVG export to work in IE.
* Tissues should be grouped in a <g> with a class specified. This <g> should control the fill color

Optimization
------------

The optimized images have been created using [svgo](https://github.com/svg/svgo). 

```
svgo --pretty -f svg/ -o svg/optimized/
```

Copyright and licence
---------------------

SVG images are copyright of (c) 2014 Wageningen University and licensed under the [Creative Commons 
Attribution-ShareAlike 4.0 International License](http://creativecommons.org/licenses/by-sa/4.0/).