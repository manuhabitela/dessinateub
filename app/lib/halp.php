<?php
class Halp {
	/**
	 * Retourne l'image liée à une teube
	 *
	 * @param  Bean $teube objet teube de la base
	 * @param  boolean $dataURIFallback si aucune image est trouvée on peut choisir de retourner l'image encodée en base64 contenu dans la $teube
	 * @return string chemin ou data URI de l'image
	 */
	public static function drawing($teube, $dataURIFallback = false) {
		$file = "/drawings/".$teube->id.".png";
		if ($dataURIFallback && !file_exists(WEBROOT_PATH.$file) && !empty($teube->image))
			$file = $teube->image;
		return $file;
	}
}