<?php
$db = new Db;
$perm = new Gebruikers;
$session = new Session;
$prod = $_POST['prod'] ?? "";
$rating = $_POST['rating'] ?? "";
$user = $session->get('id');
if ($perm->check('user')) {
	$rat = array(':pid' => $prod, ':uid' => $user);
	$cnt = $db->select('rating', 'pid = :pid AND uid = :uid', '', $rat);
	if (!$cnt) {
		$information = array(
			"pid" 		=> $prod,
			"rating" 	=> $rating,
			"uid" 		=> $user
		);
		$db->insert("rating", $information);
		echo "Thank you for voting , You voted $rating <i class='material-icons'>star</i>";
	} else {

		$bind = array(':pid' => $prod, 'uid' => $user);
		$update = array('rating' => $rating);
		$db->update('rating', $update, "pid = :pid AND uid = :uid", $bind);
		echo " Your vote has been changed to $rating <i class='material-icons'>star</i>";
	}
} else {
	echo "Please login before voting";
}