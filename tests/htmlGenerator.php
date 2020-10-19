<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true); 

$path = str_replace('tests', 'src', __DIR__) . '/HTMLGenerator.php';
require_once($path);

$html = new WC\HTMLGenerator();

$test = $html->get();
print $test;

$doctype = $html->get('!doctype', '', ['html' => 'html']);
print $doctype;

$anchor = $html->get('a', 'This is a test link', [
  'href'      => 'http://www.cbc.ca/news',
  'class'     => 'container col-md-6',
  'id'        => 'my-anchor',
  'data-rel'  => 'external',
  'target'    => '_blank'
]);

$br = $html->get('br');

$code = $html->get('code', '', [
    'id' => 'empty-code-tag'
]);

$p = $html->get('p', ($anchor . $br . 'Checking that the &lt;br&gt tag works' . $code), [
  'class' => 'container col-md-6',
  'id'    => 'my-para'
]);

$article = $html->get('article', $p);

$code = $html->get('main', $article);

print $code;

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

print $ul;

$blah = $html->get('blah', $article, [], true);

print '<p>Testing that the system will return null on an invalid HTML character : ';
print ($blah) ? 'The system returned ' . $blah : 'The system returned null';
print '</p>';
