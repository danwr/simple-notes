<!DOCTYPE html>
<?php
$base_href = $args['base_href'];

function URIForAction($base_href, $action) {
	return $base_href . $action . '/';
}
function insertAction($base_href, $action) {
	echo URIForAction($base_href, $action);
}
function insertNoteLink($base_href, $ref) {
        echo $base_href . 'note/?ref=' . $ref;
}
$filterTag = $args['tag'];

?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Notes</title>
    <!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

<?php if (isset($filterTag)): ?>
<h3>Tag: <?php echo $filterTag; ?></h3>
<?php endif; ?>
<?php if (!isset($filterTag)): ?>
<div class="container">
    <div class="page-header">
        <h2>Post a new note</h2>
    </div>
    <form role="form" action="<?php insertAction($base_href, 'new');?>" method="POST">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Title" name="title" required>
            <input class="form-control" type="text" placeholder="Tags" name="tags">
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="5" style="width:98%;" placeholder="What do you have in mind?" name="content" autofocus
                      required></textarea>
        </div>
        <div class="btn-group pull-right">
            <button class="btn btn-danger" type="reset">
                <span class="glyphicon glyphicon-remove"></span> Clear
            </button>
            <button class="btn btn-success" name="new" formaction="<?php insertAction($base_href, 'new');?>" type="submit" formmethod="POST">
                <span class="glyphicon glyphicon-send"></span>Send
            </button>
        </div>
    </form>
</div>
<?php endif; ?>
<?php if (!empty($args['notes'])): ?>
    <div class="container" id="notes">
        <div class="page-header">
            <h2>Previously sent</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th class="pull-right">Actions<br></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($args['notes'] as $note): ?>
                    <tr>
                        <td>
                            <small><a href="<?php insertNoteLink($base_href, $note->getRef()); ?>"><?php echo $note->getBriefTitle(); ?></a></small>
                        </td>
                        <td><?php echo $note->getCreationDateTime()->format('H:i'); ?></td>
                        <td><?php echo $note->getCreationDateTime()->format('d/m/Y'); ?></td>
                        <td class="pull-right">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" title="Edit this note" href="#" data-toggle="modal"
                                   data-target="#<?php echo $note->getID(); ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                <a class="btn btn-danger btn-xs" title="Delete this note" href="<? insertAction($base_href, 'delete'); ?>?id=<?php echo $note->getID(); ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                                <a class="btn btn-info btn-xs" title="Download this note" href="<? insertAction($base_href, 'export'); ?>?id=<?php echo $note->getID(); ?>"
                                   target="_blank">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

</body>

</html>
