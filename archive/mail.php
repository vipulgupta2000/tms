
<?php

$to = 'nadeem1984ansari@gmail.com';

$subj = 'Test Mail';

$txt = "First line of text\nSecond line of text";

// Use wordwrap() if lines are longer than 70 characters
$txt = wordwrap($txt,70);

// Send email
$true = mail($to, $subj, $txt);

if($true==1)
{
echo "Mail Sent";
}
else {echo "Unable to Send Mail";}


?>


