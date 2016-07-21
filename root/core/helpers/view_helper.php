<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('_ci'))
{
    function _ci()
    {
        $CI =& get_instance();
        return $CI;
    }
}

/**
 * Get Assets URL
 * @param   string
 * @param   bool
 * @return  string
 */
if ( ! function_exists('assets_url'))
{
    function assets_url($uri = '')
    {
        $assets_url = base_url('assets').'/';
        if (config('site.use_cdn') and config('site.cdn_url') !== '')
        {
            $assets_url = config('site.cdn_url');
        }
        return $assets_url.trim($uri, '/');
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('css_url'))
{
    function css_url($file = null, $ext = true)
    {
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return $file;
        }
        return assets_url('css/'.$file = ($ext === true)?$file.'.css':$file);
    }
}

if ( ! function_exists('css'))
{
    function css($file = false, $media = false)
    {
        if (strlen($file) > 0)
        {
            $output = '<link rel="stylesheet" type="text/css" href="'.css_url($file).'"';
            if ($media) {
                $output .= ' media="'.$media.'"';
            }
            $output .= '>'."\n";
            return $output;
        }
        return null;
    }
}

// ----------------------------------------------------------------------------

if ( ! function_exists('js_url'))
{
    function js_url($file = null, $ext = true)
    {
        if (filter_var($file, FILTER_VALIDATE_URL))
        {
            return $file;
        }
        return assets_url('js/'.$file = ($ext === true)?$file.'.js':$file);
    }
}

if ( ! function_exists('js'))
{
    function js($file = false, $type = 'javascript')
    {
        if (strlen($file) > 0)
        {
            $output = '<script type="text/'.$type.'" src="'.js_url($file).'"></script>'."\n";
            return $output;
        }
        return null;
    }
}

// ----------------------------------------------------------------------------

if ( ! function_exists('img_url'))
{
    function img_url($file = null)
    {
        if (filter_var($file, FILTER_VALIDATE_URL))
        {
            return $file;
        }
        return assets_url('img/'.$file);
    }
}

if ( ! function_exists('img'))
{
    function img($file = false, $attrs = array())
    {
        if (strlen($file) > 0)
        {
            return '<img src="'.img_url($file).'"'._stringify_attributes($attrs).' />';
        }
        return null;
    }
}

if ( ! function_exists('img_alt'))
{
    function img_alt($width, $height = null, $text = null, $background = null, $foreground = null)
    {
        $params = array();

        if (is_array($width))
        {
            $params = $width;
        }
        else
        {
            $params['width']        = $width;
            $params['height']       = $height;
            $params['text']         = $text;
            $params['background']   = $background;
            $params['foreground']   = $foreground;
        }

        $params['height']       = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']         = (empty($params['text'])) ? $params['width'].' x '. $params['height'] : $params['text'];
        $params['background']   = (empty($params['background'])) ? 'CCCCCC' : $params['height'];
        $params['foreground']   = (empty($params['foreground'])) ? '969696' : $params['foreground'];

        return '<img src="http://placehold.it/'. $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'&text='. $params['text'].'" alt="Placeholder">';
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('ci_form'))
{
    function ci_form($form = '', $data = array())
    {
        if ($form !== '')
        {
            return _ci()->load->view('forms/'.$form, $data, true);
        }
        return null;
    }
}

/* End of file view_helper.php */
/* Location: ./application/helpers/view_helper.php */
