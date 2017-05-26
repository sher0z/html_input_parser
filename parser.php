<?php 

$in_file  = 'tmp/input.html';
$out_file = 'tmp/parsed.txt';

$html = file_get_contents($in_file);
$dom = new DOMDocument('1.0', 'UTF-8');
$internalErrors = libxml_use_internal_errors(true);
$dom->preserveWhiteSpace = false;
$dom->recover = true;
$dom->strictErrorChecking = false;
$dom->loadHTML($html);
$tags = $dom->getElementsByTagName('*');

$tag_type = '';
$tag_name = '';
$tag_value = '';

$out = '';
foreach ($tags as $tag) {
	$found = false;
	switch ($tag->nodeName)
	{
		case 'label':
       		$out .= $tag->nodeName."\t".$tag->nodeValue;
       		$out .= "\r\n";	
			break;	
		case 'input':
		   	$found = true;
			$tag_type = $tag->nodeName;
			$tag_name = $tag->getAttribute('name');
			$tag_value = $tag->getAttribute('value');
	       break;
		case 'textarea':
		   	$found = true;
			$tag_type = $tag->nodeName;
			$tag_name = $tag->getAttribute('name');
			$tag_value = $tag->nodeValue;
			break;
   }
   if($found)
   {
       $out .= $tag_type."\t".$tag_name."\t".$tag_value;
	   $out .= "\r\n";	
   }
}
file_put_contents($out_file, $out);
echo 'Completed.';
echo '<br/>';
echo 'In file: '.$in_file ;
echo '<br/>';
echo 'Out file: '.$out_file ;
echo '<hr/>';
echo date("Y-m-d h:i:sa");
