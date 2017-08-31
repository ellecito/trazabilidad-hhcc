Ext.data.JsonP.AjaxBootstrapSelectList({"tagname":"class","name":"AjaxBootstrapSelectList","autodetected":{},"files":[{"filename":"AjaxBootstrapSelectList.js","href":null}],"params":[{"tagname":"params","type":"AjaxBootstrapSelect","name":"plugin","doc":"<p>The plugin instance.</p>\n","html_type":"<a href=\"#!/api/AjaxBootstrapSelect\" rel=\"AjaxBootstrapSelect\" class=\"docClass\">AjaxBootstrapSelect</a>"}],"return":{"type":"AjaxBootstrapSelectList","name":"return","doc":"<p>A new instance of this class.</p>\n","properties":null,"html_type":"<a href=\"#!/api/AjaxBootstrapSelectList\" rel=\"AjaxBootstrapSelectList\" class=\"docClass\">AjaxBootstrapSelectList</a>"},"members":[{"name":"$status","tagname":"property","owner":"AjaxBootstrapSelectList","id":"property-S-status","meta":{}},{"name":"cache","tagname":"property","owner":"AjaxBootstrapSelectList","id":"property-cache","meta":{}},{"name":"plugin","tagname":"property","owner":"AjaxBootstrapSelectList","id":"property-plugin","meta":{}},{"name":"selected","tagname":"property","owner":"AjaxBootstrapSelectList","id":"property-selected","meta":{}},{"name":"title","tagname":"property","owner":"AjaxBootstrapSelectList","id":"property-title","meta":{}},{"name":"build","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-build","meta":{}},{"name":"cacheGet","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-cacheGet","meta":{}},{"name":"cacheSet","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-cacheSet","meta":{}},{"name":"destroy","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-destroy","meta":{}},{"name":"refresh","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-refresh","meta":{}},{"name":"replaceOptions","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-replaceOptions","meta":{}},{"name":"restore","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-restore","meta":{}},{"name":"restoreTitle","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-restoreTitle","meta":{}},{"name":"setStatus","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-setStatus","meta":{}},{"name":"setTitle","tagname":"method","owner":"AjaxBootstrapSelectList","id":"method-setTitle","meta":{}}],"alternateClassNames":[],"aliases":{},"id":"class-AjaxBootstrapSelectList","short_doc":"Maintains the select options and selectpicker menu. ...","component":false,"superclasses":[],"subclasses":[],"mixedInto":[],"mixins":[],"parentMixins":[],"requires":[],"uses":[],"html":"<div><div class='doc-contents'><p>Maintains the select options and selectpicker menu.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>plugin</span> : <a href=\"#!/api/AjaxBootstrapSelect\" rel=\"AjaxBootstrapSelect\" class=\"docClass\">AjaxBootstrapSelect</a><div class='sub-desc'><p>The plugin instance.</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/AjaxBootstrapSelectList\" rel=\"AjaxBootstrapSelectList\" class=\"docClass\">AjaxBootstrapSelectList</a></span><div class='sub-desc'><p>A new instance of this class.</p>\n</div></li></ul></div><div class='members'><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-property'>Properties</h3><div class='subsection'><div id='property-S-status' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-property-S-status' class='name expandable'>$status</a> : jQuery<span class=\"signature\"></span></div><div class='description'><div class='short'><p>DOM element used for updating the status of requests and list counts.</p>\n</div><div class='long'><p>DOM element used for updating the status of requests and list counts.</p>\n</div></div></div><div id='property-cache' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-property-cache' class='name expandable'>cache</a> : Object<span class=\"signature\"></span></div><div class='description'><div class='short'>Container for cached data. ...</div><div class='long'><p>Container for cached data.</p>\n<p>Defaults to: <code>{}</code></p></div></div></div><div id='property-plugin' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-property-plugin' class='name expandable'>plugin</a> : <a href=\"#!/api/AjaxBootstrapSelect\" rel=\"AjaxBootstrapSelect\" class=\"docClass\">AjaxBootstrapSelect</a><span class=\"signature\"></span></div><div class='description'><div class='short'><p>Reference the plugin for internal use.</p>\n</div><div class='long'><p>Reference the plugin for internal use.</p>\n</div></div></div><div id='property-selected' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-property-selected' class='name expandable'>selected</a> : Array<span class=\"signature\"></span></div><div class='description'><div class='short'>Container for current selections. ...</div><div class='long'><p>Container for current selections.</p>\n<p>Defaults to: <code>[]</code></p></div></div></div><div id='property-title' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-property-title' class='name expandable'>title</a> : Object<span class=\"signature\"></span></div><div class='description'><div class='short'><p>Containers for previous titles.</p>\n</div><div class='long'><p>Containers for previous titles.</p>\n</div></div></div></div></div><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-method'>Methods</h3><div class='subsection'><div id='method-build' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-build' class='name expandable'>build</a>( <span class='pre'>data</span> ) : String<span class=\"signature\"></span></div><div class='description'><div class='short'>Builds the options for placing into the element. ...</div><div class='long'><p>Builds the options for placing into the element.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>data</span> : Array<div class='sub-desc'><p>The data to use when building options for the select list. Each\n  array item must be an Object structured as follows:\n    - {int|string} value: Required, a unique value identifying the\n      item. Optionally not required if divider is passed instead.\n    - {boolean} [divider]: Optional, if passed all other values are\n      ignored and this item becomes a divider.\n    - {string} [text]: Optional, the text to display for the item.\n      If none is provided, the value will be used.\n    - {String} [class]: Optional, the classes to apply to the option.\n    - {boolean} [disabled]: Optional, flag that determines if the\n      option is disabled.\n    - {boolean} [selected]: Optional, flag that determines if the\n      option is selected. Useful only for select lists that have the\n      \"multiple\" attribute. If it is a single select list, each item\n      that passes this property as true will void the previous one.\n    - {Object} [data]: Optional, the additional data attributes to\n      attach to the option element. These are processed by the\n      bootstrap-select plugin.</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>String</span><div class='sub-desc'><p>HTML containing the <option> elements to place in the element.</p>\n</div></li></ul></div></div></div><div id='method-cacheGet' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-cacheGet' class='name expandable'>cacheGet</a>( <span class='pre'>key, [defaultValue]</span> ) : *<span class=\"signature\"></span></div><div class='description'><div class='short'>Retrieve data from the cache. ...</div><div class='long'><p>Retrieve data from the cache.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>key</span> : string<div class='sub-desc'><p>The identifier name of the data to retrieve.</p>\n</div></li><li><span class='pre'>defaultValue</span> : * (optional)<div class='sub-desc'><p>The default value to return if no cache data is available.</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>*</span><div class='sub-desc'><p>The cached data or defaultValue.</p>\n</div></li></ul></div></div></div><div id='method-cacheSet' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-cacheSet' class='name expandable'>cacheSet</a>( <span class='pre'>key, value</span> ) : void<span class=\"signature\"></span></div><div class='description'><div class='short'>Save data to the cache. ...</div><div class='long'><p>Save data to the cache.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>key</span> : string<div class='sub-desc'><p>The identifier name of the data to store.</p>\n</div></li><li><span class='pre'>value</span> : *<div class='sub-desc'><p>The value of the data to store.</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>void</span><div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-destroy' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-destroy' class='name expandable'>destroy</a>( <span class='pre'></span> )<span class=\"signature\"></span></div><div class='description'><div class='short'>Destroys the select list. ...</div><div class='long'><p>Destroys the select list.</p>\n</div></div></div><div id='method-refresh' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-refresh' class='name expandable'>refresh</a>( <span class='pre'>triggerChange</span> )<span class=\"signature\"></span></div><div class='description'><div class='short'>Refreshes the select list. ...</div><div class='long'><p>Refreshes the select list.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>triggerChange</span> : Object<div class='sub-desc'></div></li></ul></div></div></div><div id='method-replaceOptions' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-replaceOptions' class='name expandable'>replaceOptions</a>( <span class='pre'>data</span> ) : void<span class=\"signature\"></span></div><div class='description'><div class='short'>Replaces the select list options with provided data. ...</div><div class='long'><p>Replaces the select list options with provided data.</p>\n\n<p>It will also inject any preserved selections if the preserveSelected\noption is enabled.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>data</span> : Array<div class='sub-desc'><p>The data array to process.</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>void</span><div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-restore' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-restore' class='name expandable'>restore</a>( <span class='pre'></span> ) : boolean<span class=\"signature\"></span></div><div class='description'><div class='short'>Restores the select list to the last saved state. ...</div><div class='long'><p>Restores the select list to the last saved state.</p>\n<h3 class='pa'>Returns</h3><ul><li><span class='pre'>boolean</span><div class='sub-desc'><p>Return true if successful or false if no states are present.</p>\n</div></li></ul></div></div></div><div id='method-restoreTitle' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-restoreTitle' class='name expandable'>restoreTitle</a>( <span class='pre'></span> ) : void<span class=\"signature\"></span></div><div class='description'><div class='short'>Restores the previous title of the select element. ...</div><div class='long'><p>Restores the previous title of the select element.</p>\n<h3 class='pa'>Returns</h3><ul><li><span class='pre'>void</span><div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-setStatus' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-setStatus' class='name expandable'>setStatus</a>( <span class='pre'>[status]</span> ) : void<span class=\"signature\"></span></div><div class='description'><div class='short'>Sets a new status on the AjaxBootstrapSelectList.$status DOM element. ...</div><div class='long'><p>Sets a new status on the <a href=\"#!/api/AjaxBootstrapSelectList-property-S-status\" rel=\"AjaxBootstrapSelectList-property-S-status\" class=\"docClass\">AjaxBootstrapSelectList.$status</a> DOM element.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>status</span> : String (optional)<div class='sub-desc'><p>The new status to set, if empty it will hide it.</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>void</span><div class='sub-desc'>\n</div></li></ul></div></div></div><div id='method-setTitle' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='AjaxBootstrapSelectList'>AjaxBootstrapSelectList</span><br/></div><a href='#!/api/AjaxBootstrapSelectList-method-setTitle' class='name expandable'>setTitle</a>( <span class='pre'>title</span> ) : void<span class=\"signature\"></span></div><div class='description'><div class='short'>Sets a new title on the select element. ...</div><div class='long'><p>Sets a new title on the select element.</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>title</span> : String<div class='sub-desc'>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'>void</span><div class='sub-desc'>\n</div></li></ul></div></div></div></div></div></div></div>","meta":{}});