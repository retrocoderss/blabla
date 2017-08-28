
<h1>Controllers</h1>

<p>Controllers are the heart of your application, as they determine how HTTP requests should be handled.</p>


<ul>
<li><a href="#what">What is a Controller?</a></li>
<li><a href="#hello">Hello World</a></li>
<li><a href="#functions">Functions</a></li>
<li><a href="#passinguri">Passing URI Segments to Your Functions</a></li>
<li><a href="#default">Defining a Default Controller</a></li>
<li><a href="#remapping">Remapping Function Calls</a></li>
<li><a href="#output">Controlling Output Data</a></li>
<li><a href="#private">Private Functions</a></li>
<li><a href="#subfolders">Organizing Controllers into Sub-folders</a></li>
<li><a href="#constructors">Class Constructors</a></li>
<li><a href="#reserved">Reserved Function Names</a></li>
</ul>


<a name="what"></a>
<h2>What is a Controller?</h2>

<p><dfn>A Controller is simply a class file that is named in a way that can be associated with a URI.</dfn></p>

<p>Consider this URI:</p>

<code>example.com/index.php/<var>blog</var>/</code>

<p>In the above example, CodeIgniter would attempt to find a controller named <dfn>blog.php</dfn> and load it.</p>

<p><strong>When a controller's name matches the first segment of a URI, it will be loaded.</strong></p>

<a name="hello"></a>
<h2>Let's try it:&nbsp; Hello World!</h2>

<p>Let's create a simple controller so you can see it in action.  Using your text editor, create a file called <dfn>blog.php</dfn>, and put the following code in it:</p>


<textarea class="textarea" style="width:100%" cols="50" rows="10">
&lt;?php
class Blog extends CI_Controller {

	public function index()
	{
		echo 'Hello World!';
	}
}
?&gt;
</textarea>



<p>Then save the file to your <dfn>application/controllers/</dfn> folder.</p>

<p>Now visit the your site using a URL similar to this:</p>

<code>example.com/index.php/<var>blog</var>/</code>

<p>If you did it right, you should see <samp>Hello World!</samp>.</p>

<p>Note: Class names must start with an uppercase letter.  In other words, this is valid:</p>

<code>&lt;?php<br />
class <var>Blog</var> extends CI_Controller {<br />
<br />
}<br />
?&gt;</code>

<p>This is <strong>not</strong> valid:</p>

<code>&lt;?php<br />
class <var>blog</var> extends CI_Controller {<br />
<br />
}<br />
?&gt;</code>

<p>Also, always make sure your controller <dfn>extends</dfn> the parent controller class so that it can inherit all its functions.</p>



<a name="functions"></a>
<h2>Functions</h2>

<p>In the above example the function name is <dfn>index()</dfn>.  The "index" function is always loaded by default if the
<strong>second segment</strong> of the URI is empty.  Another way to show your "Hello World" message would be this:</p>

<code>example.com/index.php/<var>blog</var>/<samp>index</samp>/</code>

<p><strong>The second segment of the URI determines which function in the controller gets called.</strong></p>

<p>Let's try it.  Add a new function to your controller:</p>


<textarea class="textarea" style="width:100%" cols="50" rows="15">
&lt;?php
class Blog extends CI_Controller {

	public function index()
	{
		echo 'Hello World!';
	}

	public function comments()
	{
		echo 'Look at this!';
	}
}
?&gt;
</textarea>

<p>Now load the following URL to see the <dfn>comment</dfn> function:</p>

<code>example.com/index.php/<var>blog</var>/<samp>comments</samp>/</code>

<p>You should see your new message.</p>

<a name="passinguri"></a>
<h2>Passing URI Segments to your Functions</h2>

<p>If your URI contains more then two segments they will be passed to your function as parameters.</p>

<p>For example, lets say you have a URI like this:</p>

<code>example.com/index.php/<var>products</var>/<samp>shoes</samp>/<kbd>sandals</kbd>/<dfn>123</dfn></code>

<p>Your function will be passed URI segments 3 and 4 ("sandals" and "123"):</p>

<code>
&lt;?php<br />
class Products extends CI_Controller {<br />
<br />
&nbsp;&nbsp;&nbsp;&nbsp;public function shoes($sandals, $id)<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $sandals;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $id;<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}<br />
?&gt;
</code>

<p class="important"><strong>Important:</strong>&nbsp; If you are using the <a href="routing.html">URI Routing</a> feature, the segments
passed to your function will be the re-routed ones.</p>


<a name="default"></a>
<h2>Defining a Default Controller</h2>

<p>CodeIgniter can be told to load a default controller when a URI is not present,
as will be the case when only your site root URL is requested.  To specify a default controller, open
your <dfn>application/config/routes.php</dfn> file and set this variable:</p>

<code>$route['default_controller'] = '<var>Blog</var>';</code>

<p>Where <var>Blog</var> is the name of the controller class you want used. If you now load your main index.php file without
specifying any URI segments you'll see your Hello World message by default.</p>



<a name="remapping"></a>
<h2>Remapping Function Calls</h2>

<p>As noted above, the second segment of the URI typically determines which function in the controller gets called.
CodeIgniter permits you to override this behavior through the use of the <kbd>_remap()</kbd> function:</p>

<code>public function _remap()<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;// Some code here...<br />
}</code>

