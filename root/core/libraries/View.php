<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_View
{
	protected $CI;
	
	protected $title       = null;
	protected $description = null;
	protected $keywords    = null;
	
	protected $metatag  = array();
	protected $css_files = array();
	protected $js_files  = array();
	protected $partials  = array();
	
	protected $layout     = "default";
	protected $body_class = null;

	
	protected $data = array();

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper(array('view'));
	}

/*
|======================================================================
| SETTERS
|======================================================================
*/
	
	public function set_title($title = null)
	{
		$title or $title = config('site.name');
		$this->title = $title;
		return $this;
	}

	public function set_description($description = null)
	{
		$description or $description = config('site.description');
		$this->description = $description;
		return $this;
	}

	public function set_keywords($keywords = null)
	{
		$keywords or $keywords = config('site.keywords');
		$this->keywords = $keywords;
		return $this;
	}

	public function set_layout($layout = 'default')
	{
		$this->layout = $layout;
		return $this;
	}

	public function set_body_class($body_class = '')
	{
		$this->body_class = $body_class;
		return $this;
	}

/*
|======================================================================
| ADDERS
|======================================================================
*/

    /**
     * Add metatag
     *
     * @access  public
     * @param   mixed
     * @param   string
     * @return  object
     */
    public function add_meta($name, $content = null)
    {
        if (is_array($name))
        {
            foreach ($name as $key => $val)
            {
                $key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                $val = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
                $this->metatag[$key] = $val;
            }
        }
        else
        {
            $name    = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
            $this->metatag[$name] = $content;
        }
        return $this;
    }

    /**
     * Add CSS files
     *
     * @access  public
     * @param   mixed
     * @return  object
     */
    public function add_css($css)
    {
        $this->css_files = array_merge($this->css_files, (array) $css);
        return $this;
    }

    /**
     * Add JS files
     *
     * @access  public
     * @param   mixed
     * @return  object
     */
    public function add_js($js)
    {
        $this->js_files = array_merge($this->js_files, (array) $js);
        return $this;
    }

    /**
     * Add partial view
     *
     * @access  public
     * @param   string
     * @param   array
     * @param   string
     * @return  object
     */
    public function add_partial($name, $view, $data = array())
    {
        $this->partials[$name] = $this->CI->load->view('partials/'.$view, $data, true);
        return $this;
    }

/*
|======================================================================
| LOAD VIEW
|======================================================================
*/

	public function load($view, $data = array(), $return = false)
	{
		$_data = array(
			'title'       => $this->title,		// Page title
			'description' => $this->description,// Page description
			'keywords'    => $this->keywords,	// Page keywords
			'body_class'  => $this->body_class,	// Set <body> class
		);

		// Adding metatags
		$metatag = array();
		foreach ($this->metatag as $name => $content)
		{
            $metatag[] = (strpos($name, 'og:') === 0)
                            ? '<meta property="'.$name.'" content="'.$content.'">'."\n"
                            : '<meta name="'.$name.'" content="'.$content.'">'."\n";
		}
		$_data['metatag'] = implode("\n\t", $metatag);
		unset($name, $content);

        // Prepare additional CSS files
        $css = array();
        foreach ($this->css_files as $css_file)
            $css[] = css($css_file);
        $_data['css'] = implode("\n\t", $css);
        unset($css_file);

        // Prepare additional JS files
        $js = array();
        foreach ($this->js_files as $js_file)
            $js[] = js($js_file);
        $_data['js'] = implode("\n\t", $js);
        unset($js_file);

        // Load page layout
        $_data['layout'] = $this->CI->load->view('layouts/'.$this->layout, array(
        	'partials' => $this->partials,
        	'content' => $this->CI->load->view($view, $data, true),
        ), true);

		return $this->CI->load->view('template', $_data, $return);
	}

}

/* End of file View.php */
/* Location: ./application/libraries/View.php */