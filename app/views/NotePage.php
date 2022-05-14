<!DOCTYPE html>
<?php
$base_href = $args['base_href'];
$note = $args['note'];
$tagArray = explode(' ', $note->getTags());
function URIForAction($base_href, $action) {
	return $base_href . $action;
}
function insertAction($base_href, $action) {
	echo URIForAction($base_href, $action);
}
function tagsArray($tags) {
        if (is_null($tags)) {
            return array();
        }
	return explode(' ', $tags);
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note: <?php echo $note->getTitle(); ?></title>
    <!-- link rel="stylesheet" href="//bootswatch.com/flatly/bootstrap.css"-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
    	body {
			font-family: "Helvetica Neue", helvetica, sans-serif;   
			margin: 1em 1em 1em 1em;
			line-height: 1.5em;
    	}
        .container {
            width: 680px;
            margin: auto;
        }

		div.metadata {
			padding-top: 1em;
			margin-left: 1em;
			color: #888888;
		}
		
	    span.creation {
	    	color: #88aa88;
	    }
	    
		span.tags span {
		    color: rgb(170, 85, 17);
		}
        textarea {
            resize: vertical; /* allow only vertical stretch */
        }
        a.destructive {
        	color: rgb(128, 0, 0);
        }
    </style>
</head>

<body>

<div class="container">
    <div class="page-header">
        <h2><?php echo $note->getTitle(); ?></h2>
    </div>
    <div class="body">
    <?php echo $note->getContentAsHTML(); ?>
    </div>
    <div class="metadata">
    <span class="creation">
    <?php echo relativeDate($note->getCreationDateTime()); ?>
    </span>
    &nbsp;
    <span class="tags"><?php foreach ($tagArray as $tag): ?>
    <span><?php echo $tag; ?></span> 
    <?php endforeach; ?></span>
    &nbsp;
    <a href="<?php echo $base_href . 'edit/?ref=' . $note->getRef(); ?>">edit</a>
    &nbsp;
    <a href="<?php echo $base_href . 'list/'; ?>">index</a>
    </div>
</div>

</body>

</html>
