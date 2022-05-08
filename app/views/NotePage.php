<!DOCTYPE html>
<?php
$base_href = $args['base_href'];
$note = $args['note'];
$tagArray = explode($note->getTags(), ' ');
function URIForAction($base_href, $action) {
	return $base_href . $action;
}
function insertAction($base_href, $action) {
	echo URIForAction($base_href, $action);
}
function tagsArray($tags) {
	return explode($tags, ' ');
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note: <?php echo $note->getTitle(); ?></title>
    <link rel="stylesheet" href="//bootswatch.com/flatly/bootstrap.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .container {
            max-width: 680px;
        }

        textarea {
            resize: vertical; /* allow only vertical stretch */
        }
    </style>
</head>

<body>

<div class="container">
    <div class="page-header">
        <h2><?php echo $note->getTitle(); ?></h2>
    </div>
    <div class="body">
    <?php echo $note->getContent(); ?>
    </div>
    <div class="tags">
    <?php echo $note->getTags(); ?>
    </div>
    <div class="tags">
    <?php foreach ($tagArray as $tag): ?>
    <em><?php echo $tag; ?></em> 
    <?php endforeach; ?>
    </div>
</div>

</body>

</html>
