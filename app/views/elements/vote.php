<form action="#" class="teube-vote">
	<input type="hidden" name="teube-id" value="<?php echo $teube->id ?>">
	<fieldset>
		<legend>Voter :</legend>
		<input type="radio" id="teube-vote-5" name="teube-vote" value="5" /><label for="teube-vote-5" title="C'est parfait ! Maintenant j'ai besoin d'un slip de rechange.">5</label>
		<input type="radio" id="teube-vote-4" name="teube-vote" value="4" /><label for="teube-vote-4" title="Superbe ! J'aimerai avoir la même à la maison.">4</label>
		<input type="radio" id="teube-vote-3" name="teube-vote" value="3" /><label for="teube-vote-3" title="J'ai une demi-molle bien entamée.">3</label>
		<input type="radio" id="teube-vote-2" name="teube-vote" value="2" /><label for="teube-vote-2" title="C'est dégueulasse mais ça m'excite un peu.">2</label>
		<input type="radio" id="teube-vote-1" name="teube-vote" value="1" /><label for="teube-vote-1" title="Non. NON.">1</label>
	</fieldset>
</form>