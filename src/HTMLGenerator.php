<?php
/**
 * HTML Generator Class file.
 *  
 * @author Alfredo Scaini
 * @package alfredoscaini\HTMLGenerator
 * @version 1.0 
*/

namespace WC;

/**
 * HTML Generator class used to create HTML elements through code.
 * 
 */
class HTMLGenerator {
  /**
   * The basic syntax of any element
   * 
   * @var string
  */  
  private $element = null;

  /**
   * A variable holding a listing of all elements available
   * 
   * @var array
   */
  private $element_list = [];
  
  /**
   * Constructor method.
   * 
   * 
   */
  public function __construct() {
    $this->element = [
      'close'  => '<[% element %][%attributes %]>[% content %]</[% element %]>',
      'open'   => '<[% element %][%attributes %] />'
    ];
    $this->element_list = $this->elementListing();
  }

  /**
   * get method.  Allows classes to call private methods and properties
   * 
   * @param string $element A key that tells us what is requested
   * @param string $content The content the user would like added between the tags
   * @param array  $attributes An array of attributes to add within the tag
   * @param int $verify A boolean to check if the user wants to verify that the element is an actual element.
   * 
   * @return any 
   */
  public function get(string $element = '', string $content = '', array $attributes = [], bool $verify = false) {
    try {
      if (strlen(trim($element)) == 0) {
        throw new \Exception('Invalid Element');
      }
    } catch(\Exception $e) {
      return null;
    }

    if ($verify) {
      if (!in_array($element, $this->element_list)) {
        return null;
      }
    }
    
    $placeholders = [
      'element'    => $element,
      'content'    => (trim($content)) ?? null,
      'attributes' => ($attributes) ?? []
    ];

    return $this->html($placeholders);
  }

  
  /**
   * html method.  
   * 
   * Replaces any placeholders with actual content and returns the HTML.
   * 
   * @param array $data An array of key values pairs that we will use to find the placeholder and replace it
   * 
   * @return string the updated HTML string.
   */
  private function html(array $data = []) : string {
    $content = $this->element['close'];

    // Determine if the element is a void element (open) or has a closing tag (close).
    $is_open = $data['element'] . ' /';
    if (in_array($is_open, $this->element_list)) {
      $content = $this->element['open'];
    }

    // replace the element
    $pattern = '/(\[%)(\s*+)element(\s*+)(%\])/';
    $content = preg_replace($pattern, $data['element'], $content, -1);

    if (isset($data['content'])) {
      $pattern = '/(\[%)(\s*+)content(\s*+)(%\])/';
      $content = preg_replace($pattern, $data['content'], $content, -1);
    }

    $attributes = '';
    foreach($data['attributes'] as $key => $value) {
      $attribute = $key .'="' . str_replace('"', '\"', $value) . '"';
      if ($key == $value) {
        $attribute = $key;
      }

      $attributes .= ' ' . $attribute;
    }

    $pattern = '/(\[%)(\s*+)attributes(\s*+)(%\])/';
    $content = preg_replace($pattern, $attributes, $content, -1);

    //  any remaining placeholders
    $pattern = '/(\[%)(\s*+)([a-zA-Z0-9 _]*)(\s*+)(%\])/';
    $content = preg_replace($pattern, '', $content, -1);

    return $content;
  }


  /**
   * getElement method. Will retrieve the template and return it as a string
   * 
   * @param string $element The element that is being requested
   * 
   * @return string A combined output
   */
  private function getElement(string $element = '') : string {
    $content = '';
    $file    = $element . '.html';
    

    $path = $this->settings['dir.elements'] . $file;
    if ($this->exists($this->settings['dir.elements'], $file)) {
      $content = file_get_contents($path);
    }

    return $content;
  }

