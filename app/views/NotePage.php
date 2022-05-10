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
function relativeDate($datetime) {
	$todayStart = new DateTime();
	$hoursBeforeNow = $todayStart.diff($datetime) / 3600.0;
	$todayStart->setTime(0, 0, 0); // midnight
	$hours = $todayStart->diff($datetime) / 3600.0;
	if ($hours < 0) {
		return $datetime->format('Y-m-d');
	} else if ($hoursBeforeNow < 1.0) {
		return "minutes ago";
	} else if ($hoursBeforeNow <= 24.0) {
		return "today";
	} else if ($hours <= 24.0*10.0) {
		return sprintf("%d days ago", int($hours / 24.0));
	} else {
		return $datetime->format('Y-m-d');
	}
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
    	body {
			font-family: "Helvetica Neue", helvetica, sans-serif;   
			margin: 1em 1em 1em 1em;
			width: 700px;
			line-height: 1.5em;
    	}
        .container {
            max-width: 680px;
        }

		div.metadata {
			padding-top: 1em;
			margin-left: 1em;
			color: #888888;
		}
		
	    span.creation {
	    	color: #88aa88;
	    }
	    
		span.tags {
			color: #666666;
		}
		span.tags em {
		    color: rgb(170, 85, 17);
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
    <?php echo $note->getContentAsHTML(); ?>
    </div>
    <div class="metadata">
    <span class="creation">
    <?php echo relativeDate($note->getCreationDateTime()); ?>
    </span>
    &nbsp;
    <span class="tags">tags:
    <?php foreach ($tagArray as $tag): ?>
    <em><?php echo $tag; ?></em> 
    <?php endforeach; ?>
    </span>
    &nbsp;
    <a href="<?php echo $base_href . 'edit/?ref=' . $note->getRef(); ?>">edit</a>
    </div>
</div>

</body>

</html>
