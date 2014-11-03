/*! Modernizr 3.0.0-beta (Custom Build) | MIT
 *  Build: http://modernizr.com/download/#-canvas-inlinesvg-todataurljpeg-todataurlpng-todataurlwebp
 */
(function(n,e){var t,a,o,s,Modernizr,i,r;function d(n,e){return typeof n===e}function f(){var n,e,a,s,i,r,f,u;for(u in o){if(n=[],e=o[u],e.name&&(n.push(e.name.toLowerCase()),e.options&&e.options.aliases&&e.options.aliases.length))for(a=0;e.options.aliases.length>a;a++)n.push(e.options.aliases[a].toLowerCase());for(s=d(e.fn,"function")?e.fn():e.fn,i=0;n.length>i;i++)r=n[i],f=r.split("."),1===f.length?Modernizr[f[0]]=s:2===f.length&&(!Modernizr[f[0]]||Modernizr[f[0]]instanceof Boolean||(Modernizr[f[0]]=new Boolean(Modernizr[f[0]])),Modernizr[f[0]][f[1]]=s),t.push((s?"":"no-")+f.join("-"))}}for(t=[],a=function(){return e.createElement.apply(e,arguments)},o=[],s={_version:"v3.0.0pre",_config:{classPrefix:"",enableClasses:!0,usePrefixes:!0},_q:[],on:function(n,e){setTimeout(function(){e(this[n])},0)},addTest:function(n,e,t){o.push({name:n,fn:e,options:t})},addAsyncTest:function(n){o.push({name:null,fn:n})}},Modernizr=function(){},Modernizr.prototype=s,Modernizr=new Modernizr,Modernizr.addTest("inlinesvg",function(){var n=a("div");return n.innerHTML="<svg/>","http://www.w3.org/2000/svg"==(n.firstChild&&n.firstChild.namespaceURI)}),Modernizr.addTest("canvas",function(){var n=a("canvas");return!(!n.getContext||!n.getContext("2d"))}),i=a("canvas"),Modernizr.addTest("todataurljpeg",function(){return!!Modernizr.canvas&&0===i.toDataURL("image/jpeg").indexOf("data:image/jpeg")}),Modernizr.addTest("todataurlpng",function(){return!!Modernizr.canvas&&0===i.toDataURL("image/png").indexOf("data:image/png")}),Modernizr.addTest("todataurlwebp",function(){return!!Modernizr.canvas&&0===i.toDataURL("image/webp").indexOf("data:image/webp")}),f(),delete s.addTest,delete s.addAsyncTest,r=0;Modernizr._q.length>r;r++)Modernizr._q[r]();n.Modernizr=Modernizr})(this,document);


// Copied from: http://stackoverflow.com/questions/18087207/detecting-browsers-that-are-not-supported-by-jquery-2?
function browser_jquery2_ready() {

    if  (
        ( !Array.prototype.indexOf ) ||
        ( !Array.prototype.forEach ) ||
        ( !String.prototype.indexOf ) ||
        ( !String.prototype.trim ) ||
        ( !Function.prototype.bind ) ||
        ( !Object.keys ) ||
        ( !Object.create ) ||
        ( !JSON ) ||
        ( !JSON.stringify ) ||
        ( !JSON.stringify.length ) ||
        ( JSON.stringify.length < 3 )
    )
    {
        return false;
    }

    // # local storage support
    // source: http://diveintohtml5.info/storage.html

    try {
        var local_storage_support = ( 'localStorage' in window && window['localStorage'] !== null );
        if ( !local_storage_support ) {
            throw new Error("local_storage_support: failed");
        }
    }
    catch ( e ) {
        return false;
    }

    // # AJAX uploads

    if ( !window.FormData || !window.FileReader ) {
        return false;
    }

    // # HTML data elements

    var body = $("body");
    body.data("browser_support_test",42);
    if ( body.data("browser_support_test") !== 42 ) {
        return false;
    }
    else {
        body.removeData("browser_support_test");
    }

    return true;
}

if ( ! Modernizr.inlinesvg || ! browser_jquery2_ready()) {
    document.querySelector("#compability").style.display = "block";
}