  /**
   * elementListing method.
   * 
   * This method returns an array of all elements available in HTML.
   * 
   * 
   * @return array Listing of all elements
   */
  private function elementListing() : array {
    return [
      '!doctype /',  //  	Defines a document type 	 
      'a',           //  	Specific a anchor (Hyperlink) Use for link in internal/external web documents. 	 
      'abbr',        //  	Describes an abbreviation (acronyms) 	 
      'acronym',     //  	Describes an acronyms 	
      'address',     //  	Describes an address information 	 
      'applet',      //  	Embedding an applet in HTML document 	
      'area /',      //  	Defines an area in an image map 	 
      'article',     //  	Defines an article 	
      'aside',       //  	Describes contain set(or write) on aside place in page contain 	
      'audio',       //  	Specific audio content 	
      'b',           //  	Specific text weight bold 	 
      'base /',      //  	Define a base URL for all the links with in a web page 	 
      'basefont',    //  	Describes a default font color, size, face in a document 	
      'bb',          //  	Define browser command, that command invoke as per client action 
      'bdo',         //  	Specific direction of text display 	 
      'big',         //  	Defines a big text 	
      'blockquote',  //  	Specifies a long quotation 	 
      'body',        //  	Defines a main section(body) part in HTML document 	 
      'br /',        //  	Specific a single line break 	 
      'button',      //  	Specifies a press/push button 	 
      'canvas',      //  	Specifies the display graphics on HTML web documment 	
      'caption',     //  	Define a table caption 	 
      'center',      //  	Specifies a text is display in center align 	
      'cite',        //  	Specifies a text citation 	 
      'code',        //  	Specifies computer code text 	 
      'col /',       //  	Specifies a each column within a 'colgroup' element in table 	 
      'colgroup',    //  	Defines a group of one or more columns inside table 	 
      'command /',   //  	Define a command button, invoke as per user action 	
      'datagrid',    //  	Define a represent data in datagrid either list wise or tree wise
      'datalist',    //  	Define a list of pre-defined options surrounding 'input',
      'dd',          //  	Defines a definition description in a definition list 	 
      'del',         //  	Specific text deleted in web document 	 
      'details',     //  	Define a additional details hide or show as per user action 	
      'dfn',         //  	Define a definition team 	 
      'dialog',      //  	Define a chat conversation between one or more person
      'dir',         //  	Define a directory list 	
      'div',         //  	Define a division part 	 
      'dl',          //  	Define a definition list 	 
      'dt',          //  	Define a definition team 	 
      'em',          //  	Define a text is emphasize format 	 
      'embed /',     //  	Define a embedding external application using a relative plug-in 	
      'eventsource', //  	Defines a source of event generates to remote server
      'fieldset',    //  	Defines a grouping of related form elements 	 
      'figcaption',  //  	Represents a caption text corresponding with a figure element 	
      'figure',      //  	Represents self-contained content corresponding with a 'figcaption' element 	
      'font',        //  	Defines a font size, font face and font color for its text 	
      'footer',      //  	Defines a footer section containing details about the author, copyright, contact us, sitemap, or links to related documents. 	
      'form',        //  	Defines a form section that having interactive input controls to submit form information to a server. 	 
      'frame',       //  	Defines frame window. 	
      'frameset',    //  	Used to holds one or more 'frame' elements. 	
      'h1',          //  	Defines a Headings level from 1 to 6 different sizes. 	 
      'h2',          //  	Defines a Headings level from 1 to 6 different sizes. 	 
      'h3',          //  	Defines a Headings level from 1 to 6 different sizes. 	 
      'h4',          //  	Defines a Headings level from 1 to 6 different sizes. 	 
      'h5',          //  	Defines a Headings level from 1 to 6 different sizes. 	 
      'h6',          //  	Defines a Headings level from 1 to 6 different sizes. 	 
      'head',        //  	Defines header section of HTML document. 	 
      'header',      //  	Defines as a container that hold introductory content or navigation links. 	
      'hgroup',      //  	Defines the heading of a section that hold the h1 to h6 tags. 
      'hr /',        //  	Represent a thematic break between paragraph-level tags. It is typically draw horizontal line. 	 
      'html',        //  	Define a document is a HTML markup language 	 
      'i',           //  	Defines a italic format text 	 
      'iframe',      //  	Defines a inline frame that embedded external content into current web document. 	 
      'img /',       //  	Used to insert image into a web document. 	 
      'input /',     //  	Define a get information in selected input 	 
      'ins',         //  	Used to indicate text that is inserted into a page and indicates changes to a document. 	 
      'isindex',     //  	Used to create a single line search prompt for querying the contents of the document. 	
      'kbd',         //  	Used to identify text that are represents keyboard input. 	 
      'keygen /',    //  	Used to generate signed certificate, which is used to authenticate to services.
      'label',       //  	Used to caption a text label with a form 'input' element. 	 
      'legend',      //  	Used to add a caption (title) to a group of related form elements that are grouped together into the 'fieldset' tag.
      'li',          //  	Define a list item either ordered list or unordered list.
      'link /',      //  	Used to load an external stylesheets into HTML document. 	 
      'map',         //  	Defines an clickable image map. 	 
      'mark',        //  	Used to highlighted (marked) specific text. 	
      'menu',        //  	Used to display a unordered list of items/menu of commands. 	 
      'meta /',      //  	Used to provide structured metadata about a web page. 	 
      'meter',       //  	Used to measure data within a given range. 	
      'nav',         //  	Used to defines group of navigation links. 	
      'noframes',    //  	Used to provide a fallback content to the browser that does not support the 'frame' element. 	
      'noscript',    //  	Used to provide an fall-back content to the browser that does not support the JavaScript. 	 
      'object',      //  	Used to embedded objects such as images, audio, videos, Java applets, and Flash animations. 	 
      'ol',          //  	Defines an ordered list of items. 	 
      'optgroup',    //  	Used to create a grouping of options, the related options are grouped under specific headings. 	 
      'option',      //  	Represents option items within a 'select', 'optgroup' or 'datalist' element. 	 
      'output',      //  	Used for representing the result of a calculation. 	
      'p',           //  	Used to represents a paragraph text. 	 
      'param /',     //  	Provides parameters for embedded object element. 	 
      'pre',         //  	Used to represents preformatted text. 	 
      'progress',    //  	Represents the progress of a task. 	
      'q',           //  	Represents the short quotation. 	 
      'rp',          //  	Used to provide parentheses around fall-back content to the browser that does not support the ruby annotations. 	
      'rt',          //  	Specifies the ruby text of ruby annotation. 	
      'ruby',        //  	Used to represents a ruby annotation. 	
      's',           //  	Text display in strikethrough style. 	 
      'samp',        //  	Represents text that should be interpreted as sample output from a computer program. 	 
      'script',      //  	Defines client-side JavaScript. 	 
      'section',     //  	Used to divide a document into number of different generic section. 	
      'select',      //  	Used to create a drop-down list. 	 
      'small',       //  	Used to makes the text one size smaller. 	 
      'source /',    //  	Used to specifies multiple media resources. 	
      'span',        //  	Used to grouping and applying styles to inline elements. 	 
      'strike',      //  	Represents strikethrough text. 	
      'strong',      //  	Represents strong emphasis greater important text. 	 
      'style',       //  	Used to add CSS style to an HTML document. 	 
      'sub',         //  	Represents inline subscript text. 	 
      'sup',         //  	Represents inline superscript text. 	 
      'table',       //  	Used to defines a table in an HTML document. 	 
      'tbody',       //  	Used for grouping table rows. 	 
      'td',          //  	Used for creates standard data cell in HTML table. 	 
      'textarea',    //  	Create multi-line text input. 	 
      'tfoot',       //  	Used to adding a footer to a table that containing summary of the table data. 	 
      'th',          //  	Used for creates header of a group of cell in HTML table. 	 
      'thead',       //  	Used to adding a header to a table that containing header information of the table. 	 
      'time',        //  	Represents the date and/or time in an HTML document. 	
      'title',       //  	Represents title to an HTML document. 	 
      'tr',          //  	Defines a row of cells in a table. 	 
      'track /',     //  	Represents text tracks for both the 'audio', and 'video' tags. 	
      'tt',          //  	Represents teletype text. 	
      'u',           //  	Represents underlined text. 	 
      'ul',          //  	Defines an unordered list of items. 	 
      'var',         //  	Represents a variable in a computer program or mathematical equation. 	 
      'video',       //  	Used to embed video content. 	
      'wbr /'        //  	Defines a word break opportunity in a long string of text. 	
    ];
  } // end of elementListing
}