<p class="important"><strong>Important:</strong>&nbsp; If your controller contains a function named <kbd>_remap()</kbd>, it will <strong>always</strong>
get called regardless of what your URI contains.  It overrides the normal behavior in which the URI determines which function is called,
allowing you to define your own function routing rules.</p>

<p>The overridden function call (typically the second segment of the URI) will be passed as a parameter to the <kbd>_remap()</kbd> function:</p>

<code>public function _remap(<var>$method</var>)<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;if ($method == 'some_method')<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->$method();<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
&nbsp;&nbsp;&nbsp;&nbsp;else<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this->default_method();<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}</code>

<p>Any extra segments after the method name are passed into <kbd>_remap()</kbd> as an optional second parameter. This array can be used in combination with PHP's <a href="http://php.net/call_user_func_array">call_user_func_array</a> to emulate CodeIgniter's default behavior.</p>

<code>public function _remap($method, $params = array())<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;$method = 'process_'.$method;<br />
&nbsp;&nbsp;&nbsp;&nbsp;if (method_exists($this, $method))<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return call_user_func_array(array($this, $method), $params);<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
&nbsp;&nbsp;&nbsp;&nbsp;show_404();<br />
}</code>


<a name="output"></a>
<h2>Processing Output</h2>

<p>CodeIgniter has an output class that takes care of sending your final rendered data to the web browser automatically.  More information on this can be found in the
<a href="views.html">Views</a> and <a href="../libraries/output.html">Output class</a> pages.  In some cases, however, you might want to
post-process the finalized data in some way and send it to the browser yourself.  CodeIgniter permits you to
add a function named <dfn>_output()</dfn> to your controller that will receive the finalized output data.</p>

<p><strong>Important:</strong>&nbsp; If your controller contains a function named <kbd>_output()</kbd>, it will <strong>always</strong>
be called by the output class instead of echoing the finalized data directly. The first parameter of the function will contain the finalized output.</p>

<p>Here is an example:</p>

<code>
public function _output($output)<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;echo $output;<br />
}</code>

<p class="important">Please note that your <dfn>_output()</dfn> function will receive the data in its finalized state.  Benchmark and memory usage data will be rendered,
cache files written (if you have caching enabled), and headers will be sent (if you use that <a href="../libraries/output.html">feature</a>)
before it is handed off to the _output() function.<br />
<br />
To have your controller's output cached properly, its <dfn>_output()</dfn> method can use:<br />

<code>if ($this-&gt;output-&gt;cache_expiration &gt; 0)<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;output-&gt;_write_cache($output);<br />
}</code>

If you are using this feature the page execution timer and memory usage stats might not be perfectly accurate
since they will not take into acccount any further processing you do.  For an alternate way to control output <em>before</em> any of the final processing is done, please see
the available methods in the <a href="../libraries/output.html">Output Class</a>.</p>

<a name="private"></a>
<h2>Private Functions</h2>


<p>In some cases you may want certain functions hidden from public access.  To make a function private, simply add an
underscore as the name prefix and it will not be served via a URL request. For example, if you were to have a function like this:</p>

<code>
private function _utility()<br />
{<br />
&nbsp;&nbsp;// some code<br />
}</code>

<p>Trying to access it via the URL, like this, will not work:</p>

<code>example.com/index.php/<var>blog</var>/<samp>_utility</samp>/</code>



<a name="subfolders"></a>
<h2>Organizing Your Controllers into Sub-folders</h2>

<p>If you are building a large application you might find it convenient to organize your controllers into sub-folders.  CodeIgniter permits you to do this.</p>

<p>Simply create folders within your <dfn>application/controllers</dfn> directory and place your controller classes within them.</p>

<p><strong>Note:</strong>&nbsp; When using this feature the first segment of your URI must specify the folder.  For example, lets say you have a controller
located here:</p>

<code>application/controllers/<kbd>products</kbd>/shoes.php</code>

<p>To call the above controller your URI will look something like this:</p>

<code>example.com/index.php/products/shoes/show/123</code>

<p>Each of your sub-folders may contain a default controller which will be
called if the URL contains only the sub-folder.  Simply name your default controller as specified in your
<dfn>application/config/routes.php</dfn> file</p>


<p>CodeIgniter also permits you to remap your URIs using its <a href="routing.html">URI Routing</a> feature.</p>


<h2><a name="constructors"></a>Class Constructors</h2>


<p>If you intend to use a constructor in any of your Controllers, you <strong>MUST</strong> place the following line of code in it:</p>

<code>parent::__construct();</code>

<p>The reason this line is necessary is because your local constructor will be overriding the one in the parent controller class so we need to manually call it.</p>

<code>
&lt;?php<br />
class <kbd>Blog</kbd> extends CI_Controller {<br />
<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public function <kbd>__construct()</kbd><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<var>parent::__construct();</var><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Your own constructor code<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}<br />
?&gt;</code>

<p>Constructors are useful if you need to set some default values, or run a default process when your class is instantiated.
Constructors can't return a value, but they can do some default work.</p>

<a name="reserved"></a>
<h2>Reserved Function Names</h2>

<p>Since your controller classes will extend the main application controller you
must be careful not to name your functions identically to the ones used by that class, otherwise your local functions
will override them. See <a href="reserved_names.html">Reserved Names</a> for a full list.</p>

<h2>That's it!</h2>

<p>That, in a nutshell, is all there is to know about controllers.</p>
