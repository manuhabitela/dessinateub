<?php
use RedBean_Facade as R;

$app->get('/update-comments', function() use($app) {
	$posts = json_decode(file_get_contents("http://disqus.com/api/3.0/threads/list.json?api_key=" . APP_DISQUS_API . "&forum=" . APP_DISQUS_NAME), true);
	foreach ($posts['response'] as $post) {
		if ($post['isDeleted'])
			continue;
		$id = substr(strrchr($post['link'], '/'), 1);
		$teube = R::load('teube', $id);
		if (!empty($teube->id)) {
			$teube->comments_count = $post['posts'];
			R::store($teube);
		}
	}
}); ?>