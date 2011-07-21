<?php

require('top.php');

$radio = new Lib_Radio();
$stations = $radio->stations();

foreach ($stations as $group_name => &$group_stations) {
	foreach ($group_stations as &$station) {
		$s = Lib_Station_Factory::create($group_name, $station);
		
		$station = array(
			'id' => $s->id(),
			'name' => $s->name(),
			'playing' => $s->playing()
		);
	}
	
	// Destroy reference
	unset($station);
}

// Destroy reference
unset($group_stations);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Music Web Remote</title>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="refresh" content="30" />
</head>
<body>

<? foreach ($stations as $group => $group_stations): ?>
	<h2><?= ucfirst($group) ?></h2>
	
	<ul>
	<? foreach ($group_stations as $station): ?>
		<li>
			<?= $station['name'] ?>
			
			<?
				if ($station['playing']) {
					$command = 'stop';
				} else {
					$command = 'play';
				}
				
				$href = "command.php?c={$command}&amp;g={$group}&amp;s={$station['id']}";
			?>
			
			<? if ($command === 'play'): ?>
				(<a href="<?= $href ?>">Start</a>)
			<? else: ?>
				(Playing... <a href="<?= $href ?>">Stop</a>)
			<? endif ?>
		</li>
	<? endforeach ?>
	</ul>
	
<? endforeach ?>

</body>
</html>