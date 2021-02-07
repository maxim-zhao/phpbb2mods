<html>
<head>
    <title>HTML Special Characters Script</title>
</head>
<body>
<h2>HTML Special Characters Script</h2>
<p>This script will convert text is submitted so that it will use HTML Special Characters. The converted text will be displayed in the textbox. <a href="http://www.php.net/htmlspecialchars">View a list of the conversions made</a><br /><br />
<?php
if ( isset($_POST['submit']) )
{
    ?>
    <b>Result:</b><br />
    <textarea rows="5" cols="30"><?php echo htmlspecialchars(htmlspecialchars($_POST['text'])); ?></textarea><br /><br />
    <?php
}
$post_text = ( isset($_POST['text']) ) ? htmlspecialchars($_POST['text']) : '';
?>
<form action="./specialchars.php" method="post">
    <textarea name="text" rows="5" cols="30"><?php echo $post_text; ?></textarea><br />
    <input type="submit" name="submit" value="Convert" />
</form>
</body>
</html>