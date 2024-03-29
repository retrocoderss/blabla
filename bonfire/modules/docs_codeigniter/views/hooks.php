
<h1>Hooks - Extending the Framework Core</h1>

<p>CodeIgniter's Hooks feature provides a means to tap into and modify the inner workings of the framework without hacking the core files.
When CodeIgniter runs it follows a specific execution process, diagramed in the <a href="../overview/appflow.html">Application Flow</a> page.
There may be instances, however, where you'd like to cause some action to take place at a particular stage in the execution process.
For example, you might want to run a script right before your controllers get loaded, or right after, or you might want to trigger one of
your own scripts in some other location.
</p>

<h2>Enabling Hooks</h2>

<p>The hooks feature can be globally enabled/disabled by setting the following item in the <kbd>application/config/config.php</kbd> file:</p>

<code>$config['enable_hooks'] = TRUE;</code>


<h2>Defining a Hook</h2>

<p>Hooks are defined in <dfn>application/config/hooks.php</dfn> file.  Each hook is specified as an array with this prototype:</p>

<code>
$hook['pre_controller'] = array(<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class'&nbsp;&nbsp;&nbsp;&nbsp;=> 'MyClass',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'function' => 'Myfunction',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'filename' => 'Myclass.php',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'filepath' => 'hooks',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'params'&nbsp;&nbsp;&nbsp;=> array('beer', 'wine', 'snacks')<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);</code>

<p><strong>Notes:</strong><br />The array index correlates to the name of the particular hook point you want to
use.  In the above example the hook point is <kbd>pre_controller</kbd>. A list of hook points is found below.
The following items should be defined in your associative hook array:</p>

<ul>
<li><strong>class</strong>&nbsp; The name of the class you wish to invoke. If you prefer to use a procedural function instead of a class, leave this item blank.</li>
<li><strong>function</strong>&nbsp; The function name you wish to call.</li>
<li><strong>filename</strong>&nbsp; The file name containing your class/function.</li>
<li><strong>filepath</strong>&nbsp; The name of the directory containing your script.  Note: Your script must be located in a directory INSIDE your <kbd>application</kbd> folder, so the file path is relative to that folder.  For example, if your script is located in <dfn>application/hooks</dfn>, you will simply use <samp>hooks</samp> as your filepath.  If your script is located in <dfn>application/hooks/utilities</dfn> you will use <samp>hooks/utilities</samp> as your filepath. No trailing slash.</li>
<li><strong>params</strong>&nbsp; Any parameters you wish to pass to your script. This item is optional.</li>
</ul>


<h2>Multiple Calls to the Same Hook</h2>

<p>If want to use the same hook point with more then one script, simply make your array declaration multi-dimensional, like this:</p>

<code>
$hook['pre_controller']<kbd>[]</kbd> = array(<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class'&nbsp;&nbsp;&nbsp;&nbsp;=> 'MyClass',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'function' => 'Myfunction',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'filename' => 'Myclass.php',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'filepath' => 'hooks',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'params'&nbsp;&nbsp;&nbsp;=> array('beer', 'wine', 'snacks')<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);<br />
<br />
$hook['pre_controller']<kbd>[]</kbd> = array(<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class'&nbsp;&nbsp;&nbsp;&nbsp;=> 'MyOtherClass',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'function' => 'MyOtherfunction',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'filename' => 'Myotherclass.php',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'filepath' => 'hooks',<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'params'&nbsp;&nbsp;&nbsp;=> array('red', 'yellow', 'blue')<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);</code>

<p>Notice the brackets after each array index:</p>

<code>$hook['pre_controller']<kbd>[]</kbd></code>

<p>This permits you to have the same hook point with multiple scripts.  The order you define your array will be the execution order.</p>


<h2>Hook Points</h2>

<p>The following is a list of available hook points.</p>

<ul>
		<li><strong>pre_system</strong><br />
			Called very early during system execution.  Only the benchmark and hooks class have been loaded at this point. No routing or other processes have happened.</li>
		<li><strong>pre_controller</strong><br />
			Called immediately prior to any of your controllers being called. All base classes, routing, and security checks have been done.</li>
		<li><strong>post_controller_constructor</strong><br />
			Called immediately after your controller is instantiated, but prior to any method calls happening.</li>
		<li><strong>post_controller</strong><br />
			Called immediately after your controller is fully executed.</li>
		<li><strong>display_override</strong><br />
			Overrides the <dfn>_display()</dfn> function, used to send the finalized page to the web browser at the end of system execution.  This permits you to
			use your own display methodology.  Note that you will need to reference the CI superobject with <dfn>$this->CI =&amp; get_instance()</dfn> and then the finalized data will be available by calling <dfn>$this->CI->output->get_output()</dfn></li>
		<li><strong>cache_override</strong><br />
			Enables you to call your own function instead of the <dfn>_display_cache()</dfn> function in the output class.  This permits you to use your own cache display mechanism.</li>
		<li><strong>post_system</strong><br />
			Called after the final rendered page is sent to the browser, at the end of system execution after the finalized data is sent to the browser.</li>
	</ul>