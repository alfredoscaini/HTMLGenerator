# HTMLGenerator
A library that will wrap an HTML element around content and add any attributes to that element tag.

## How Does it Work?
HTMLGenerator will take in 1 required parameter and 3 optional parameters: 
  1. The element name (required), 
  2. The content to add between the tags (optional)
  3. An array of attributes as key|value pairs (optional)
      1. For single attributes set the key to equal the value.
  4. A boolean flag if you want to verify that the HTML element is a valid HTML element (optional)

## Examples

### An element with a Single attribute
```
$html    = new WC\HTMLGenerator();
$doctype = $html->get('!doctype', '', ['html' => 'html']);
```

### An element with multiple attributes
```
$html   = new WC\HTMLGenerator();
$anchor = $html->get('a', 'This is a test link', [
  'href'      => 'https://www.example.com',
  'class'     => 'container col-md-6',
  'id'        => 'my-anchor',
  'data-rel'  => 'external',
  'target'    => '_blank'
]);
```

### Embedding HTML in HTML
```
$html = new WC\HTMLGenerator();
$li_1 = $html->get('li', 'List Item 01', [
  'class'     => 'blue',
  'id'        => 'item-01'
]);

$li_2 = $html->get('li', 'List Item 02', [
  'class'     => 'green',
  'id'        => 'item-02'
]);

$ul = $html->get('ul', ($li_1 . $li_2), [
  'class'     => 'red',
  'id'        => 'my-list'
]);
```

### Verifying that an Element Exists
```
$html = new WC\HTMLGenerator();
$blah = $html->get('blah', $article, [], true); // will return null
```
