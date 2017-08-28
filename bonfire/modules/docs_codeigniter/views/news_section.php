

<h1>Tutorial &minus; News section</h1>

<p>In the last section, we went over some basic concepts of the framework by writing a class that includes static pages. We cleaned up the URI by adding custom routing rules. Now it's time to introduce dynamic content and start using a database.</p>

<h2>Setting up your model</h2>

<p>Instead of writing database operations right in the controller, queries should be placed in a model, so they can easily be reused later. Models are the place where you retrieve, insert, and update information in your database or other data stores. They represent your data.</p>

<p>Open up the <dfn>application/models</dfn> directory and create a new file called <dfn>news_model.php</dfn> and add the following code. Make sure you've configured your database properly as described <a href="../database/configuration.html">here</a>.</p>

<pre>
&lt;?php
class News_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
}
</pre>

<p>This code looks similar to the controller code that was used earlier. It creates a new model by extending CI_Model and loads the database library. This will make the database class available through the <var>$this->db</var> object.</p>

<p>Before querying the database, a database schema has to be created. Connect to your database and run the SQL command below. Also add some seed records.</p>

<pre>
CREATE TABLE news (
	id int(11) NOT NULL AUTO_INCREMENT,
	title varchar(128) NOT NULL,
	slug varchar(128) NOT NULL,
	text text NOT NULL,
	PRIMARY KEY (id),
	KEY slug (slug)
);
</pre>

<p>Now that the database and a model have been set up, you'll need a method to get all of our posts from our database. To do this, the database abstraction layer that is included with CodeIgniter — <a href="../database/active_record.html">Active Record</a> — is used. This makes it possible to write your 'queries' once and make them work on <a href="../general/requirements.html">all supported database systems</a>. Add the following code to your model.</p>

<pre>
public function get_news($slug = FALSE)
{
	if ($slug === FALSE)
	{
		$query = $this->db->get('news');
		return $query->result_array();
	}

	$query = $this->db->get_where('news', array('slug' => $slug));
	return $query->row_array();
}
</pre>

<p>With this code you can perform two different queries. You can get all news records, or get a news item by its <a href="#" title="a URL friendly version of a string">slug</a>. You might have noticed that the <var>$slug</var> variable wasn't sanitized before running the query; Active Record does this for you.</p>

<h2>Display the news</h2>

<p>Now that the queries are written, the model should be tied to the views that are going to display the news items to the user. This could be done in our pages controller created earlier, but for the sake of clarity, a new "news" controller is defined. Create the new controller at <dfn>application/controllers/news.php</dfn>.</p>

<pre>
&lt;?php
class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
	}

	public function index()
	{
		$data['news'] = $this->news_model->get_news();
	}

	public function view($slug)
	{
		$data['news'] = $this->news_model->get_news($slug);
	}
}
</pre>

<p>Looking at the code, you may see some similarity with the files we created earlier. First, the "__construct" method: it calls the constructor of its parent class (<dfn>CI_Controller</dfn>) and loads the model, so it can be used in all other methods in this controller.</p>

<p>Next, there are two methods to view all news items and one for a specific news item. You can see that the <var>$slug</var> variable is passed to the model's method in the second method. The model is using this slug to identify the news item to be returned.</p>

<p>Now the data is retrieved by the controller through our model, but nothing is displayed yet. The next thing to do is passing this data to the views.</p>

<pre>
public function index()
{
	$data['news'] = $this->news_model->get_news();
	$data['title'] = 'News archive';

	$this->load->view('templates/header', $data);
	$this->load->view('news/index', $data);
	$this->load->view('templates/footer');
}
</pre>

<p>The code above gets all news records from the model and assigns it to a variable. The value for the title is also assigned to the <var>$data['title']</var> element and all data is passed to the views. You now need to create a view to render the news items. Create <dfn>application/views/news/index.php</dfn> and add the next piece of code.</p>

<pre>
&lt;?php foreach ($news as $news_item): ?&gt;

    &lt;h2&gt;&lt;?php echo $news_item['title'] ?&gt;&lt;/h2&gt;
    &lt;div id="main"&gt;
        &lt;?php echo $news_item['text'] ?&gt;
    &lt;/div&gt;
    &lt;p&gt;&lt;a href="news/&lt;?php echo $news_item['slug'] ?&gt;"&gt;View article&lt;/a&gt;&lt;/p&gt;

&lt;?php endforeach ?&gt;
</pre>

<p>Here, each news item is looped and displayed to the user. You can see we wrote our template in PHP mixed with HTML. If you prefer to use a template language, you can use CodeIgniter's <a href="../libraries/parser.html">Template Parser</a> class or a third party parser.</p>

<p>The news overview page is now done, but a page to display individual news items is still absent. The model created earlier is made in such way that it can easily be used for this functionality. You only need to add some code to the controller and create a new view. Go back to the news controller and add the following lines to the file.</p>

<pre>
public function view($slug)
{
	$data['news_item'] = $this->news_model->get_news($slug);

	if (empty($data['news_item']))
	{
		show_404();
	}

	$data['title'] = $data['news_item']['title'];

	$this->load->view('templates/header', $data);
	$this->load->view('news/view', $data);
	$this->load->view('templates/footer');
}
</pre>

<p>Instead of calling the <var>get_news()</var> method without a parameter, the <var>$slug</var> variable is passed, so it will return the specific news item. The only things left to do is create the corresponding view at <dfn>application/views/news/view.php</dfn>. Put the following code in this file.</p>

<pre>
&lt;?php
echo '&lt;h2&gt;'.$news_item['title'].'&lt;/h2&gt;';
echo $news_item['text'];
</pre>

<h2>Routing</h2>
<p>Because of the wildcard routing rule created earlier, you need need an extra route to view the controller that you just made. Modify your routing file (<dfn>application/config/routes.php</dfn>) so it looks as follows. This makes sure the requests reaches the news controller instead of going directly to the pages controller. The first line routes URI's with a slug to the view method in the news controller.</p>

<pre>
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';
$route['(:any)'] = 'pages/view/$1';
$route['default_controller'] = 'pages/view';
</pre>

<p>Point your browser to your document root, followed by <dfn>index.php/news</dfn> and watch your news page.</p>
